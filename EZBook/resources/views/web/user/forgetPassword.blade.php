@extends('web.templates.app') 
@section('title', 'ForgetPassword') 
@section('header') 
    @include('web.components.header') 
@endseciton
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <h1>ลืมรหัสผ่าน</h1>
            <form action="/send-email" method="post" autocomplete="off">  
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="username">
                </div>
                <div class="form-group">
                    <label for="email">อีเมลล์:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="อีเมลล์">
                </div>
                <button type="submit" class="btn btn-success">ยืนยัน</button>
            </form>
        </div>
    </div>
@endsection