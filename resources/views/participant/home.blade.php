@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success')}}
                </div>
            @endif
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session()->get('message')}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Projects</div>

                    <div class="card-body">
                        {{-- @if(auth()->user()->PROJECTS->count() == 0)  --}}
                        @if(true)
                            <h3 class="text text-center"> No Projects Yet </h3>
                            @else
                            <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Project</th>
                                            <th scope="col">Project title</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       workshop detailes here
                                        {{-- 
                                        @foreach ($categories as $category)
                                            <tr>
                                                <th> {{ $i  }} </th>
                                                <td>
                                                    {{ $category->name }}
                                                </td>
                                                {{-- since post method is defined in category model and reurns a relation ship VERY IMPORTANT --}}
                                                {{-- Note Call name only not function with () because if u need to do query use () 
                                                <td> {{ $category->posts->count() }} </td>
                                                <td class="white-space: nowrap">
                                                    <button class="btn btn-danger btn-sm float-right" onClick="handleDelete({{ $category->id }})">Delete</button>
                                                    <a href="{{route('categories.edit',$category->id)}}" class="btn btn-primary btn-sm mx-2 float-right">Edit</a> 
                                                </td>
                                            </tr>
                                           
                                        @endforeach --}}

                                    </tbody>
                            </table>
                        @endif
                    </div>
            </div>
            {{-- use {{ route ('routename')}} instead of static one so helpful if u wanna change any path/name  --}}
            {{-- u can set a name using ->name('create'); in (routes) as the first one for home check it --}}
            {{-- or bring the name using php artisan route:list  --}}
        <a href="{{route('joinworkshop')}}" class="btn btn-success float-right my-2">Join Workshop</a>
            
            {{-- <!-- Modal --> --}}
            {{-- <form id="deletecatform" action="" method="post">
                @csrf
                @method('DELETE')
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModal">Delete Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    Are you sure you want to delete this category ? 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script> 
    function handleDelete(id){


        // console.log('deleting' , id)
        // Catch the form and set the action give it the id u want 
        // since we are using java script we have 1 form not more
        // not a set of forms in a loop so we need to bring the id 
        // the only way is to handle it in the function and from the function set it in the action 
        var form = document.getElementById('deletecatform');
        //console.log(form);
        form.action = '/categories/' + id;
        // Display thi Modal
        $('#deleteModal').modal('show');

        // return is not necessary but u should use it to let this fucntion work in FIREFOX/.. BROWSERS ...
        return true;

    }
</script>  --}}
@endsection
