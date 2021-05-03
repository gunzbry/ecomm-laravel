<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    function index(){
        // return Product::all();
        //return "Welcome to product page";
        $data = Product::all();
        return view('product', ['products' => $data]);
    }
}
