@extends('web.templates.app')
@section('title', 'EditNews')
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
                <h1 class="text-center">แก้ไขข่าวสาร</h1>
                <form action="/admin-edit-news/{{$news->id}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="title">หัวข้อ:</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{$news->title}}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">รายละเอียด:</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{$news->description}}</textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="reset" class="btn btn-warning">ล้าง</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดบันทึก</p>
            </div>
        </div>
    </div>
@endsection