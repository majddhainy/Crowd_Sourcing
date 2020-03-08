@extends('layouts.app')

@section('content')
<center>
@if ($workshop->finished)
<form method="get" action="{{route('results',$workshop->id)}}">
<input type=submit class="btn btn-success my-5" value="See Results">
</form>
@else
@if (auth()->user()->can_vote)
<div class="alert my-5 alert-danger">
    <h2>Please wait until all participants finish voting !</h2>
</div>
@else
<form method=post action="{{route('shuffilecards',$workshop->id)}}">
    @csrf
    @method('put')
    <input type=submit class="btn btn-success my-5" value="Shuffile & Distribute">
</form>
@endif
@endif
</center>
@endsection