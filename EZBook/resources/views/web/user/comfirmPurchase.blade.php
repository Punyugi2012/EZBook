@extends('web.templates.app') 
@section('title', 'ComfirmPurchase') 
@section('header') 
    @include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h1>การยืนยันการซื้อ</h1>
            <table class="table" style="margin-top:20px">
                <thead>
                    <tr>
                        <th scope="col">หนังสือ</th>
                        <th scope="col">ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{$book->url_cover_image}}" alt="cover_image" style="width:200px;height:200px">
                                </div>
                                <div clas="col-md-3 text-left">
                                    <p>ชื่อหนังสือ: {{$book->name}}</p>
                                    <p>ประเภท: {{$book->bookType->name}}</p>
                                    <p>จำนวนหน้า: {{$book->num_page}}</p>
                                    <p>ขนาดไฟล์: {{$book->file_size}}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($book->discount_percent == 0) 
                                <p>ราคา: {{$book->price}} บาท
                            @else
                                <p>
                                    ราคา: <span style="text-decoration: line-through;">{{$book->price}}</span> {{$book->price - ($book->price * $book->discount_percent / 100)}} บาท
                                </p>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right">
                <a href="/user-comfirm-purchase/book/{{$book->id}}" class="btn btn-success">ยืนยันการซื้อ</a>
                <a href="/book/{{$book->id}}" class="btn btn-warning">ยกเลิก</a>
            </div>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection