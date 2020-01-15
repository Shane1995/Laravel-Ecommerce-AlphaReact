<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Double;

class Cart extends Model
{

    public $items; // ['id'=> ['quantity'=>, 'price'=>, 'data'=>, ]]
    public $totalQuantity; // sum of quantity 
    public $totalPrice; // sum of the total prices 

    public function __construct($prevCart)
    {
        if ($prevCart != null) {
            $this->items = $prevCart->items;
            $this->totalQuantity = $prevCart->totalQuantity;
            $this->totalPrice = $prevCart->totalPrice;
        } else {
            $this->items = [];
            $this->totalQuantity = 0;
            $this->totalPrice = 0;
        }
    }


    public function addItem($id, $product)
    {

        //convert the price back to an integer
        $price = (int) str_replace("R", "", $product->price);

        //Check if the product already exists
        if (array_key_exists($id, $this->items)) {

            //Increase the quantity 
            $productToAdd = $this->items[$id];
            $productToAdd['quantity']++;
            $productToAdd['totalSinglePrice'] = (float)  $productToAdd['totalSinglePrice'] + $price;
        } else {
            $productToAdd = ['quantity' => 1, 'totalSinglePrice' => $price, 'data' => $product];
        }

        $this->items[$id] = $productToAdd;
        $this->totalQuantity++;
        $this->totalPrice = $this->totalPrice + $price;
    }


    public function updatePriceQunatity()
    {
        $totalPrice = 0;
        $totalQuantity = 0;

        foreach ($this->items as $item) {
            $totalQuantity = $totalQuantity + $item['quantity'];
            $totalPrice = $totalPrice + $item['totalSinglePrice'];
        }

        $this->totalPrice = $totalPrice;
        $this->totalQuantity = $totalQuantity;
    }
}