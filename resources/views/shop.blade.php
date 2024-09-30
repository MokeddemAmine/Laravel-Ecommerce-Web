@extends('layouts.app')
@section('title','shop')
    
@section('content')
    
  <?php
    $min_price = null;
    $max_price = null;
    $sort_by = null;
    $cats = [];
    $attrs = collect($_GET)->except(['min_price','max_price','sort_by','categories','page'])->toArray();
    $attrs_values = [];
    foreach($attrs as $key => $values){
      foreach($values as $value){
        $attrs_values[] = $value;
      }
    }
    if(isset($_GET['min_price'])){
      $min_price = $_GET['min_price'];
    }
    if(isset($_GET['max_price'])){
      $max_price = $_GET['max_price'];
    }
    if(isset($_GET['sort_by'])){
      $sort_by = $_GET['sort_by'];
    }
    if(isset($_GET['categories'])){
      $cats = $_GET['categories'];
    }
  ?>
  <!-- shop section -->

  <section class="shop_section layout_padding">

    <div class="filtering container">
      @if ($min_price)
          <span class="d-inline-block border border-dark py-2 px-3 rounded text-white bg-dark text-uppercase">min price: {{$min_price}}$</span>
      @endif
      @if ($max_price)
      <span class="d-inline-block border border-dark py-2 px-3 rounded text-white bg-dark text-uppercase">max price: {{$max_price}}$</span>
      @endif
      @if ($sort_by)
        <span class="d-inline-block border border-dark py-2 px-3 rounded text-white bg-dark text-uppercase">
          sort by: 
          @if ($sort_by == 'price_low')
            low to high
          @elseif($sort_by == 'price_high')
            high to low
          @elseif($sort_by == 'top_sellers')
            top sellers
          @else 
            newest
          @endif
        
        </span>
      @endif
      @if ($cats && count($cats))
          <span class="d-inline-block border border-dark py-2 px-3 rounded text-white bg-dark text-uppercase">categories:
          @foreach ($categories as $category)
              @if (in_array($category->id,$cats))
                  
                  <u>{{$category->name}}</u>
              @endif
          @endforeach
        </span>
      @endif
      @if ($attrs && count($attrs))
          @foreach ($attrs as $key => $values)
              <span class="d-inline-block border border-dark py-2 px-3 rounded text-white bg-dark text-uppercase">
                {{$key}}:
                @foreach ($values as $value)
                    <u>{{$value}}</u>
                @endforeach
              </span>
          @endforeach
      @endif
    </div>
    <button id="btn-filtering" class="text-uppercase btn btn-outline-danger fw-bold">filter & sort <i class="fa-solid fa-sliders"></i></button>
    <form action="{{route('search.products')}}" method="GET" id="filtering" class="p-3 bg-white border border-light">
      <h1 class="text-capitalize text-dark border-bottom pb-3 fs-3 d-flex justify-content-between align-items-center"><span>filter & sort</span> <span style="cursor: pointer;" id="hide-filtering" ><i class="fa-solid fa-left-long text-danger"></i></span></h1>
      <div class="border-bottom sort-by">
        <h2 class="fs-4 pb-3 text-dark text-uppercase d-flex justify-content-between align-items-center filter-btn" style="cursor:pointer;">sort by <i class="fa-solid fa-chevron-down"></i></h2>
        <div class="sort-by filter-values">
          <div class="form-check">
            <input class="form-check-input" type="radio" value="price_low" name="sort_by" @if($sort_by && $sort_by == 'price_low') checked @endif id="flexRadioDefault1">
            <label class="form-check-labe text-uppercase" for="flexRadioDefault1">
              price (low - high)
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="newest" name="sort_by" @if($sort_by && $sort_by == 'newest') checked @endif id="flexRadioDefault2">
            <label class="form-check-label text-uppercase" for="flexRadioDefault2">
              newest
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="top_sellers" @if($sort_by && $sort_by == 'top_sellers') checked @endif name="sort_by" id="flexRadioDefault3">
            <label class="form-check-label text-uppercase" for="flexRadioDefault3">
              top sellers
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" value="price_high" @if($sort_by && $sort_by == 'price_high') checked @endif name="sort_by" id="flexRadioDefault4">
            <label class="form-check-label text-uppercase" for="flexRadioDefault4">
              price (high - low)
            </label>
          </div>
        </div>
      </div>
      <div class="border-bottom price my-2">
        <h2 class="fs-4 pb-3 text-dark text-uppercase d-flex justify-content-between align-items-center filter-btn" style="cursor:pointer;">price <i class="fa-solid fa-chevron-down"></i></h2>
        <div class="filter-values">
          <div class="prices d-flex justify-content-around my-2">
            <input type="number" name="min_price" value="<?= $min_price ?>" class="input-prices">
            <input type="number" name="max_price" value="<?= $max_price ?>" class="input-prices">
          </div>
        </div>
      </div>
      <div class="border-bottom category my-2">
        <h2 class="fs-4 pb-3 text-dark text-uppercase d-flex justify-content-between align-items-center filter-btn" style="cursor:pointer;">category <i class="fa-solid fa-chevron-down"></i></h2>
        <div class="categories my-2 filter-values">
          @if ($categories && count($categories))
              @foreach ($categories as $category)
              <div class="form-check">
                <input class="form-check-input" name="categories[]" value="{{$category->id}}" @if(in_array($category->id,$cats)) checked @endif type="checkbox" id="category-{{$category->id}}-{{$category->name}}" >
                <label class="form-check-label " for="category-{{$category->id}}-{{$category->name}}">
                  <span class="text-capitalize">{{$category->name}}</span>
                </label>
              </div>
              @endforeach
          @endif
        </div>
      </div>
      @if ($attributes && count($attributes))
          @foreach ($attributes as $attribute)
            <div class="border-bottom price my-2 attributes">
              <h2 class="fs-4 pb-3 text-dark text-uppercase d-flex justify-content-between align-items-center filter-btn" style="cursor:pointer;">{{$attribute->name}} <i class="fa-solid fa-chevron-down"></i></h2>
              <div class="attributes my-2 filter-values">
                @if ($attribute->values && count($attribute->values))
                    @foreach ($attribute->values as $val)
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" name="{{$attribute->name}}[]" value="{{$val->value}}" @if(in_array($val->value,$attrs_values)) checked @endif type="checkbox" id="{{$attribute->id}}-{{$attribute->name}}-{{$val->id}}" >
                      <label class="form-check-label {{$attribute->name}} @if(in_array($val->value,$attrs_values)) attribute-checked @endif" @if($attribute->name == 'color') @endif style="background-color:{{$val->value}};" for="{{$attribute->id}}-{{$attribute->name}}-{{$val->id}}">
                        @if ($attribute->name != 'color')
                          <span class="text-capitalize">{{$val->value}}</span>
                        @endif
                      </label>
                    </div>
                    @endforeach
                @endif
              </div>
            </div>
          @endforeach
      @endif
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-dark d-flex justify-content-between align-items-center fw-bold">
          <span class="text-uppercase">apply</span>
          <i class="fa-solid fa-right-long"></i>
        </button>
      </div>
      <div class="d-grid gap-2 my-2">
        <a href="{{route('shop')}}" class="text-uppercase btn btn-outline-danger fw-bold">reset</a>
      </div>
      
    </form>
    <div class="container">
      @if (session('success_add_product'))
          <div class="alert alert-success">{{session('success_add_product')}}</div>
      @endif
      @if (session('errorAddProduct'))
      <div class="alert alert-danger">{{session('errorAddProduct')}}</div>
      @endif
      <div class="row">
        @if ($products && count($products))
          @foreach ($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="box bg-dark text-white rounded">
                  @php
                      $images = json_decode($product->images);
                  @endphp
                  <div class="img-box">
                    <img src="{{asset('storage/'.$images[0])}}" alt="{{$product->title}} image">
                  </div>
                  <div class="detail-box">
                    <h6>{!!Str::limit($product->title,30)!!}</h6>
                    <h6>
                      <span>${{$product->price}}</span>
                    </h6>
                  </div>
                  <div class="d-flex justify-content-between align-items-center">
                    <a href="{{route('products.show',$product->slug)}}" class="btn btn-outline-info btn-sm text-light text-capitalize">show more</a>
                    @if (!$product->quantity)
                      <span class="text-danger text-capitalize">indisponible</span>
                    @endif
                  </div>
              </div>
            </div>
            
          @endforeach
          @if ($products && count($products))
            <div class="d-flex justify-content-center my-4">{{$products->links()}}</div>
            @endif
        @else 
          <div class="fw-bold  text-info my-3">There are no product</div>
        @endif
        
      </div>
      
      
    </div>
  </section>

  @endsection
  <!-- end shop section -->
