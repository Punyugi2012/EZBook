@extends('web.templates.app')
@section('title', 'สำนักพิมพ์/นักเขียน เข้าสู่ระบบ')
    @include('web.components.header')
@section('content')
<div class="card" style="margin-top:100px;padding:50px;box-shadow:0px 2px 3px 0px grey">
    <div class="card-body">
        @if (session()->has('publisher-login'))
            <div class="alert alert-danger text-center">
                {{session()->get('publisher-login')}}
            </div>
        @elseif(session()->has('publisher-logout'))
            <div class="alert alert-success text-center">
                {{session()->get('publisher-logout')}}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6" style="border-right:1px solid grey">
                <div class="row">
                    <div class="col-md-6">
                        <img src="http://th.seaicons.com/wp-content/uploads/2016/04/office-building-icon.png" alt="publisher" style="width:300px;height:300px">
                    </div>
                    <div class="col-md-6">
                        <p><span style="color:red">*</span>บุคคลที่สามารถเข้าสู่ระบบได้คือสำนักพิมพ์/นักเขียนที่ได้ลงทะเบียนกับทางบริษัท</p>
                        <p><span style="color:red">*</span>ถ้าเป็นสำนักพิมพ์/นักเขียนที่ได้ลงทะเบียนกับบริษัทแล้วไม่สามารถเข้าสู่ระบบได้ให้ติดต่อทางบริษัท</p>
                        <p><span style="color:red">*</span>ถ้าเป็นสำนักพิมพ์/นักเขียนที่ได้ลงทะเบียนกับบริษัทแล้วลืมusername,passwordให้ติดต่อทางบริษัท</p>
                        <p><span style="color:red">*</span>บริษัท EZBooks โทร 043851639</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="text-center"><i class="fa fa-home" aria-hidden="true"></i> สำนักพิมพ์/นักเขียน เข้าสู่ระบบ</h1>
                <form action="publisher-login" method="POST" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                    </div>
                    <div class="text-center">
                    <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div style="margin-bottom:300px">
</div>
@endsection