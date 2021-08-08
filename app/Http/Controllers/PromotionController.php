<?php

namespace App\Http\Controllers;

use App\Promotions;
use Exception;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function showPromotion()
    {
        $promotions = Promotions::all();
        return view('admin.promotion')->with('promotions', $promotions);
    }

    //POST
    public function addPromotion(Request $request)
    {
        $request->validate([
            'name_promotion' => 'required',
            'price_promotion' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        try {
            $promotion = new Promotions();
            $promotion->name_promotion = $request->name_promotion;
            $promotion->price_promotion = $request->price_promotion;
            $promotion->start_date = $request->start_date;
            $promotion->end_date = $request->end_date;
            $promotion->save();
            return redirect()->back()->with('success', "Add Promotion Success");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    // GET /admin/edit-user
    public function editPromotion(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $promotion = Promotions::where('id', $request->id)->first();
        return $promotion;
    }

    // POST /admin/save-edit-promotion
    public function saveEditPromotion(Request $request)
    {
        $promotion = Promotions::find($request->id);
        $promotion->name_promotion = $request->name_promotion;
        $promotion->price_promotion = $request->price_promotion;
        $promotion->start_date = $request->start_date;
        $promotion->end_date = $request->end_date;

        return $promotion->save();
    }

    // POST /admin/delete-promotion
    public function delPromotion(Request $request)
    {
        if (is_array($request->ids)) {
            Promotions::destroy($request->ids);
            return response()->json(['success' => 'Delete Successfully'], 200);
        }
        return response()->json(['error' => 'Delete Fail'], 404);
    }
}
