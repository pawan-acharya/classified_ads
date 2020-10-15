<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassifiedAd;
use App\Category;
use Auth;
use Lang;
use Carbon\Carbon;

class ClassifiedAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_name=null)
    {
        define('PER_PAGE', 9);
        $classified_ads= ClassifiedAd::with(['category', 'file'])
                    ->where('classified_ads.approved', 1)
                    // ->whereNotNull('classified_ads.plan_id')
                    // ->join('plans', 'plans.id', '=', 'classified_ads.plan_id')
                    // ->whereDate('plans.ends_at','>=' ,date('Y-m-d'))
                    ->orderBy('classified_ads.created_at', $request->query('order')?:'desc');
                    
        if($request->query('category')){
            $classified_ads->where('category_id', Category::where('category_name', $request->query('category'))->first()->id);
        }
        if($request->query('ad_name')){
            $classified_ads->where('title', 'like',  '%'.$request->query('ad_name').'%');
        }
        if($request->query('location')){
            $classified_ads->where('location', 'like',  '%'.$request->query('location').'%');
        }
        if($request->query('sub_category')){
            $classified_ads->where('sub_category', '=',  $request->query('sub_category'));
        }
        $classified_ads_count= $classified_ads->count();
        $classified_ads= $classified_ads->paginate(PER_PAGE);

        $categories= Category::all();
        return view('classified_ads.index', compact('classified_ads', 'categories', 'classified_ads_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $cat_id=null)
    {
        $category=  $cat_id?Category::where('category_name', $cat_id)->first():null;
        if($request->ajax()){
            // $category= Category::findOrFail($category_id);
            return view('classified_ads.partials.create', compact(['category']));
        }
        $categories= Category::all();
        $category_id= $category?$category->id:null;
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
        try {
            $validatedData = $request->validate([
                'title' => 'required|unique:classified_ads,title|max:255',
                'citq'=> 'nullable',
                'price' => 'required|numeric',
                'price_for'=> 'nullable',
                'title_images.*'=> 'nullable|file|image|mimes:jpeg,png,gif,webp|max:2048',
                'descriptions'=> 'nullable',
                'location'=> 'required',
                'url'=> 'nullable',
                'is_featured' => 'nullable',
                'feature_type'=> 'nullable',
                'sub_category'=> 'nullable',
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
                'location'=> $validatedData['location'],
                'url'=>  array_key_exists('url', $validatedData)?$validatedData['url']:null, 
                'is_featured'=> array_key_exists('is_featured', $validatedData)?1:0,
                'feature_type'=> $validatedData['feature_type'],
                'sub_category'=> array_key_exists('sub_category', $validatedData)?$validatedData['sub_category']: null,
            ]);
            $classified_ad= Category::findOrFail($cat_id)->classified_ads()->save($classified_ad);
            if(array_key_exists('title_images', $validatedData)){
                foreach ($validatedData['title_images'] as $key => $value) {
                    $classified_ad->file()->create($classified_ad->upload($value));
                }
            }
            // if(Auth::user()->checkIfAdmin()){
            //     $plan =Auth::user()->plan;
            //     $classified_ad->plan()->associate($plan);
            //     $classified_ad->save();
            // }
            return redirect()->route('classified_ads.review', ['classified_ad'=>$classified_ad->id]);
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {
        $classified_ad= ClassifiedAd::with('category')->where('title', $title)->first();
        $form_items_collection= Category::find($classified_ad->category->id)->form_items()->whereNull('parent')->get();
        $featured_ads=  ClassifiedAd::with('file')
        ->where('classified_ads.approved', 1)
        ->where('classified_ads.is_featured', 1)
        // ->whereNotNull('classified_ads.plan_id')
        // ->join('plans', 'plans.id', '=', 'classified_ads.plan_id')
        // ->whereDate('plans.ends_at','>=' ,date('Y-m-d'))
        ->get();

        return view('classified_ads.show', compact('classified_ad', 'form_items_collection', 'featured_ads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classified_ad= ClassifiedAd::findOrFail($id);
        if(Auth::user()->id !=  $classified_ad->user_id){
            return redirect()->back();
        }
        $category= $classified_ad->category;
        return view('classified_ads.edit', compact('classified_ad', 'category'));
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
        $classified_ad= ClassifiedAd::findOrFail($id);
        if(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName()== 'classified_ads.edit'){
            if(Auth::user()->checkIfAdmin() || (Auth::user()->checkForPlan() && $classified_ad->plan->id== Auth::user()->plan->id) || ($classified_ad->category->type== 'rental' || $classified_ad->category->type== 'sales') || !$classified_ad->plan || ($classified_ad->plan->ends_at< date('Y-m-d'))){
                //no need to add additional money
            }else{
                //no need to rediect to pay additional money
                request()->session()->forget('requests');
                request()->session()->push('requests', $request->except('title_images'));
                foreach($request->file('title_images') as $image) {
                    $request->session()->push('title_images', $ad->upload($image));
                }
                return redirect()->route('edit_pay', ['id'=> $id]);
            }
        }
        if(app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName()== 'edit_payment.charge'){
            $request= request()->session()->get('requests');
        }

        $form_values_array=[];
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $form_item_id= explode('-', $key)[0];
            $form_item_value= $value;
            $form_values_array[$form_item_id]=$form_item_value;
        }
        
        $classified_ad->update([
            'title' => $validatedData['title'], 
            'citq'=> $validatedData['citq'], 
            'price' => $validatedData['price'], 
            'price_for'=> $validatedData['price_for'],
            'descriptions' => $validatedData['descriptions'], 
            'form_values'=> json_encode( $form_values_array),
            'user_id'=> Auth::id(),
            'location'=> $validatedData['location'],
            'url'=>  array_key_exists('url', $validatedData)?$validatedData['url']:null, 
            'is_featured'=> array_key_exists('is_featured', $validatedData)?1:0,
            'feature_type'=> $validatedData['feature_type']
        ]);

        if ($request->session()->has('title_images')) {
            foreach($request->session()->get('title_images') as $image) {
                $ad->file()->create($image);
            }
        }

        request()->session()->forget('requests'); 
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

    public function review($id)
    {
        $classified_ad= ClassifiedAd::with('category')->find($id);
        $form_items_collection= Category::find($classified_ad->category->id)->form_items()->whereNull('parent')->get();
        return view('classified_ads.review', compact('classified_ad', 'form_items_collection'));
    }

    public function toggle($id){
        $classified_ad= ClassifiedAd::findOrFail($id);
        $classified_ad->approved= 1;
        if(!(Auth::user()->plan_id && Auth::user()->plan->ends_at>= date('Y-m-d'))){
            $date= Carbon::now();
            switch ($classified_ad->feature_type) {
                case 'month':
                    $date->addMonth();
                    break;
                case 'week':
                    $date->addWeek();
                    break;
                default:
                    $date->addDay();
                    break;
            }
            $plan= $classified_ad->plan;
            $plan->ends_at= $date;
            $plan->save();
        }
        $classified_ad->save();
        return Lang::get('admin.approved');
    }


    public function toggle_featured($id){
        $classified_ad= ClassifiedAd::findOrFail($id);
        $classified_ad->is_featured= $classified_ad->is_featured?0:1;
        $classified_ad->save();
        return $classified_ad->is_featured?Lang::get('admin.featured'):Lang::get('admin.not_featured');
    }

    public function ads_list(){
        $classified_ads= ClassifiedAd::whereNull('plan_id')->get();
        return view('classified_ads.list', compact('classified_ads'));
    }
}
