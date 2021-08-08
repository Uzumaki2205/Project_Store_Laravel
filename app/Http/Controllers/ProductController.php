<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Products;
use \App\Categories;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function home()
    {
        $cats = Categories::all();
        $products = Products::all()->load('category');
        return view('user.index', compact('products', 'cats'));
    }

    // GET /AllProduct
    public function AllProduct()
    {
        $cats = Categories::all();
        $prods = Products::all()->load('category', 'promotion');
        return view('user.product', compact('prods', 'cats'));
        //return $prods;
    }

    // GET Category From product
    public function SearchCategory(Request $request)
    {
        $cats = Categories::all();
        $prods = Products::where('id_category', $request->id_category)->get();
        return view('user.search', compact('prods', 'cats'));
    }

    // GET /Product/slug={slug}
    public function Details($slug)
    {
        $prod = Products::where('slug_product', $slug)->first();
        // $details = $prod->load('image', 'product');
        $imgs = \App\Images::all()->where('id_product', $prod->id);
        return view('user.detail', compact('prod', 'imgs'));
    }

    // GET /Promotion/{id}
    public function GetPromotion(Request $request)
    {
        $promotion = \App\Promotions::find($request->id);
        return $promotion;
    }

    // public function GetInventory()
    // {
    //     $inv = \App\Inventories::all()->load('product');
    //     return $inv;
    // }
}
