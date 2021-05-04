<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class dummyAPI extends Controller
{
    // returns List of Products via API
    function getData(){
        $data = Product::all();
        return ["data"=>$data];
    }
}
