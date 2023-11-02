@extends('layouts/app')

@section('title')
    Todos Lists
@endsection

@section('content')

            <h1 class="text-center py-5">COMPLETED TODOS</h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                        <div class="card border-primary">
                                <div class="card-header bg-secondary text-center">
                                    Tasks List
                                </div>
                                <div class="card-body">
                                     <ul class="list-group">
                                             @foreach ($tasks as $task)
                                             @if ($task->completed)
                                                <li class="list-group-item list-group-item-action">
                                                    {{ $task->title }}
                                                <a href="/todos/{{$task->id}}" class="btn btn-primary btn-sm float-right">View</a>
                                                </li>
                                            @endif
                                             @endforeach
                                         </ul>
                                </div>
                            </div>
                </div>
            </div>


@endsection
