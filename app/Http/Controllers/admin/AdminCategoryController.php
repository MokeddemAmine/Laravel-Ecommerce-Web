<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{

    protected $home = 'admin.category.index';

    public function index(){
        $categories = Category::all();
        return view($this->home,compact('categories'));
    }
    public function create(){
        return view('admin.category.create');
    }
    public function store(Request $request){
        
        $request->validate([
            'name'  => ['required','min:3','string','unique:categories'],
        ]);

        $create = Category::create([
            'name'      => $request->name,
        ]);

        if($create){
            return redirect()->back()->with('successResponse','Category "'.$request->name.'" created with success');
        }

        
    }

    public function show(Category $category){
        $products = $category->products()->paginate(8);
        if($category){
            return view('admin.category.show',compact('category','products'));
        }
        return view($this->home);
    }

    public function edit(Category $category){

        if($category){
            return view('admin.category.edit',compact('category'));
        }
        return view($this->home);
    }

    public function update(Category $category,Request $request){
        
        $request->validate([
            'name'  => ['required','min:3','string','unique:categories'],
        ]);

        if($category){
            $category->update([
                'name'  => $request->name
            ]);
            return redirect()->back()->with('successResponse','Category updated with success');
        }

        return view($this->home);
        
    }

    public function destroy(Category $category){

        if($category){
            $category->delete();
            return redirect()->back()->with('successDestroy','Category deleted with success');
        }
        return view($this->home);
    }
}
