@extends('admin.layouts.app')

@section('title','Admin Dashboard Products')

@section('content')
      
        <div class="page-header">
          <div class="container-fluid">
            <h2 class="h5 no-margin-bottom text-capitalize">keys</h2>
          </div>
        </div>

        <div class="ms-3 ms-lg-5 keys">
            @if ($keys && count($keys))
                <div class="row titles" style="max-width: 600px">
                    <label class="col text-capitalize fw-bold">key</label>
                    <label class="col text-capitalize fw-bold">action</label>
                </div>
                @foreach ($keys as $key)
                    <div class="row my-2" style="max-width: 600px">
                        <div class="col">{{$key->key}}</div>
                        <div class="col">
                            <form action="{{route('admin.dashboard.key.destroy',$key->id)}}" method="POST" class="d-none form-delete-key">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button class="btn btn-danger btn-sm text-capitalize delete-key">delete</button>
                        </div>
                    </div>
                @endforeach
            @else 
                <div class="text-info my-3 text-capitalize">no key</div>
            @endif
            <a href="{{route('admin.dashboard.key.create')}}" class="btn btn-danger my-3 text-capitalize">add key</a>
        </div>

        <div class="text-center">
            @if (session('successMessage'))
            <span class="fw-bold text-success my-4">{{session('successMessage')}}</span>
            @endif

            @if (session('errorMessage'))
                <span class="fw-bold text-danger my-4">{{session('errorMessage')}}</span>
            @endif

            @if ($errors->any())
                <ul class="list-unstyled text-danger fw-bold">
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        

@endsection
@section('js-special')
<script>
    $(document).ready(function(){
        $('.delete-key').click(function(){
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
                    $(this).siblings('.form-delete-key').submit();
                }
            });
        })

        // set the width of the current windwo (desktop , tablet or mobile)
        var window_width = window.innerWidth;

        if(window_width > 767){
            $('.attributes').show();
        }
    })
    
</script>
@endsection  