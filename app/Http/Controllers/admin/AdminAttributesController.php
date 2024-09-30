<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\DetailsAttribute;
use Illuminate\Http\Request;

class AdminAttributesController extends Controller
{
    public function index(){

        $attributes = Attribute::all();

        return view('admin.attribute.index',compact('attributes'));
    }

    public function create(){

        return view('admin.attribute.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'      => ['required','string','unique:attributes,name'],
            // we can use regex to accept special caracters or alpha_num to accept letters and numbers
            'values'    => ['required','string'],
        ]);

        
        $values = explode(" ", $request->values);
        if(is_array($values) && count($values)){
            $attribute = Attribute::create([
                'name'  => $request->name,
            ]);
            foreach($values as $value){
                DetailsAttribute::create([
                    'attribute_id'  => $attribute->id,
                    'value'         => $value,
                ]);
            }
            return redirect()->back()->with('successMessage','attribute '.$attribute->name.' created successfully');
        }else{
            return redirect()->back()->with('errorMessage','something was wrong');
        }

    }

    public function destroy(Attribute $attribute){
        $attribute->delete();
        return redirect()->back()->with('successMessage','Attribute deleted with success');
    }
    public function get_values(Request $request){

        $request->validate([
            'attribute' => ['required','string','exists:attributes,name'],
        ]);
        $attribute = Attribute::where('name',$request->attribute)->first();
        $values = DetailsAttribute::where('attribute_id',intval($attribute->id))->get();
        
        return response()->json($values);
    }
}
