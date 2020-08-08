<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Wishlist;
use App\Ad;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();
        $ads = $wishlists->map(function ($wishlist) {
            return Ad::find($wishlist->ad_id);
        });

        return view('wishlists', compact('ads'));
    }

    public function create(Request $request, $ad_id) {
        if($request->ajax()){
            try {
                $wishlist = Wishlist::firstOrCreate([
                    'user_id' => Auth::user()->id,
                    'ad_id' =>$ad_id
                ]);

                return response()->json($wishlist);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        }
    }

    public function delete(Request $request, $ad_id) {
        if($request->ajax()){
            try {
                Wishlist::where( 'user_id', Auth::user()->id)
                                    ->where('ad_id', $ad_id)
                                    ->delete();
 
                return response()->json(['success' => 'true']);
            } catch (\Exception $e) {
                abort(500, $e->getMessage());
            }
        }
    }
}
