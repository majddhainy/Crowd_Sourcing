@extends('layouts.app')

@section('sidebar')
    
@endsection
{{-- added view --}}
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success')}}
                    </div>
                @endif
                <div class="card">
                    <form method="post" action="{{route('chooseprojects',$workshop->id)}}">
                    <div class="card-header">Voting Results</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th> 
                                    <th scope="col">Card </th>
                                    <th scope="col">Total Score</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @csrf
                                <?php $i = 1 ?>
                                @foreach ( $cards as $card)
                                    <tr> 
                                        <th> {{ $i  }} </th>
                                        <td>  {{ $card->title }}  </td>
                                        <td>{{ $card->score }}  </td>
                                        <td><input type="checkbox" name="projects[]"> </td>
                                    </tr>
                                    <?php $i++ ?>
                                @endforeach
                            </tbody>
                    </table>
                    </div>
                    <button  type="submit" class="btn btn-success  my-2 float-right">Choose As Projects</button>
                    </form>
                </div>    
            </div>
        </div>
    </div>
@endsection
