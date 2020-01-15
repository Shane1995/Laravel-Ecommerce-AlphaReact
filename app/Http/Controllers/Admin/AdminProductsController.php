<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdminProductsController extends Controller
{
    //display all the products 
    public function index()
    {
        $products = Product::paginate(10);
        return view("admin.displayProducts", ['products' => $products]);
    }

    //display edit product form
    public function editProductForm($id)
    {
        $product = Product::find($id);
        return view('admin.editProductForm', ['product' => $product]);
    }

    //display edit product Image form
    public function editProductImageForm($id)
    {
        $product = Product::find($id);
        return view('admin.editProductImageForm', ['product' => $product]);
    }

    //update product image
    public function updateProductImage(Request $req, $id)
    {
        //valid the image input and the type of extension 
        Validator::make($req->all(), ['image' => "required|image|mimes:png,jpg,jpeg|max:5000"])->validate();

        //extra layer of validation 
        if ($req->hasFile('image')) {
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists("public/products_images/" . $product->image);

            //delete old image 
            if ($exists) {
                Storage::delete('public/products_images/' . $product->image);
            }

            // upload the new image
            $ext =  $req->file('image')->getClientOriginalExtension(); // gets the extension of the image
            $req->image->storeAS("public/products_images/", $product->image);

            $arrayToUpdate = array('image' => $product->image);
            DB::table('products')->where('id', $id)->update($arrayToUpdate);
            return redirect()->route('adminDisplayProducts');
        } else {
            $error = "NO image was selected";
            return $error;
        }
    }

    //update the product details 
    public function updateProduct(Request $req, $id)
    {

        $this->validate($req, [

            "name" => 'required|string',
            "description" => 'required|string',
            "price" => 'required|int',

            "brand" => 'required|string|max:15',
            "type" => 'required|string|max:15',

        ]);

        $name = $req->input('name');
        $description = $req->input('description');
        $price = $req->input('price');
        $brand = $req->input('brand');
        $type = strtoupper($req->input('type'));

        $updateArray = array(
            "name" => $name,
            "description" => $description, "price" => $price,
            'type' => $type, "brand" => $brand
        );
        DB::table('products')->where('id', $id)->update($updateArray);

        return redirect()->route("adminDisplayProducts");
    }


    public function createProductForm()
    {
        return view('admin.createProductForm');
    }

    //send new product to database
    public function sendCreateProductForm(Request $req)
    {
        $this->validate($req, [

            "name" => 'required|string',
            "description" => 'required|string',
            "price" => 'required|regex:/^\d+(\.\d{1,2})?$/',

            "brand" => 'required|string|max:15',
            "type" => 'required|string|max:15',

        ]);
        $name = $req->input('name');
        $description = $req->input('description');
        $brand = $req->input('brand');
        $price = $req->input('price');
        $type = strtoupper($req->input('type'));

        //valid the image input and the type of extension 
        Validator::make($req->all(), ['image' => "required|image|mimes:png,jpg,jpeg|max:5000"])->validate();
        $ext =  $req->file('image')->getClientOriginalExtension();

        //eliminates the spaces and gets the image name the name of the product
        $stringImageReFormat = str_replace(" ", "", $req->input("name"));
        $imageName = $stringImageReFormat . "." . $ext;

        //encode the image with the server 
        $imageEncoded = File::get($req->image);
        Storage::disk('local')->put('public/products_images/' . $imageName, $imageEncoded);

        $newProductArray = array(
            "name" => $name,
            "description" => $description, "image" => $imageName,
            "price" => $price, 'type' => $type, "brand" => $brand
        );
        DB::table('products')->insert($newProductArray);

        return redirect()->route('adminDisplayProducts');
    }

    //delete product 
    public function deleteProduct($id)
    {
        //used for deleting the image
        $product = Product::find($id);

        $exists = Storage::disk('local')->exists("public/products_images/" . $product->image);
        if ($exists) {
            //deletes the image from the server
            Storage::delete('public/products_images/' . $product->image);
        }

        //deletes the data of the product (not the image)
        Product::destroy($id);

        return redirect()->route('adminDisplayProducts');
    }



    //orders control panel (display all orders)

    public function ordersPanel()
    {

        $orders = DB::table('orders')->paginate(10);
        //print_r($orders);
        return view('admin.ordersPanel', ["orders" => $orders]);
    }



    public function deleteOrder(Request $request, $id)
    {

        $deleted =  DB::table('orders')->where("order_id", $id)->delete();


        if ($deleted) {
            return redirect()->back()->with('orderDeletionStatus', 'Order ' . $id . ' was successfully deleted');
        } else {

            return redirect()->back()->with('orderDeletionStatus', 'Order ' . $id . ' was NOT deleted');
        }
    }


    //display edit order form
    public function editOrderForm($order_id)
    {

        $order =  DB::table('orders')->where("order_id", $order_id)->get();

        return view('admin.editOrderForm', ['order' => $order[0]]);
    }

    //update order fields (status,date,....)
    public function updateOrder(Request $request, $order_id)
    {

        $date =  $request->input('date');
        $del_date =  $request->input('del_date');
        $status = $request->input('status');
        $price = $request->input('price');

        $updateArray = array("date" => $date, "del_date" => $del_date, "status" => $status, "price" => $price);

        DB::table('orders')->where('order_id', $order_id)->update($updateArray);

        return redirect()->route("ordersPanel");
    }



    //displaying the Users 
    public function displayUser()
    {
        $users = User::all();

        return view('admin.displayUsers', ['users' => $users]);
    }

    //displaying the user's orders 
    public function displayUserOrder($id)
    {
        $orders = DB::table('orders')->where("user_id", "=", $id)->paginate(10);
        return view('admin.displayUserOrders', ['orders' => $orders]);
    }


    public function displayItems($id)
    {
        $orders = DB::table('order_items')->where("order_id", "=", $id)->paginate(10);
        //print_r($orders);


        return view('admin.displayOrderedItems', ['orders' => $orders]);
    }

    public function addAdmin($id)
    {
        DB::table('users')->where('id', $id)->update(["admin" => 1]);
        return redirect()->route("displayUser");
    }

    public function removeAdmin($id)
    {
        DB::table('users')->where('id', $id)->update(["admin" => 0]);
        return redirect()->route("displayUser");
    }

    public function removeUser($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route("displayUser");
    }

    public function analytics()
    {
        return view('admin.analytics');
    }

    public function shipOrder($id)
    {
        DB::table('orders')->where('order_id', $id)->update(["status" => "Shipped"]);
        return redirect()->route('ordersPanel');
    }
}