<?php

namespace App;

class Cart
{
    public $items = [];
    public $totalQuantity = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items ?? [];
            $this->totalQuantity = $oldCart->totalQuantity ?? 0;
            $this->totalPrice = $oldCart->totalPrice ?? 0;
        }
    }

    public function add($item, $id)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];

        if (isset($this->items[$id])) {
            $storedItem = $this->items[$id];
        }

        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;

        $this->totalQuantity++;
        $this->totalPrice += $item->price;
    }

    public function count()
    {
        return count($this->items);
    }

    public function remove($id)
    {
        if (isset($this->items[$id])) {
            $this->totalPrice -= $this->items[$id]['price'];
            unset($this->items[$id]);
        }
    }

}
