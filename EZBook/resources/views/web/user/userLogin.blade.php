@extends('web.templates.app')
@section('title', 'Login')
    @include('web.components.header')
@section('content')
<div class="card" style="margin-top:100px;padding:50px;box-shadow:0px 5px 5px 5px grey">
     <div class="card-body">
        <div class="row">
            <div class="col-md-6" style="border-right:1px solid grey">
                <div class="row">
                    <div class="col-md-6">
                        <img src="http://icons.iconarchive.com/icons/icons-land/vista-people/256/Person-Male-Dark-icon.png" alt="user" style="width:300px;height:300px">
                    </div>
                    <div class="col-md-6">
                        <p><span style="color:red">*</span>สมัครสมาชิก ก่อนเข้าสู่ระบบ</p>
                        <p><span style="color:red">*</span>คลิกปุ่ม ลืมรหัสผ่าน เพื่อขอรหัสผ่านในกรณีที่ลืมรหัสผ่าน</p>
                        <p><span style="color:red">*</span>สมัครสมาชิกหรือเข้าสู่ระบบไม่ได้ กรุณาติดต่อทางบริษัท</p>
                        <p><span style="color:red">*</span>บริษัท EZBooks โทร 043851639</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="text-center"><i class="fa fa-user-circle-o" aria-hidden="true"></i> เข้าสู่ระบบ</h1>
                <form action="user-login" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                    </div>
                    <a href="/user-register">สมัครสมาชิก</a>
                    <a href="/user-foget-pass">ลืมรหัสผ่าน</a>
                    <div style="margin-top:5px" class="text-center">
                        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection