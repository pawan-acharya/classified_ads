<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassifiedAd;
use App\Category;
use Auth;

class ClassifiedAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories= Category::with('classified_ads')->get();
        return view('classified_ads.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cat_id)
    {
        $category= Category::with('form_items')->find($cat_id);
        return view('classified_ads.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cat_id)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:classified_ads,title|max:255',
            'citq'=> 'nullable',
            // 'title_image'=> 'nullable',
            'descriptions'=> 'nullable',
        ]);
        $form_values_array=[];
        foreach ($request->except('_token') as $key => $value) {
            $form_item_id= explode('-', $key)[0];
            $form_item_value= $value;
            $form_values_array[$form_item_id]=$form_item_value;
        }
        $classified_ad = new ClassifiedAd([
            'title' => $validatedData['title'], 
            'citq'=> $validatedData['citq'], 
            // 'price' => $validatedData['price'], 
            // 'title_image' => $validatedData['title_image'], 
            'descriptions' => $validatedData['descriptions'], 
            // 'alt_images' => $validatedData['alt_images'],
            'form_values'=> json_encode( $form_values_array),
            'user_id'=> Auth::id(),
        ]);
        $classified_ad= Category::find($cat_id)->classified_ads()->save($classified_ad);

        return redirect()->route('classified_ads.show', ['classified_ad'=>$classified_ad->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classified_ad= ClassifiedAd::with('category')->find($id);
        $form_items_collection= Category::find($classified_ad->category->id)->form_items()->whereNull('parent')->get();
        return view('classified_ads.show', compact('classified_ad', 'form_items_collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classified_ad= ClassifiedAd::find($id);
        return view('classified_ads.edit', compact('classified_ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form_values_array=[];
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $form_item_id= explode('-', $key)[0];
            $form_item_value= $value;
            $form_values_array[$form_item_id]=$form_item_value;
        }
        
        ClassifiedAd::find($id)->update([
            'form_values'=> json_encode( $form_values_array),
        ]);

        return redirect()->route('classified_ads.show', ['classified_ad'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ClassifiedAd::find($id)->delete();
        return redirect()->route('classified_ads.index');
    }

    public function toggle($id){
        $classified_ad= ClassifiedAd::findOrFail($id);
        $classified_ad->approved= $classified_ad->approved?0:1;
        $classified_ad->save();

        return redirect()->back();
    }
}
