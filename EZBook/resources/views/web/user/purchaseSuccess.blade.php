@extends('web.templates.app') 
@section('title', 'PurchaseSuccess') 
@section('header') 
    @include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h1 class="text-center">ซื้อสำเร็จ</h1>
            <p class="text-center"><a href="/book/{{$book->id}}">กดเพื่อกลับไปหน้าหนังสือ</a><p>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection