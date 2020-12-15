<?php


namespace App;
use App\Item;

class Cart
{
    private array $items;
    private int $totalItems;
    private float $totalPrice;
    public int $certainQuantity=0;


    public function __construct($items=null,$totalItems=0,$totalPrice=0){
        if ($items)
            $this->items=$items;
        else
            $this->items=[];

        $this->totalItems=$totalItems;
        $this->totalPrice=$totalPrice;
    }

    private function searchForProductInCart($product){
        foreach ($this->items as $index => $item){
            if ($item->id == $product->id)
                return $index;
        }
        return false;
    }

    public function addToCart($product){
        $response=$this->searchForProductInCart($product);
        if ($response === false){
            // product not found in cart
            $item=new Item();
            $item->price=$product->price;
            $item->id   =$product->id;
            $item->name =$product->name;
            $item->slug =$product->slug;
            $item->image=$product->mainImage();

            if ($this->certainQuantity>0){
                $item->qty  =$this->certainQuantity;
            }else{
                $item->qty  =1;
            }

            array_push($this->items,$item);
            $this->totalItems=$this->totalItems+$item->qty;
            $this->totalPrice=$this->totalPrice+($item->price*$item->qty);
        }else{
            // product in cart
            $item=$this->items[$response];
            if ($this->certainQuantity>0){
                $this->removeFromCart($product);
                $item->price=$product->price;
                $item->id   =$product->id;
                $item->name =$product->name;
                $item->slug =$product->slug;
                $item->image=$product->mainImage();
                $item->qty  =$this->certainQuantity;
                array_push($this->items,$item);
                $this->totalItems=$this->totalItems+$item->qty;
                $this->totalPrice=$this->totalPrice+($item->price*$item->qty);
            }else{
                $item->qty=$item->qty+1;
                $this->totalPrice=$this->totalPrice+$item->price;
                $this->totalItems=$this->totalItems+1;
            }


        }
        return true;
    }

    public function removeFromCart($product){
        $response=$this->searchForProductInCart($product);
        if ($response === false){
            // product not found in cart
            return false;
        }else{
            // product in cart
            $item=$this->items[$response];
            unset($this->items[$response]);
            $this->totalPrice=$this->totalPrice-($item->price*$item->qty);
            $this->totalItems=$this->totalItems-$item->qty;
            return true;
        }

    }

    public function getItems(){
        return $this->items;
    }

    public function getTotalPrice(){
        return $this->totalPrice;
    }

    public function getTotalItems(){
        return $this->totalItems;
    }
}
