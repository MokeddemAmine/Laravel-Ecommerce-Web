<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\DetailsAttribute;
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
        $attributes = Attribute::all();
        return view('admin.product.create',compact('categories','attributes'));
    }

    public function attributes_name($request,$attributes_name,$i){
        $names = [];
        $name = '';
                
                if($attributes_name[$i] == $attributes_name[count($attributes_name) -1]){
                    foreach($request->input($attributes_name[$i]) as $attr){
                        $get_attr = DetailsAttribute::where('value',$attr)->first();
                        if($get_attr){
                            $attr = str_replace(".", "_", $attr);
                            $names[] = $attr;
                        }else{
                            return redirect()->back()->with('errorMessage','something was wrong');
                        }
                    }
                    
                }else{
                    foreach($request->input($attributes_name[$i]) as $attr){
                        // valide if the current attribute exist in our tables
                        $get_attr = DetailsAttribute::where('value',$attr)->first();
                        if($get_attr){ 
                            $attr = str_replace(".", "_", $attr);
                            $name = $attr.'-';
                            $names_att = $this->attributes_name($request,$attributes_name,$i+1);
                            foreach($names_att as $name_att){
                                $name.=$name_att;
                                $names[] = $name;
                                $name = substr($name, 0, -strlen($name_att));
                            } 
                        }else{
                            return redirect()->back()->with('errorMessage','something was wrong');
                        }
                    }
                    
                }
                return $names;   
    }

    public function store(Request $request){
            
        
        $attribute_value = [];
        if(isset($request->quantity_attr) && $request->quantity_attr == 'set'){
            // get all keys exists
            $keys = [];
            foreach($request->all() as $key => $value){
                $keys[] = $key;
            }
            
            // get the attributes set in the form from DB
            $attributes = Attribute::whereIn('name',$keys)->get();
            
            // get the name of all attributes
            $attributes_name = [];
            foreach($attributes as $attribute){
                $attributes_name[] = $attribute->name;
            }
            

            $names = $this->attributes_name($request,$attributes_name,0);
            
            $names_validate = [];
            
            foreach($names as $name){
                $names_validate[$name] = ['required','numeric'];
            }
            
            // validate the inputs of quantities of attribute :
            // $request->validate($names_validate,['*' => 'you must set valide quantity']);

            // set the main attributes
            $attribute_value[] = $attributes_name;
            
            // check if sub total quantities equal to general total
            $total = 0;
            foreach($names as $name){
                $total += $request->input($name);
                $name = str_replace("_", ".", $name);
                // get the detailsAttribute with there quantities and set them 
                $attr_set = explode('-', $name);
                $attr_set[] = $request->input($name);
                $attribute_value[] = $attr_set;
            }
            if($total != $request->quantity){
                return redirect()->back()->with('errorMessage','Total quantity must equal to sub quantities');
            }
                
        }
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
                'category_id'   => $request->category,
                'images'        => $images,
                'attributes'    => count($attribute_value)?json_encode($attribute_value):null,
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
        $attributes = Attribute::all();
        return view('admin.product.edit',compact('categories','product','attributes'));
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
