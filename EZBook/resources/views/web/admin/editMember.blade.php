@extends('web.templates.app')
@section('title', 'แก้ไขสมาชิก')
@section('header')
    @include('web.components.headerSecond')
@endsection
@section('content')
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
                  <h1 class="text-center">แก้ไข สถานะสมาชิก</h1>
                    <form action="/admin-edit-member/{{$member->id}}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="text-center">
                            <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status_member" value="able" {{$member->status == 'able' ? 'checked' : ''}}> <span class="text-success">ใช้งาน</span>
                            </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="status_member" value="unable"  {{$member->status == 'unable' ? 'checked' : ''}}> <span class="text-danger">ไม่ใช้งาน</span>
                                </label>
                            </div>
                        </div>
                        <div class="text-center" style="margin-top:20px">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
            </div>
             <div class="col-md-6">
                <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก</p>
            </div>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection