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
                <div class="card-header">Workshops</div>
                     {{-- {{ dd(auth()->user()->workshops )}} --}}
                     <?php $allworkshops = auth()->user()->pWorkshops ?>
                    <div class="card-body">
                        @if($allworkshops->count() == 0) 
                            <h3 class="text text-center"> No Worskhops Yet </h3>
                            @else
                            <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">workshop title</th>
                                            <th>workshop date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; ?>
                                        @foreach ($allworkshops as $workshop)
                                            <tr>
                                                <th> {{ $i  }} </th>
                                                <td>
                                                    {{ $workshop->title }}
                                                </td>
                                                <td>
                                                    {{ $workshop->created_at }}
                                                </td>
                                                {{-- since post method is defined in category model and reurns a relation ship VERY IMPORTANT --}}
                                                {{-- Note Call name only not function with () because if u need to do query use () --}}
                                                <td class="white-space: nowrap">
                                                <a href="{{route('results',$workshop->id)}}" class="btn btn-primary">View Projects</a>
                                                </td> 
                                            </tr>
                                        <?php $i++; ?>
                                        @endforeach

                                    </tbody>
                            </table>
                        @endif
                    </div>
            </div>

        
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
