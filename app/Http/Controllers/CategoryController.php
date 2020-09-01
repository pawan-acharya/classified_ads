<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\FormItem;
use App\File;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersCount = DB::table('users')->count();
        $adsCount = DB::table('classified_ads')->where('approved', 1)->count();
        $categoriesCount= DB::table('categories')->count();
        $categories= Category::all();
        return view('categories.index', compact(['categories', 'usersCount', 'adsCount', 'categoriesCount']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usersCount = DB::table('users')->count();
        $adsCount = DB::table('classified_ads')->where('approved', 1)->count();
        $categoriesCount= DB::table('categories')->count();
        $categories= Category::all();
        return view('categories.create', compact([ 'usersCount', 'adsCount', 'categoriesCount']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories,category_name|max:255',
            'description'=> 'nullable',
            'image'=>'file|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);
        $category = Category::create([
            'category_name'=>$validatedData['category_name'],
            'description'=> $validatedData['description'],
           
        ]);
        
        $category->file()->create($category->upload($validatedData['image']));

        foreach (json_decode($request->big_array, TRUE) as $key => $value) {
            
            $form_item= FormItem::create([
                'name'=> $value['name'],
                'type'=> $value['type'],
                'required'=> ($value['mandatory']== 'yes')?'1':'0',
                'category_id'=> $category->id,
            ]);
            if(!empty($value['box_array'])){
                foreach ($value['box_array'] as $key => $value) {
                    FormItem::create([
                        'name'=> $value['name'],
                        'type'=> $value['type'],
                        'required'=> ($value['mandatory']== 'yes')?'1':'0',
                        'category_id'=> $category->id,
                        'parent'=>$form_item->id, 
                        'logo'=>array_key_exists('logo', $value)?$value:null,
                    ]);
                }
            }
        }
        return response()->json([
            'status' => 200,
            'url'=> route('categories.show', ['category'=> $category->id]),
        ]);
        // $category->form_items()->createMany($new_array);
        // return redirect()->route('categories.show', ['category'=> $category->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category= Category::with('form_items')->find($id);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category= Category::find($id);
        return view('categories.edit', compact('category'));
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
        // dd($request->all());
        $validatedData = $request->validate([
            'category_name' => 'required|max:255|unique:categories,category_name,'.$id,
        ]);

        DB::beginTransaction();
        try{
            $category= Category::find($id);
            $category->update($validatedData); 

            // $category= Category::find($id);
            $new_array=[];
            $arrray_of_ids= $category->getFormItemsIdsAttribute();
            
            foreach ($request->names as $key => $value) {
                if($request->ids[$key]){    
                    FormItem::find($request->ids[$key])->update([
                        'name'=>  $value,
                        'type'=> $request->types[$key],
                        'required'=> ($request->mandatories[$key]== 'yes')?'1':'0',
                    ]);
                }else{
                    $temp_data=[];
                    $temp_data['name']= $value;
                    $temp_data['type']= $request->types[$key];
                    $temp_data['required']= ($request->mandatories[$key]== 'yes')?'1':'0';
                    array_push($new_array, $temp_data);
                }
            }
            $unwanted_form_items= array_diff($arrray_of_ids->toArray(),$request->ids);
            FormItem::destroy($unwanted_form_items);

            $category->form_items()->createMany($new_array);
            
            DB::commit();
            return redirect()->route('categories.show', ['category'=> $id]);
        }catch(Throwable $e){
            DB::rollBack();
        }

        // return redirect()->route('form_items.edit', ['id'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->form_items_delete();
        return redirect()->route('categories.index');
    }
}
