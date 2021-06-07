<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Images;
use App\Products;
use App\Promotions;
use App\User;
use App\Galeries;
use Exception;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function getAllUser()
    {
        $users = User::all();
        return view('admin.users')->with('users', $users);
    }

    // GET /admin/edit-user
    public function editUser(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::where('id', $request->id)->first();
        return $user;
    }

    // POST /admin/save-edit-user
    public function saveEditUser(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password != '')
            $user->password = Hash::make($request->password);
        $user->is_admin = $request->is_admin;

        return $user->save();
    }

    // POST /admin/delete-user
    public function delUser(Request $request)
    {
        if (is_array($request->ids)) {
            User::destroy($request->ids);
            return response()->json(['success' => 'Delete Successfully'], 200);
        }
        return response()->json(['error' => 'Delete Fail'], 404);
    }

    // Post /admin/add-user
    public function addUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users|max:50',
            'name' => 'required',
            'password' => 'required|max:50',
            'password_again' => 'required|max:50',
            'email' => 'required|unique:users',
            'is_admin' => 'required',
        ]);

        if ($request->password != $request->password_again)
            return redirect()->back()->with('fail', "operation failed");

        try {
            $user = new User;
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->is_admin = $request->is_admin;
            $user->save();
            return redirect()->back()->with('success', "Add User Success");
        } catch (Exception $e) {
            return redirect()->back()->with('fail', "Error" . $e->getMessage());
        }
    }

    // PRODUCT MANAGER
    // GET /admin/products
    public function AllProduct()
    {
        $prods = Products::all()->load('category');
        return view('admin.products', compact('prods'));
    }

    // GET admin/Products/{slug}
    public function Details($slug)
    {
        $promo = Promotions::all();
        $cats = Categories::all();
        $galery = Galeries::all();
        $prod = Products::all()->where('slug_product', $slug)->first();
        $images = Images::all()->where('id_product', $prod->id);
        return view('admin.product.detail', compact('prod', 'images', 'galery', 'cats', 'promo'));
    }

    // POST admin/Products/Update
    public function UpdateProduct(Request $request)
    {
        $prod = Products::find($request->id);
        $prod->name_product = $request->name_product;
        $prod->description_product = $request->description_product;
        $prod->id_category = $request->id_category;
        $prod->quantity_product = $request->quantity;
        $prod->id_promotion = $request->id_promotion;
        $prod->price_product = $request->price_product;
        $prod->image_product = $request->image_product;
        $prod->save();

        if ($request->images != null) {
            $imgs = DB::table('Images')->where('id_product', $request->id)->delete();
            foreach ($request->images as $img) {
                $image = new Images();
                $image->id_product = $prod->id;
                $image->id_galery = $img;
                $image->save();
            }
        }
        return redirect('/admin/products');
    }

    // GET admin/Create
    public function showCreateProduct()
    {
        $imgs = \App\Galeries::all();
        $cats = \App\Categories::all();
        $promo = \App\Promotions::all();
        return view('admin.product.create', compact('imgs', 'cats', 'promo'));
    }

    // POST admin/Create
    public function CreateProduct(Request $request)
    {
        $prod = new Products();
        $prod->name_product = $request->name_product;
        $prod->description_product = $request->description_product;
        $prod->id_category = $request->id_category;
        $prod->id_promotion = $request->id_promotion;
        $prod->price_product = $request->price_product;
        $prod->quantity_product = $request->quantity;
        $prod->image_product = $request->image_product;
        $prod->slug_product = Str::slug($request->name_product);
        $prod->save();

        foreach ($request->images as $img) {
            $image = new Images();
            $image->id_product = $prod->id;
            $image->id_galery = $img;

            $image->save();
        }

        return "Success to created";
    }

    // IMAGE GALERY MANAGER
    // GET admin/image-category
    public function Category_Image()
    {
        $prods = Products::all();
        $imgs = Images::all()->load('product');
        return view('admin.image_category', compact('imgs', 'prods'));
    }

    // GET admin/galery
    public function Galery()
    {
        $imgs = \App\Galeries::all();
        return view('admin.galery', compact('imgs'));
    }

    public function UploadImage(Request $request)
    {
        // $request->validate([
        //     'attachment' => 'mimes:jpeg,jpg,png|required|max:5000',
        // ]);
        $request->validate([
            'attachment' => 'required|array|max:2048',
        ]);

        if ($request->hasfile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/galery', $name);
                $data[] = $name;

                $img = new Galeries();
                $img->url_image = ('/images/galery/' . $name);
                $img->save();
            }
            return back()->with('Success!', 'Data Added!');
        }

        return "Error When Upload File";
        //return $request;
    }
}
