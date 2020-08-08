<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\FormItem;
use DB;

class FormItemController extends Controller
{

    public function add($id){

        return view('form_items.add',compact('id'));
    }
    
    public function store(Request $request, $id){
        // dd($request->all());
        $new_array=[];
        foreach ($request->types as $key => $value) {
            $temp_data=[];
            $temp_data['type']= $value;
            $temp_data['name']= $request->names[$key];
            $temp_data['required']= ($request->mandatories[$key]== 'yes')?'1':'0';
            array_push($new_array, $temp_data);
        }
        
        Category::find($id)->form_items()->createMany($new_array);
        return redirect()->route('categories.index');
    }

    public function edit($id){
        $form_items= Category::find($id)->form_items;
        return view('form_items.edit',compact('id', 'form_items'));
    }
    
    public function update(Request $request, $id){
        DB::beginTransaction();
        try{
            $new_array=[];
            $category= Category::find($id);
            $arrray_of_ids= $category->getFormItemsIdsAttribute();
            
            foreach ($request->types as $key => $value) {
                if($request->ids[$key]){    
                    FormItem::find($request->ids[$key])->update([
                        'type'=>  $value,
                        'name'=> $request->names[$key],
                        'required'=> ($request->mandatories[$key]== 'yes')?'1':'0',
                    ]);
                }else{
                    $temp_data=[];
                    $temp_data['type']= $value;
                    $temp_data['name']= $request->names[$key];
                    $temp_data['required']= ($request->mandatories[$key]== 'yes')?'1':'0';
                    array_push($new_array, $temp_data);
                }
            }
            $unwanted_form_items= array_diff($arrray_of_ids->toArray(),$request->ids);
            FormItem::destroy($unwanted_form_items);

            $category->form_items()->createMany($new_array);
            
            DB::commit();
            return redirect()->route('categories.index');
        }catch(Throwable $e){
            DB::rollBack();
        }
    }

}
