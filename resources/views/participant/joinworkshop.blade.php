@extends('layouts.app')


{{-- Note here we can use the same file for editing / creating categories to reduce number of files --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                
                @if(session()->has('message'))
                        <div class="alert alert-danger">
                            {{ session()->get('message') }}
                        </div>
                @endif


                <div class="card">
                {{-- if object category is sent so we are editing else we are creating  --}}
                <div class="card-header">Join A Workshop</div>

                    <div class="card-body">
                        {{-- in action u can just say the name of the route  --}}
                        {{-- also the name differs if editing or creating --}}
                    <form method="post" action="{{route('applytoworkshop')}}">
                            @csrf
                            <div class="form-group">
                                <input name="key" placeholder="Workshop Key" type="text" class="form-control">
                            </div>
                            <button type="submit"  class="btn btn-primary btn-md float-right" >Join</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


