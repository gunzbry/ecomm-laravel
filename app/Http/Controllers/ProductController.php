<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;

use Session;

class ProductController extends Controller
{
    function index(){
        $data = Product::all();
        return view('product', ['products' => $data]);
    }

    function detail($id){
        $data = Product::find($id);
        return view('detail', ['product' => $data]);
    }

    function search(Request $req){
        $data_trending = Product::all();

        $data = Product::where
                ('name' , 'LIKE' , '%'.$req->input('query').'%')
                ->get();

        return view('search', 
                    [
                        'data_trending' => $data_trending,
                        'products' => $data
                    ]);

    }

    function add_to_cart(Request $req){
        if($req->session()->has('user')){
            $cart = new Cart();
            $cart->user_id = $req->session()->get('user')['id'];
            $cart->product_id = $req->product_id;
            $cart->save();
            return redirect('/');
        }else{
            return redirect('login');
        }
    }

    static function cartItem(){
        $userId = Session::get('user')['id'];
        return Cart::where('user_id', $userId)->count();
    }

    function cart_list(){
        $userId = Session::get('user')['id'];

        $products = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->where('cart.user_id', $userId)
        ->select('products.*', 'cart.id as cart_id')
        ->get();

        return view('cartlist', ['products'=>$products]);
    }

    function remove_from_cart($id){
        Cart::destroy($id);
        return redirect('cart_list');
    }

    function orderNow(){
        $userId = Session::get('user')['id'];

        $total = DB::table('cart')
        ->join('products', 'cart.product_id', '=', 'products.id')
        ->where('cart.user_id', $userId)
        ->sum('products.price');

        return view('ordernow', ['total'=>$total]);
    }

    function orderPlace(Request $req){
        $userId = Session::get('user')['id'];
        $allCart = Cart::where('user_id', $userId)->get();

        // Cart items > Orders
        foreach($allCart as $cart){
            $order = new Order;
            $order->product_id=$cart['product_id'];
            $order->user_id=$userId;
            $order->status="pending";
            $order->payment_method=$req->payment;
            $order->payment_status="pending";
            $order->address=$req->address;
            $order->save();
        }
        // remove from Cart
        Cart::where('user_id', $userId)->delete();

        return redirect('/');
    }

    function myOrders(){
        $userId = Session::get('user')['id'];

        $orders = DB::table('orders')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('orders.user_id', $userId)
        ->get();  
        
        return view('myorders', ['orders'=>$orders]);
    }
}
