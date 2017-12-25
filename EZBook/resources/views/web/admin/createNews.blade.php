@extends('web.templates.app')
@section('title', 'เพิ่มข่าวสาร')
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
                <h1 class="text-center">เพิ่มข่าวสาร</h1>
                <form action="/admin-create-news" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title"><span>*</span>หัวข้อ:</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="หัวข้อ" required>
                    </div>
                    <div class="form-group">
                        <label for="description"><span>*</span>รายละเอียด:</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="รายละเอียด"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">เพิ่ม</button>
                        <button type="reset" class="btn btn-warning">ล้าง</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-9/512/Warning-icon.png" alt="warning" style="width:200px;height:200px">
                </div>
                <p><span>*</span>กรุณากรอกข้อมูลให้ครบถ้วน</p>
                <p><span>*</span>ตรวจสอบความถูกต้องก่อนกดเพิ่ม</p>
            </div> 
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection