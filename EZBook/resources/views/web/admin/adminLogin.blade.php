@extends('web.templates.app')
@section('title', 'Login')
    @include('web.components.header')
@section('content')
    <div class="card" style="margin-top:100px;padding:50px;box-shadow:0px 5px 5px 5px grey">
        <div class="card-body">
            @if (session()->has('status'))
            <div class="alert alert-danger text-center">
                {{session()->get('status')}}
            </div>
            @elseif(session()->has('admin-logout'))
                <div class="alert alert-success text-center">
                    {{session()->get('admin-logout')}}
                </div>
            @endif
            <div class="row">
                <div class="col-md-6" style="border-right:1px solid grey">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="http://icons.iconarchive.com/icons/aha-soft/free-large-boss/512/Admin-icon.png" alt="admin" style="width:300px;height:300px">
                        </div>
                        <div class="col-md-6">
                            <p><span style="color:red">*</span>บุคคลที่สามารถเข้าสู่ระบบได้คือเจ้าหน้าที่ที่เป็นผู้ดูแลระบบ(admin)</p>
                            <p><span style="color:red">*</span>ถ้าเป็นเจ้าหน้าที่ดูแลระบบ(admin)แล้วไม่สามารถเข้าสู่ระบบได้ให้ติดต่อเจ้าหน้าที่ IT</p>
                            <p><span style="color:red">*</span>เจ้าหน้าที่ IT โทร 0625598598</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h1 class="text-center"><i class="fa fa-user" aria-hidden="true"></i> แอดมิน เข้าสู่ระบบ</h1>
                    <form action="admin-login" method="POST" autocomplete="off">
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
@endsection