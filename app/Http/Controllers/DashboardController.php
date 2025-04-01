<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\DataTables\ItemsDataTable;
use Illuminate\Http\Request;
use App\DataTables\OrdersDataTable;
use App\DataTables\UsersDataTable;
use App\Charts\CustomerChart;
use App\Charts\SalesChart;
use App\DataTables\ReviewsDataTable;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Item;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        // 1. Customer Demographics Chart
        $customer = DB::table('customer')
            ->whereNotNull('addressline')
            ->select(DB::raw('count(addressline) as total'), 'addressline')
            ->groupBy('addressline')
            ->orderBy('total', 'desc')
            ->pluck('total', 'addressline')
            ->all();

        $customerChart = new CustomerChart;
        $customerChart->labels(array_keys($customer));
        $customerChart->dataset('Customer Demographics', 'bar', array_values($customer))
            ->backgroundColor(['#7158e2', '#3ae374', '#ff3838']);

        $customerChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [['display' => true]],
                'xAxes' => [['gridLines' => ['display' => false], 'display' => true]]
            ]
        ]);

        // 2. Total Stats
        $totalOrders = Order::count();
        $totalUsers = User::count();

        // 3. Yearly Sales Chart
        $orderTotals = DB::table('orderinfo')
            ->join('shipping', 'orderinfo.shipping_id', '=', 'shipping.shipping_id')
            ->join('orderline', 'orderinfo.orderinfo_id', '=', 'orderline.orderinfo_id')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->select(
                'orderinfo.orderinfo_id',
                DB::raw('YEAR(orderinfo.date_placed) as year'),
                DB::raw('SUM(orderline.quantity * item.sell_price) as item_total'),
                'shipping.rate'
            )
            ->whereIn('orderinfo.status', ['shipped', 'delivered']) 
            ->groupBy('orderinfo.orderinfo_id', 'year', 'shipping.rate')
            ->get();

        $yearlySales = [];
        foreach ($orderTotals as $row) {
            $yearlySales[$row->year] = ($yearlySales[$row->year] ?? 0) + ($row->item_total + $row->rate);
        }

        $yearChart = new SalesChart;
        $yearChart->labels(array_keys($yearlySales));
        $yearChart->dataset('Yearly Sales', 'bar', array_values($yearlySales))
            ->backgroundColor('#3498db');


        // 4. Monthly Sales Chart
        $monthlyOrders = DB::table('orderinfo')
            ->join('shipping', 'orderinfo.shipping_id', '=', 'shipping.shipping_id')
            ->join('orderline', 'orderinfo.orderinfo_id', '=', 'orderline.orderinfo_id')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->select(
                DB::raw("DATE_FORMAT(orderinfo.date_placed, '%Y-%m') as month"),
                DB::raw('SUM(orderline.quantity * item.sell_price) as item_total'),
                'orderinfo.orderinfo_id',
                'shipping.rate'
            )
            ->whereIn('orderinfo.status', ['shipped', 'delivered'])
            ->groupBy('orderinfo.orderinfo_id', 'month', 'shipping.rate')
            ->get();

        $monthlySales = [];
        foreach ($monthlyOrders as $row) {
            $monthlySales[$row->month] = ($monthlySales[$row->month] ?? 0) + ($row->item_total + $row->rate);
        }

        $monthChart = new SalesChart;
        $monthChart->labels(array_keys($monthlySales));
        $monthChart->dataset('Monthly Sales', 'line', array_values($monthlySales))
            ->backgroundColor('#2ecc71');


        // 5. Sales Bar Chart (Date Range)
        $startDate = $request->start_date ?? now()->subMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $rangeOrders = DB::table('orderinfo')
            ->join('shipping', 'orderinfo.shipping_id', '=', 'shipping.shipping_id')
            ->join('orderline', 'orderinfo.orderinfo_id', '=', 'orderline.orderinfo_id')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->select(
                DB::raw('DATE(orderinfo.date_placed) as date'),
                DB::raw('SUM(orderline.quantity * item.sell_price) as item_total'),
                'orderinfo.orderinfo_id',
                'shipping.rate'
            )
            ->whereBetween('orderinfo.date_placed', [$startDate, $endDate])
            ->whereIn('orderinfo.status', ['shipped', 'delivered'])
            ->groupBy('orderinfo.orderinfo_id', 'date', 'shipping.rate')
            ->get();

        $rangeSales = [];
        foreach ($rangeOrders as $row) {
            $rangeSales[$row->date] = ($rangeSales[$row->date] ?? 0) + ($row->item_total + $row->rate);
        }

        $rangeChart = new SalesChart;
        $rangeChart->labels(array_keys($rangeSales));
        $rangeChart->dataset("Sales From $startDate to $endDate", 'bar', array_values($rangeSales))
            ->backgroundColor('#f39c12');


        // 6. Pie Chart - Product Contribution to Sales
        $productSales = DB::table('orderline')
            ->join('item', 'orderline.item_id', '=', 'item.item_id')
            ->join('orderinfo', 'orderline.orderinfo_id', '=', 'orderinfo.orderinfo_id')
            ->whereIn('orderinfo.status', ['shipped', 'delivered'])
            ->select('item.item_name', DB::raw('SUM(orderline.quantity * item.sell_price) as total'))
            ->groupBy('item.item_name')
            ->pluck('total', 'item.item_name')
            ->all();

        $pieChart = new SalesChart;
        $pieChart->labels(array_keys($productSales));
        $pieChart->dataset('Product Sales Contribution', 'pie', array_values($productSales))
            ->backgroundColor(['#e74c3c', '#8e44ad', '#27ae60', '#f1c40f', '#2980b9', '#e67e22']);

        // 7. Return View
        return view('dashboard.index', compact(
            'totalOrders',
            'totalUsers',
            'customerChart',
            'yearChart',
            'monthChart',
            'rangeChart',
            'pieChart',
            'startDate',
            'endDate'
        ));
    }


    public function getUsers(UsersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.users');
    }

    public function getOrders(OrdersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.orders');
    }

    public function getReviews(ReviewsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.reviews');
    }

    public function getItems(ItemsDataTable $dataTable)
    {
        return $dataTable->render('dashboard.items');
    }

    public function getCategories(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.categories');
    }
}
