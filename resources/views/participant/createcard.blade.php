@extends('layouts.editedapp')
@section('content')
<div class="card" style="margin-top:3%;margin-left:15%;margin-right:15%">
    <div class="card-header">Workshop Details</div>
        <div class="card-body">
            <div class="form-group"><p class="float-left">Title:</p>
            <input name="title" type="text" class="form-control" value="{{$workshop->title}}" readonly>
            </div>
            <div class="form-group"><p class="float-left">Description:</p>                   
                <textarea cols="8" rows="4" name="body"  class="form-control" readonly>{{$workshop->body}}</textarea>
            </div>
        </div>
    </div>
@if (!$workshop->can_submit)
<div class="alert my-5 alert-danger">
    <h2>Please wait until workshop starts !</h2>
</div>
@else
<div class="card" style="margin-left:15%;margin-right:15%">
    <div class="card-header">Submit Your Card</div>
        <div class="card-body">
        <form method="post" action="{{route('storecard',$workshop->id)}}">
                @csrf
                <div class="form-group">
                    <input name="title" placeholder="Title" type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <textarea cols="8" rows="4" name="body" placeholder="Solution Idea"  class="form-control" required></textarea>
                </div>
                <button type="submit"  class="btn btn-primary btn-md float-right" >Submit Card</button>
            </form>
        </div>
    </div>
@endif
@endsection