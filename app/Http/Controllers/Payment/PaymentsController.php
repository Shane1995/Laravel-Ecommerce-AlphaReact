<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    public function showPaymentPage()
    {
        $payment_info = Session::get('payment_info');



        //has not paid
        if ($payment_info['status'] == 'on_hold') {
            return view('payment.paymentpage', ['payment_info' => $payment_info]);
        } else {
            return redirect()->route("AllProducts");
        }
    }

    public function showPaymentReceipt($paypalPaymentID, $paypalPayerID)
    {

        if (!empty($paypalPaymentID) && !empty($paypalPayerID)) {
            //will return json -> contains transaction status
            // $this->validate_payment($paypalPaymentID, $paypalPayerID);

            $this->storePaymentInfo($paypalPaymentID, $paypalPayerID);

            $payment_receipt = Session::get('payment_info');




            $payment_receipt['paypal_payment_id'] = $paypalPaymentID;
            $payment_receipt['paypal_payer_id'] = $paypalPayerID;

            //remove session

            //delete payment_info from session
            Session::forget("payment_info");


            //return and pass relevant info

            return view('payment.paymentreceipt', ['payment_receipt' => $payment_receipt]);
        } else {


            return redirect()->route("allProducts");
        }
    }



    public function getUserOrder()
    {
        $orders = DB::table('orders')->where("user_id", "=", Auth::user()->id)->paginate(10);
        //print_r($orders);


        return view('orderHistory', ['orders' => $orders]);
    }


    public function orderItems($id)
    {
        $orders = DB::table('order_items')->where("order_id", "=", $id)->paginate(10);
        //print_r($orders);


        return view('orderItems', ['orders' => $orders]);
    }




    private function storePaymentInfo($paypalPaymentID, $paypalPayerID)
    {



        $payment_info = Session::get('payment_info');

        $order_id = $payment_info['order_id'];
        $status = $payment_info['status'];
        $paypal_payment_id = $paypalPaymentID;
        $paypal_payer_id = $paypalPayerID;


        if ($status == 'on_hold') {

            //create (issue) a new payment row in payments table
            $date = date('Y-m-d H:i:s');
            $newPaymentArray = array(
                "order_id" => $order_id, "date" => $date, "amount" => $payment_info['price'],
                "paypal_payment_id" => $paypal_payment_id, "paypal_payer_id" => $paypal_payer_id
            );

            $created_order = DB::table("payments")->insert($newPaymentArray);


            //update payment status in orders table to "paid"

            DB::table('orders')->where('order_id', $order_id)->update(['status' => 'paid']);
        }
    }



    // works on paid server 
    private function validate_payment($paypalPaymentID, $paypalPayerID)
    {

        $paypalEnv       = 'sandbox'; // Or 'production'
        $paypalURL       = 'https://api.sandbox.paypal.com/v1/'; //change this to paypal live url when you go live
        $paypalClientID  = 'AWpHSg6rKcDOGHryouTvu33Y_ZWnZNka3RLjOdOJ-_r9aazeiewLkJKUtftNmLtsVjb25k59aUOAIexq';
        $paypalSecret   = 'ECyByuIpPCAOeGxX1cEq4s0ZIopqkBOa2YI6km9V98J88L8A2-H9Mlm8XWKvxAj0mUdJdO57F3BrWXxZ';



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypalURL . 'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID . ":" . $paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            return false;
        } else {
            $jsonData = json_decode($response);
            $curl = curl_init($paypalURL . 'payments/payment/' . $paypalPaymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            // Transaction data
            $result = json_decode($response);

            return $result;
        }
    }


    public function getPaymentInfoByOrderId($order_id)
    {
        $paymentInfo = DB::table('payments')->where('order_id', $order_id)->get();

        return json_encode($paymentInfo[0]);
    }
}