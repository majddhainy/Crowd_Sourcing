@extends('layouts.editedapp')

@section('content')
@if (!($workshop->voted==$workshop->participated))
<div class="alert my-5 alert-danger">
    <h2>Please wait until all participants finish submitting !</h2>
</div>
@else
<form method=get action="{{route('takescores',$workshop->id)}}">
    <input type=submit class="btn btn-success my-5" value="==Start Distrbuting Phase==">
</form>
@endif
@endsection