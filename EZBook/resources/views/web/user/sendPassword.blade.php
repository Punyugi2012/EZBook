@extends('web.templates.app') 
@section('title', 'ส่งอีเมลล์สำเร็จ') 
@section('header') 
    @include('web.components.header') 
@endseciton
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body text-center">
            <h4>ทางเราได้ส่งรหัสผ่านไปทางอีเมลล์ของท่านแล้ว<h4>
            <br>
            <a href="/user-login">กลับไปหน้าเข้าสู่ระบบ</a>
        </div>
    </div>
@endsection