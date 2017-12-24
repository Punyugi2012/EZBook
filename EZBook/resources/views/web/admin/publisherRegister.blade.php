@extends('web.templates.app')
@section('title', 'เพิ่มสำนักพิมพ์')
@section('header')
    @include('web.components.headerSecond')
@endsection
@section('content')
    <style>
        span {
            color:red;
        }
    </style>
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
            <div class="col-md-6" style="border-right:1px solid grey">
                <h1 class="text-center">เพิ่มสำนักพิมพ์/นักเขียน</h1>
                <form action="/admin-create-publisher" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name"><span>*</span>ชื่อ:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อสำนักพิมพ์" required>
                    </div>
                    <div class="form-group">
                        <label for="address"><span>*</span>ที่อยู่:</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="ที่อยู่" required>
                    </div>
                    <div class="form-group">
                        <label for="phone"><span>*</span>เบอร์โทรศัพท์:</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><span>*</span>อีเมลล์:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลล์" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                        <button type="reset" class="btn btn-warning">ล้าง</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <p><span>*</span>กรุณากรอกข้อมูล ณ ช่องกรอก ที่มี "<span>*</span>" นำหน้า</p>
                <p><span>*</span>ตรวจสอบความถูกต้องก่อนกดเพิ่ม</p>
            </div>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection