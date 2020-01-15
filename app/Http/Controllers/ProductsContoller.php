<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductsContoller extends Controller
{
    public function index()
    {
        $products = Product::paginate(6);
        $cat = Product::select('type')->distinct()->get();
        $type = DB::table('products')
            ->select('type')
            ->groupBy('type')
            ->get();

        $brands = DB::table('products')
            ->select('brand')
            ->groupBy('brand')
            ->get();

        $brands = array($brands);
        $types = array($type);


        //  dd($types[0][0]->type);

        return view("particles.products", compact("products"))->with(['type' => $types, "brands" => $brands]);
    }

    public function addProductToCart(Request $request, $id)
    {

        //$request->session()->forget("cart");
        //$request->session()->flush();

        $preCart = $request->session()->get('cart');
        $cart = new Cart($preCart);

        $product = Product::find($id);

        $cart->addItem($id, $product);
        /*
        Creating the session: 
         Storing the cart object into the session storage
         */
        $request->session()->put('cart', $cart);

        return redirect()->route("AllProducts");
    }

    public function showCart()
    {
        $cart = Session::get('cart');
        //$cart = 0;

        if ($cart) {
            if ($cart->items) {
                //echo ('cart is not empty');
                //dd($cart);
                return view('cartproducts', ['cartItems' => $cart]);
            }
            //echo ('cart is empty');
            return redirect()->route('AllProducts');
        } else {
            //echo ('cart is empty');
            return redirect()->route('AllProducts');
        }
    }



    public function deleteItemFormToCart(Request $req, $id)
    {
        $cart = $req->session()->get("cart");

        if (array_key_exists($id, $cart->items)) {
            unset($cart->items[$id]);
        }

        $prevCart =  $req->session()->get("cart");
        $updatedCart = new Cart($prevCart);

        $updatedCart->updatePriceQunatity();

        //updating the session 

        $req->session()->put("cart", $updatedCart);

        if ($updatedCart) {
            //echo ('cart is not empty');
            //dd($cart);
            return redirect()->route('cartProducts');
        }
        //echo ('cart is empty');
        return redirect()->route('AllProducts');
    }

    //get the Pgory products
    public function getCategoryProducts($cat)
    {

        $products = Product::where('type', $cat)->paginate(10);
        $cat = Product::select('type')->distinct()->get();
        $type = DB::table('products')
            ->select('type')
            ->groupBy('type')
            ->get();

        $types = array($type);


        $brand = DB::table('products')
            ->select('brand')
            ->groupBy('brand')
            ->get();

        $brand = array($brand);


        //  dd($types[0][0]->type);

        return view("particles.products", compact("products"))->with(['type' => $types, 'brands' => $brand]);
    }



    public function getBrandsProducts($brand)
    {


        $products = Product::where('brand', $brand)->paginate(10);

        $type = DB::table('products')
            ->select('type')
            ->groupBy('type')
            ->get();

        $types = array($type);

        $brand = DB::table('products')
            ->select('brand')
            ->groupBy('brand')
            ->get();

        $brand = array($brand);




        //  dd($types[0][0]->type);

        return view("particles.products", compact("products"))->with(['type' => $types, 'brands' => $brand]);
    }

    //search for the product
    public function searchForProduct(Request $req)
    {
        $cat = Product::select('type')->distinct()->paginate(10);
        $type = DB::table('products')
            ->select('type')
            ->groupBy('type')
            ->get();

        $brand = DB::table('products')
            ->select('brand')
            ->groupBy('brand')
            ->get();

        $brand = array($brand);
        $types = array($type);
        $searchText =  $req->get('searchText');
        $products = Product::where('name', "Like", $searchText . "%")->paginate(10);
        return view("particles.products", compact("products"))->with(['type' => $types, "brands" => $brand]);
    }

    public function increaseSingleProduct(Request $req, $id)
    {
        $preCart = $req->session()->get('cart');
        $cart = new Cart($preCart);

        $product = Product::find($id);
        $cart->addItem($id, $product);
        $req->session()->put('cart', $cart);

        return redirect()->route("cartProducts");
    }

    public function decreaseSingleProduct(Request $req, $id)
    {
        $preCart = $req->session()->get('cart');
        $cart = new Cart($preCart);

        if ($cart->items[$id]['quantity'] > 1) {
            $product = Product::find($id);
            $cart->items[$id]['quantity'] = $cart->items[$id]['quantity'] - 1;
            $cart->items[$id]['totalSinglePrice'] = $cart->items[$id]['quantity'] * $product['price'];
            $cart->updatePriceQunatity();

            $req->session()->put('cart', $cart);
        }

        return redirect()->route("cartProducts");
    }



    //Return individual product page 
    public function getProduct($id)
    {
        $product = Product::find($id);

        $type = DB::table('products')
            ->select('type')
            ->groupBy('type')
            ->get();

        $brands = DB::table('products')
            ->select('brand')
            ->groupBy('brand')
            ->get();

        $brands = array($brands);
        $types = array($type);




        return view("particles.product", compact("product"))->with(['type' => $types, "brands" => $brands]);
    }


    public function createOrder()
    {
        $cart = Session::get('cart');

        if ($cart) {
            $date = date('y-m-d H:i:s');
            $newOrderArray = array("status" => "on_hold", "date" => $date, "del_date" => $date, "price" => $cart->totalPrice);
            $created_order = DB::table("orders")->insert($newOrderArray);
            $order_id = DB::getPdo()->lastInsertId();

            foreach ($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $newItemsInCurrentOrder = array("item_id" => $item_id, "order_id" => $order_id, "item_name" => $item_name, "item_price" => $item_price);

                //check if it was inserted into the database
                $created_order_items = DB::table('order_items')->insert($newItemsInCurrentOrder);
            }

            //delete cart 
            Session::forget("cart");


            return redirect()->route("AllProducts")->withsuccess("Thanks for purchasing from AlphaReact");
        } else {
            return redirect()->route("AllProducts");
        }
    }

    public function checkoutProducts()
    {
        return view('checkoutproducts');
    }

    public function createNewOrder(Request $req)
    {


        $cart = Session::get('cart');

        $this->validate($req, [
            "email" => 'required|string|email|max:255',
            "first_name" => 'required|string',
            "last_name" =>  'required|string',
            "address" => 'required|string|max:255',
            "zip" => 'required|int',
            "phone" => 'required|regex:/^[0-9]{7,15}$/'

        ]);



        $first_name = $req->input('first_name');
        $address = $req->input('address');
        $last_name = $req->input('last_name');
        $zip = $req->input('zip');
        $phone = $req->input('phone');
        $email = $req->input('email');


        //check if the user is logged in 
        if (Auth::check()) {
            //user is login 
            $user_id  = Auth::user()->id;
        } else {

            //user is a guested
            $user_id = 0;
        }


        if ($cart) {
            $date = date('y-m-d H:i:s');
            $newOrderArray = array(
                "status" => "on_hold", "date" => $date, "del_date" => $date,
                "price" => $cart->totalPrice, "first_name" => $first_name,
                "address" => $address, "last_name" => $last_name, "zip" => $zip,
                "phone" => $phone, "email" => $email, "phone" => $phone,
                "user_id" => $user_id
            );



            $created_order = DB::table("orders")->insert($newOrderArray);
            $order_id = DB::getPdo()->lastInsertId();

            foreach ($cart->items as $cart_item) {
                $item_id = $cart_item['data']['id'];
                $item_name = $cart_item['data']['name'];
                $item_price = $cart_item['data']['price'];
                $newItemsInCurrentOrder = array("item_id" => $item_id, "order_id" => $order_id, "item_name" => $item_name, "item_price" => $item_price);

                //check if it was inserted into the database
                $created_order_items = DB::table('order_items')->insert($newItemsInCurrentOrder);
            }



            //send email 



            //delete cart 
            Session::forget("cart");


            $payment_info = $newOrderArray;
            $payment_info['order_id'] = $order_id;
            $req->session()->put('payment_info', $payment_info);






            //print_r($newOrderArray);
            return redirect()->route("showPaymentPage");
        } else {

            print_r('error');
            //return redirect()->route("AllProducts");
        }
    }

    private function sendMail()
    {
        $user = Auth::user();
        $cart = Session::get('cart');

        if ($cart != null && $user != null) {

            Mail::to($user)->send(new OrderShipped($cart));
        }
    }
}