@extends('web.templates.app')
@section('title', 'FreeBooks')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
        <span style="font-size:20px">
            หนังสือฟรีทั้งหมด, <a href="javascript:void(0)">{{$books->total()}}</a>
        </span>
        </div>
        <div class="card-body">
            @if (count($books) == 0)
            <div class="alert alert-warning text-center">
                ไม่พบหนังสือฟรี
            </div>
            @endif
            <div class="row">
             @foreach($books as $book)
                <div class="col-md-3 text-center">
                    <a href="/book/{{$book->id}}">
                        <img class="rounded border border-secondary" src="{{$book->url_cover_image}}" alt="cover image" style="width:120px;height:150px">
                    </a>
                    <p>{{$book->name}}</p>
                    <p>ราคา: <span class="badge badge-success">ฟรี</span></p>
                    <p><span class="badge badge-info">จำนวนคนอ่าน: {{$book->num_read}}</span></p>
                </div>
            @endforeach
            </div>
        </div>
        <div>
            {{$books->links()}}
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection