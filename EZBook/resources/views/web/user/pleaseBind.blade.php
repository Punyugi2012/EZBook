@extends('web.templates.app') 
@section('title', 'กรุณาผูกบัตรเครดิตกับระบบก่อน') 
@section('header') 
    @include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h1 class="text-center">กรุณาผูกบัตรเครดิตกับระบบก่อน</h1>
            <p class="text-center">เข้าไปที่เมนู บัญชี ในข้อมูลส่วนตัว เพื่อผูกบัตรเครดิตกับระบบ <a href="/user-profile">กดเพื่อเข้าไปที่ข้อมูลส่วนตัว</a> </p>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection