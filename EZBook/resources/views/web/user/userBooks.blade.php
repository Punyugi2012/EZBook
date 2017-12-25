@extends('web.templates.app')
@section('title', 'หนังสือของคุณ')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
<div class="card" style="margin-top:100px">
    <div class="card-header">
        <span style="font-size:20px">
        หนังสือของฉัน, ทั้งหมด <a href="javascript:void(0)">{{$purchases->total()}}</a> เล่ม
        </span>
    </div>
    <div class="card-body">
        @if (count($purchases) == 0)
            <div class="alert alert-warning text-center">
                ไม่พบหนังสือของท่าน
            </div>
        @endif
        <div class="row">
        @foreach($purchases as $purchase)
            <div class="col-md-3 text-center">
                <a href="/book/{{$purchase->book->id}}">
                    <img class="rounded border border-secondary" src="{{$purchase->book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                </a>
                <p>{{$purchase->book->name}}</p>
            </div>
        @endforeach
        </div>
    </div>
    <div>
        {{$purchases->links()}}
    </div>
</div>
<div style="margin-bottom:300px">
</div>
@endsection