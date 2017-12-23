@extends('web.templates.app') 
@section('title', 'PleaseBind') 
@section('header') 
    @include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h1>กรุณาผูกบัญชีกับระบบก่อน</h1>
            <p>เข้าไปที่บัญชีในข้อมูลส่วนตัว เพื่อผูกบัตรเครดิตกับระบบ <a href="/user-profile">กดเพื่อเข้าไปที่ข้อมูลส่วนตัว</a> </p>
        </div>
    </div>
@endsection