@extends('web.templates.app')
@section('title', 'PublisherRegister')
@section('header')
    @include('web.components.headerSecond')
@endsection
@section('content')
    <div class="border" style="padding: 50px; margin-top: 30px">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6" style="border-right: 1px solid grey">
                <h1 class="text-center">เพิ่ม ผู้แต่ง</h1>
                <form action="/admin-create-author" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">ชื่อ:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อผู้แต่ง" required>
                    </div>
                    <div class="form-group">
                        <label for="email">อีเมลล์:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลล์" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">เบอร์โทรศัพท์:</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                        <button type="reset" class="btn btn-warning">ล้าง</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <p><span style="color:red">*</span>กรุณากรอกข้อมูลให้ครบถ้วน</p>
            </div>
        </div>
    </div>
@endsection