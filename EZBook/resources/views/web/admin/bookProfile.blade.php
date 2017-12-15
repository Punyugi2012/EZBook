@extends('web.templates.app')
@section('title', 'BookProfile')
@section('header')
    <nav class="navbar navbar-light bg-light justify-content-between">
        <span>
            <a class="navbar-brand">EZBooks Admin</a>
        </span>
        <span>
            <a href="/admin-logout" class="btn btn-primary">Logout</a>
        </span>
    </nav>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            หนังสือ: {{$book->name}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 text-center">
                    <div class="row">
                        <div class="col-md-5">
                            @foreach($book->images as $image)
                                <div>
                                    <a href="{{$image->url_image}}" target="_blank">
                                        <img src="{{$image->url_image}}" alt="image" style="width:100px;height:100px"/>
                                    <a>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-4">
                            <img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:250px;height:300px"/>
                        </div>
                    </div>
                </div>
                <div class="cold-md-6">
                    <p>ชื่อหนังสือ: {{$book->name}}</p>
                    <p>ราคา: {{$book->price}}</p>
                    <p>ประเภท: {{$book->type}}</p>
                    <p>ขนาดไฟล์: {{$book->file_size}}</p>
                    <p>จำนวนหน้า: {{$book->num_page}} หน้า</p>
                    <p>คะแนน: {{$book->score}}</p>
                    <p>ผู้แต่ง:</p>
                    <p>สำนักพิมพ์: {{$book->publisher}}</p>
                    <p>วันที่ตีพิมพ์: {{$book->date_publish}}</p>
                    <p>รายละเอียด: {{$book->detail}}</p>
                    <p>สถานะ: {{$book->status}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection