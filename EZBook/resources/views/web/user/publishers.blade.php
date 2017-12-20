@extends('web.templates.app')
@section('title', 'Publishers')
@section('header')
    @include('web.components.header')
@endseciton
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            สำนักพิมพ์/นักเขียน ทั้งหมด
        </div>
        <div class="card-body">
            <div class="row">
             @foreach($publishers as $publisher)
                <div class="col-md-3">
                    <a href="/user-books/publisher/{{$publisher->id}}">{{$publisher->name}}</a>
                </div>
            @endforeach
            </div>
        </div>
        <div>
            {{$publishers->links()}}
        </div>
    </div>
@endsection