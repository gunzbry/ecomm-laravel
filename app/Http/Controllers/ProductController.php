<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Validator;

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

    // GET API : http://ecomm.test/api/list
    function getProducts(){
        $data = Product::all();
        return ["data"=>$data];
    }

    // POST API : http://ecomm.test/api/saveproduct
    // content-type : application/json
    // {
    //     "name" : "Akko Mechanical Keyboard",
    //     "price" : "334",
    //     "category" : "keyboard",
    //     "description" : "Brown switch or Red switch will be given based on availability",
    //     "gallery" : "https://my-live-01.slatic.net/p/a8d8606fa10b46bbf72073a017389244.jpg_2200x2200q80.jpg"
    // }
    function setProducts(Request $req){
        // Validation rules (required, chars >2 < 50)
        $rules = array(
            "name" => "required|min:2|max:50"
        );
        $validator=Validator::make($req->all(), $rules);

        if($validator->fails()){
            // return $validator->errors();
            return response()->json($validator->errors(), 401);
        }else{
            $product = new Product;
            $product->name = $req->name;
            $product->price = $req->price;
            $product->category = $req->category;
            $product->description = $req->description;
            $product->gallery = $req->gallery;
            $result = $product->save();
    
            if($result){
                return ["result"=>"Data has been saved!"];
            }else{
                return ["result"=>"Operation failed. Please re-check the fields."];
            }
        }
    }

    // PUT API : http://ecomm.test/api/updateproduct
    // content-type : application/json
    // {
    //     "id" : 6,
    //     "name" : "Akko Mechanical Keyboard",
    //     "price" : "336",
    //     "category" : "keyboard",
    //     "description" : "Brown switch or Red switch will be given based on availability<br>(Red Switch Available!)",
    //     "gallery" : "https://my-live-01.slatic.net/p/a8d8606fa10b46bbf72073a017389244.jpg_2200x2200q80.jpg"
    // }
    function updateProducts(Request $req){
        $product = Product::find($req->id);
        if($product){
            $product->name = $req->name;
            $product->price = $req->price;
            $product->category = $req->category;
            $product->description = $req->description;
            $product->gallery = $req->gallery;
            $result = $product->save();
    
            if($result){
                return ["result"=>"Data is updated!"];
            }else{
                return ["result"=>"Operation failed. Please re-check the fields."];
            }
        }else{
            return ["result"=>"Product not found."];
        }
    }

    // DELETE API : http://ecomm.test/api/deleteproduct/6
    // content-type : application/json
    function deleteProducts($id){
        $product = Product::find($id);
        if($product){
            $result = $product->delete();

            if($result){
                return ["result"=>"Data is Deleted!"];
            }else{
                return ["result"=>"Operation failed. Please re-check the fields."];
            }
        }else{
            return ["result"=>"Product not found."];
        }
    }

    // GET API : http://ecomm.test/api/search/{Keyword}
    // content-type : application/json
    function searchProducts($query){
        $product = Product::where("name", "LIKE" , "%".$query."%")->get();
        if(count($product)){
            return ["result"=>$product];
        }else{
            return ["result"=>"Product not found."];
        }
    }

}
