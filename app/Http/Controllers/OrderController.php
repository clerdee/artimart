<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Mail\SendOrderStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderUpdate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function processOrder($id)
    {
        $customer = DB::table('customer as c')
            ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
            ->where('o.orderinfo_id', $id)
            ->select('c.lname', 'c.fname', 'c.addressline', 'c.phone', 'o.orderinfo_id',  'o.status', 'o.date_placed')
            ->first();

        $orders = DB::table('customer as c')
            ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
            ->join('shipping as s', 'o.shipping_id', '=', 's.shipping_id')
            ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item as i', 'ol.item_id', '=', 'i.item_id')
            ->leftJoin('item_images as img', 'i.item_id', '=', 'img.item_id')
            ->where('o.orderinfo_id', $id)
            ->select(
                'i.item_id',
                'i.description',
                'ol.quantity',
                'i.sell_price',
                's.region as shipping_region',
                's.rate as shipping_rate'
            )
            ->groupBy(
                'i.item_id',
                'i.description',
                'ol.quantity',
                'i.sell_price',
                's.region',
                's.rate'
            )
            ->get();


        $total = $orders->map(function ($item) {
            return $item->sell_price * $item->quantity;
        })->sum();

        $images = DB::table('item_images')->get()->groupBy('item_id');

        $status = DB::table('orderinfo')
            ->where('orderinfo_id', $id)
            ->value('status');

        $enumColumn = DB::select("SHOW COLUMNS FROM orderinfo WHERE Field = 'status'");
        preg_match('/^enum\((.*)\)$/', $enumColumn[0]->Type, $matches);
        $statusChoices = [];
        if (isset($matches[1])) {
            foreach (explode(',', $matches[1]) as $value) {
                $statusChoices[] = trim($value, "'");
            }
        }

        $shippingRegion = $orders->isNotEmpty() ? $orders[0]->shipping_region : 'N/A';
        $shippingRate = $orders->isNotEmpty() ? $orders[0]->shipping_rate : 0;


        return view('order.processOrder', compact(
            'customer',
            'orders',
            'total',
            'images',
            'status',
            'statusChoices',
            'shippingRegion',
            'shippingRate'
        ));
    }


    public function orderUpdate(Request $request, $id)
    {
        $updateData = [
            'status' => $request->status
        ];

        if (strtolower($request->status) === 'shipped') {
            $updateData['date_shipped'] = Carbon::now()->toDateString();
        }

        if (strtolower($request->status) === 'delivered') {
            $updateData['date_delivered'] = Carbon::now()->toDateString();
        }

        $order = Order::where('orderinfo_id', $id)->update($updateData);

        if ($order > 0) {
            $myOrder = DB::table('customer as c')
                ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
                ->join('shipping as s', 'o.shipping_id', '=', 's.shipping_id')
                ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
                ->join('item as i', 'ol.item_id', '=', 'i.item_id')
                ->leftJoin('item_images as img', 'i.item_id', '=', 'img.item_id')
                ->where('o.orderinfo_id', $id)
                ->select(
                    'c.user_id',
                    'ol.item_id',
                    'i.item_name',
                    'i.description',
                    'ol.quantity',
                    'img.image_path',
                    'i.sell_price',
                    's.region as shipping_region',
                    's.rate as shipping_rate'
                )
                ->get();

            $orderInfo = DB::table('orderinfo')->where('orderinfo_id', $id)->first();

            $user = DB::table('users as u')
                ->join('customer as c', 'u.id', '=', 'c.user_id')
                ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
                ->where('o.orderinfo_id', $id)
                ->select('u.id', 'u.email', 'u.name', 'c.addressline', 'c.town', 'c.phone')
                ->first();

            $subtotal = $myOrder->sum(function ($item) {
                return $item->quantity * $item->sell_price;
            });

            $shippingRate = $myOrder->isNotEmpty() ? $myOrder[0]->shipping_rate : 0;
            $grandTotal = $subtotal + $shippingRate;

            Mail::to($user->email)->send(new OrderUpdate($orderInfo, $myOrder, $user, $grandTotal));

            return redirect()->route('admin.orders')->with('success', 'Order updated successfully!');
        }

        return redirect()->route('admin.orders')->with('error', 'Order update failed or email not sent.');
    }

    public function myOrders(Request $request)
    {
        $userId = Auth::id();
        $activeTab = $request->get('status', 'all');

        $query = DB::table('orderinfo as o')
            ->join('customer as c', 'c.customer_id', '=', 'o.customer_id')
            ->leftJoin('shipping as s', 's.shipping_id', '=', 'o.shipping_id')
            ->where('c.user_id', $userId)
            ->select(
                'o.orderinfo_id',
                'o.status',
                'o.date_placed',
                's.region as shipping_method',
                's.rate as shipping_rate'
            );

        if ($activeTab !== 'all') {
            $query->where('o.status', $activeTab);
        }

        $orders = $query->orderBy('o.orderinfo_id', 'desc')->get();

        $statusCounts = DB::table('orderinfo as o')
            ->join('customer as c', 'c.customer_id', '=', 'o.customer_id')
            ->where('c.user_id', $userId)
            ->select('o.status', DB::raw('count(*) as count'))
            ->groupBy('o.status')
            ->pluck('count', 'status')
            ->toArray();

        $statusCounts['all'] = array_sum($statusCounts);

        foreach ($orders as $order) {
            if (!isset($order->shipping_method)) {
                $order->shipping_method = 'Standard Shipping';
            }
            if (!isset($order->shipping_rate)) {
                $order->shipping_rate = 0;
            }

            // Get order items
            $orderItems = DB::table('orderline as ol')
                ->join('item as i', 'ol.item_id', '=', 'i.item_id')
                ->where('ol.orderinfo_id', $order->orderinfo_id)
                ->select(
                    'i.item_id',
                    'i.item_name',
                    'i.description',
                    'ol.quantity',
                    'i.sell_price'
                )
                ->get();

            $itemsWithImages = collect();

            foreach ($orderItems as $item) {
                // Get the first available image for each item
                $image = DB::table('item_images')
                    ->where('item_id', $item->item_id)
                    ->whereNull('deleted_at')
                    ->select('image_path')
                    ->first();

                $item->image_path = $image ? $image->image_path : null;

                $itemsWithImages->push($item);
            }

            $order->items = $itemsWithImages;

            $order->subtotal = $order->items->sum(function ($item) {
                return $item->sell_price * $item->quantity;
            });

            $order->total = $order->subtotal + $order->shipping_rate;
        }

        return view('order.index', compact('orders', 'activeTab', 'statusCounts'));
    }

    public function cancel($orderId)
    {
        $order = DB::table('orderinfo')->where('orderinfo_id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        DB::table('orderinfo')
            ->where('orderinfo_id', $orderId)
            ->update(['status' => 'Cancelled']);

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }
}
