@extends('web.templates.app')
@section('title', 'สำนักพิมพ์/นักเขียน')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            <span style="font-size:20px">
                สำนักพิมพ์/นักเขียน ทั้งหมด, <a href="javascript:void(0)">{{$publishers->total()}}</a>
            </span>
        </div>
        <div class="card-body">
            @if (count($publishers) == 0)
            <div class="alert alert-warning text-center">
                ไม่พบสำนักพิมพ์
            </div>
            @endif
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
    <div style="margin-bottom:300px">
    </div>
@endsection