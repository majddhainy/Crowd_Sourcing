@extends('layouts.app')

@section('content')
<?php $roles = ['Admin' , 'Monitor' , 'Participant'] ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Users</div>

                        <div class="card-body">
                             @if($users->count() == 0)
                                <h3 class="text text-center"> No Users Yet </h3>
                                @else
                                <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th> Role </th> 
                                                <th scope="col">Email</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- TRY TO MAKE COL ACTIONS AT THE END OF THE TABLE --}}
                                            <?php $i = 1; ?>
                                            @foreach ($users as $user)
                                                <tr> 
                                                    <th> {{ $i  }} </th>
                                                    <td>   {{ $roles[$user->role] }}</td>
                                                    {{-- <td> <img src="{{ asset( "storage/" . $user->image_path) }}" width="130" height="70"/> </td>  --}}
                                                    <td> {{$user->email }} </td>
                                                    {{-- in order to keep buttons in the same line use white-space: nowrap --}}
                                                    <td style='white-space: nowrap'>
                                                        @if ($user->role != 0)
                                                            <form method="post" action="{{ route('updateuser', $user->id)  }}" >
                                                                @method('PUT')
                                                                @csrf
                                                                @if($user->confirmed == '0')
                                                                    <button name="confirm" type="submit" class="btn btn-success btn-sm" >Confirm</button>
                                                                    @else 
                                                                    <button name="ban" type="submit" class="btn btn-danger btn-sm" >&nbsp; &nbsp;Ban &nbsp; &nbsp;</button>
                                                                @endif
                                                                <button name="remove" type="submit" class="btn btn-danger btn-sm" >Remove</button>
                                                            </form>     
                                                        @endif
                                                            
                                                    </td>
                                                </tr>
                                                <?php $i++ ?>
                                            @endforeach

                                        </tbody>
                                </table>
                            @endif
                        </div>
                </div>
                {{-- use {{ route ('routename')}} instead of static one so helpful if u wanna change any path/name  --}}
                {{-- u can set a name using ->name('create'); in (routes) as the first one for home check it --}}
                {{-- or bring the name using php artisan route:list  --}}
                {{-- <a href="{{ route('users.create') }}" class="btn btn-success float-right my-2">Add user</a> --}}
                <form method="post" action="{{ route('autoconfirm')  }}" >
                    @method('PUT')
                    @csrf
                    @if(auth()->user()->auto_confirm == '0')
                        <button  type="submit" class="btn btn-success  my-2 float-right" >Allow Auto Confirm</button>
                        @else 
                        <button  type="submit" class="btn btn-danger  my-2 float-right" >Disable Auto Confirm</button>
                    @endif
                </form>     
                
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts')
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
{{-- @endsection --}} 
