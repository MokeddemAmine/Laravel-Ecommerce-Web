@extends('admin.layouts.app')

@section('title','Admin Dashboard Categories')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Show All Categories</h2>
          </div>
        </div>
        
        <div class="show-categories mx-5">
            @if (session('successDestroy'))
                <span class="fw-bold text-success">{{session('successDestroy')}}</span>
            @endif
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th>#N</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($categories))
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}}</td>
                                <td>
                                    <a href="{{route('admin.dashboard.categories.show',$category->id)}}" class="btn btn-info text-capitalize">show</a>
                                    <a href="{{route('admin.dashboard.categories.edit',$category->id)}}" class="btn btn-success text-capitalize">edit</a>
                                    <form id="form-delete-category-{{$category->id}}" class="d-inline-block" action="{{route('admin.dashboard.categories.destroy',$category->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        
                                    </form>
                                    <button class="btn btn-danger btn-delete-category" id="btn-delete-category-{{$category->id}}">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <a href="{{route('admin.dashboard.categories.create')}}" class="btn btn-primary my-3 mx-5">Add Category</a>

@endsection

@section('js-special')
    <script>
        $(document).ready(function(){
            $('.btn-delete-category').click(function(){
                swal.fire({
                    title:'Are You Sure want to delete this',
                    text:'this delete will be parmanent',
                    icon:'warning',
                    showDenyButton: true,
                    confirmButtonText: "Delete",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if(result.isConfirmed){
                        $(this).siblings('form').submit();
                    }
                });
            })
        })
        
    </script>
@endsection
        