@extends('layouts/app')

@section('title')
    {{$task->title}}
@endsection

@section('content')
<h1 class="text-center py-5">TODOS</h1>
            <div class="row justify-content-center">
                <div class="col-md-8">
                        <div class="card">
                                <div class="card-header text-center">
                                  {{$task->title}}
                                </div>
                                <div class="card-body">
                                  <p class="card-text">
                                  {{ $task->description }}
                                  </p>
                                  <a href="/todos/{{$task->id}}/delete" class="btn btn-danger ml-2 float-right">Delete</a>
                                  <a href="/todos/{{$task->id}}/edit" class="btn btn-warning ml-2 float-right">Edit</a>
                                  <a href="/todos" class="btn btn-secondary float-right">Back</a>
                                </div>
                              </div>
                </div>
            </div>
@endsection
