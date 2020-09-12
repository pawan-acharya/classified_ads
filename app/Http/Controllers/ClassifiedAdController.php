<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassifiedAd;
use App\Category;
use Auth;
use Lang;

class ClassifiedAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        define('PER_PAGE', 9);
        $classified_ads= ClassifiedAd::with(['category', 'file'])
                    ->where('approved', 1)
                    ->orderBy('created_at', $request->query('order')?:'desc');
                    
        if($request->query('category')){
            $classified_ads->where('category_id', $request->query('category'));
        }
        if($request->query('ad_name')){
            $classified_ads->where('title', 'like',  '%'.$request->query('ad_name').'%');
        }
        $classified_ads= $classified_ads->paginate(PER_PAGE);
        return view('classified_ads.index', compact('classified_ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $cat_id=null)
    {
        
        $category_id=  $cat_id??null;
        if($request->ajax()){
            $category= Category::findOrFail($category_id);
            return view('classified_ads.partials.create', compact(['category']));
        }
        $categories= Category::all();
        return view('classified_ads.create', compact(['category_id', 'categories']));
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
            'price' => 'required|numeric',
            'price_for'=> 'nullable',
            'title_images.*'=> 'nullable|file|image|mimes:jpeg,png,gif,webp|max:2048',
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
            'price' => $validatedData['price'], 
            'price_for'=> $validatedData['price_for'],
            'descriptions' => $validatedData['descriptions'], 
            'form_values'=> json_encode( $form_values_array),
            'user_id'=> Auth::id(),
        ]);
        $classified_ad= Category::findOrFail($cat_id)->classified_ads()->save($classified_ad);
        if(array_key_exists('title_images', $validatedData)){
            foreach ($validatedData['title_images'] as $key => $value) {
                $classified_ad->file()->create($classified_ad->upload($value));
            }
        }

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
        return $classified_ad->approved?Lang::get('admin.approved'):Lang::get('admin.rejected');
    }
}
