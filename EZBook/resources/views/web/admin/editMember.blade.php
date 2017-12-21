@extends('web.templates.app')
@section('title', 'EditNews')
@section('header')
    @include('web.components.headerSecond')
@endsection
@section('content')
    <div class="border border-secondary rounded" style="padding: 50px; margin-top: 30px">
        <h1>แก้ไข สถานะสมาชิก</h1>
        <form action="/admin-edit-member/{{$member->id}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div>
                <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="status_member" value="able" {{$member->status == 'able' ? 'checked' : ''}}> ใช้งาน
                </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="status_member" value="unable"  {{$member->status == 'unable' ? 'checked' : ''}}> ไม่ใช้งาน
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
    </div>
@endsection