<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Avifinfo\Prop;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index(){

        $products = Product::paginate(8);
        return view('admin.product.index',compact('products'));

    }

    public function create(){
        $categories = Category::all();
        return view('admin.product.create',compact('categories'));
    }

    public function store(Request $request){
            

        $request->validate([
            'title'         => ['required','min:3','string'],
            'description'   => ['required','min:60','string'],
            'price'         => ['required','numeric'],
            'quantity'      => ['required','integer'],
            'category'      => ['required','integer','exists:categories,id'],
            'images.*'      => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
        ]);

        if($request->hasFile('images')){


            $images = $request->file('images');
            $allImages = array();
            foreach($images as $image){
                $filename = $image->store('uploads/images','public');
                array_push($allImages,$filename);
            }

            $images = json_encode($allImages);

            $product = Product::create([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => floatval( $request->price),
                'quantity'      => $request->quantity,
                'category_id'        => $request->category,
                'images'        => $images,
            ]);
    
            if($product){
                return redirect()->back()->with('successMessage','Product added successfully');
            }
            

            return redirect()->back()->with('errorMessage', 'Something went wrong');
      }
      return redirect()->back()->with('errorMessage', 'image must be required');
    }

    public function show(Request $request,Product $product){
        $window_width = $request->window_width;
        return view('admin.product.show',compact('product','window_width'));
    }

    public function edit(Product $product){
        $categories = Category::all();
        return view('admin.product.edit',compact('categories','product'));
    }

    public function update(Request $request,Product $product){

        $request->validate([
            'title'             => ['required','min:3','string'],
            'description'       => ['required','min:60','string'],
            'price'             => ['required','numeric'],
            'quantity'          => ['required','integer'],
            'category'          => ['required','integer','exists:categories,id'],
            'images.*'          => ['required','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'images_exist_name' => ['required','string'],
        ]);

        

        $images_exists_stay = json_decode($request->images_exist_name);

        // verify images exists that not modified on something bad

        if(count($images_exists_stay)){
            foreach($images_exists_stay as $image){
                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
                // Get the file extension
                $extension = pathinfo($image, PATHINFO_EXTENSION);
    
                // Check if the file extension is valid
                if (!in_array(strtolower($extension), $imageExtensions)) {
                    return redirect()->back()->with('errorMessage','something went wrong');
                }
    
            }
        }
        
        
        if($request->hasFile('images') || count(json_decode($request->images_exist_name))){// verify that are images exist

            // add new images in the store location
            $new_images = array();
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $image){
                    $filename = $image->store('uploads/images','public');
                    array_push($new_images,$filename);
                }
            }
            

           
        // verify and get the images stay from the images exists
        
        $images_exists = json_decode($product->images);
        $images_stay = $images_exists;
        if(count($images_exists) > count($images_exists_stay)){
            $images_deleted = array_diff($images_exists,$images_exists_stay);
            foreach($images_deleted as $image){
                $image_path = public_path('storage/'.$image);
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $images_stay = $images_exists_stay;
        }

        // merge new images with exist images
        $images = array_merge($new_images,$images_stay);

        // update the new information
        $product->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => floatval( $request->price),
            'quantity'      => $request->quantity,
            'category_id'        => $request->category,
            'images'        => json_encode($images),
        ]);
        
        return redirect()->back()->with('successMessage','product updated with success');
        }

        return redirect()->back()->with('errorMessage','You must add images to your product');
        
    }

    public function destroy(Product $product){
        // delete images related to the product
        $images = json_decode($product->images);

        foreach($images as $image){
            $image_path = public_path('storage/'.$image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
        }

        $product->delete();

        return redirect()->route('admin.dashboard.products.index')->with('successMessage','Product Deleted with success');
    }


    // search method 
    public function search(Request $request){
        $search = $request->search;
        $category = Category::where('name','LIKE','%'.$search.'%')->first();

        $products = NULL;
        if($category){
            $products = Product::where('title','LIKE','%'.$search.'%')->orWhere('category_id',$category->id)->paginate(8);
        }else{
            $products = Product::where('title','LIKE','%'.$search.'%')->paginate(8);
        }

        return view('admin.search',compact('products','search'));
    }

     
}
