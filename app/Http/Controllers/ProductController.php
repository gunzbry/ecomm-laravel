<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
}
