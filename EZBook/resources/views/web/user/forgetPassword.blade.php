@extends('web.templates.app') 
@section('title', 'ลืมรหัสผ่าน') 
@section('header') 
    @include('web.components.header') 
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6" style="border-right:1px solid grey">
                    <h1 class="text-center">ลืมรหัสผ่าน</h1>
                    <form action="/send-email" method="post" autocomplete="off">  
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username"><span style="color:red">*</span>Username:</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label for="email"><span style="color:red">*</span>อีเมลล์:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="อีเมลล์">
                        </div>
                        <div class="text-center">
                        <button type="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <p><span style="color:red">*</span>กรุณากรอกข้อมูลให้ครบถ้วน</p>
                    <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดยืนยัน</p>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection