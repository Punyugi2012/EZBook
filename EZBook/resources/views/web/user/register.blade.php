@extends('web.templates.app')
@section('title', 'การสมัครสมาชิก')
@section('header')
    @include('web.components.header')
@endsection
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8" style="border-right:1px solid grey">
                    <h1 class="text-center">การสมัครสมาชิก</h1>
                    <form action="/user-register" method="post" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                            <div class="form-group">
                            <label for="id_card"><span style="color:red">*</span>เลขที่บัตรประชาชน:</label>
                            <input type="text" class="form-control" name="id_card" id="id_card" placeholder="เลขที่บัตรประชาชน" required>
                        </div>
                        <div class="form-group">
                            <label for="name"><span style="color:red">*</span>ชื่อ:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ" required>
                        </div>
                        <div class="form-group">
                            <label for="surname"><span style="color:red">*</span>นามสกุล:</label>
                            <input type="text" class="form-control" name="surname" id="surname" placeholder="นามสกุล" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><span style="color:red">*</span>เบอร์โทรศัพท์:</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" required>
                        </div>
                        <div class="form-group">
                            <label for="address"><span style="color:red">*</span>ที่อยู่:</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="ที่อยู่" required>
                        </div>
                        <span style="color:red">*</span>เพศ:
                        <div class="form-group">
                            <div class="form-check d-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="gender" value="male" checked>
                                เพศชาย
                            </label>
                            </div>
                            <div class="form-check d-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="gender" value="female">
                                เพศหญิง
                            </label>
                            </div>
                        </div>
                        <div class"form-group">
                            <label for="birthday"><span style="color:red">*</span>วันเกิด:</label>
                            <input type="date" name="birthday" id="birthday" class="form-control" required>
                        </div>
                        <div class="form-group" style="margin-top:10px">
                            <div class="image"></div>
                            <label for="image">รูปประจำตัว:</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>
                        <div class="form-group">
                            <label for="username"><span style="color:red">*</span>username:</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><span style="color:red">*</span>email:</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลล์" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><span style="color:red">*</span>password:</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                            <button type="reset" class="btn btn-warning">ล้าง</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <p><span style="color:red">*</span>กรุณากรอกข้อมูล ณ ช่องกรอก ที่มี "<span style="color:red">*</span>" นำหน้า</p>
                    <p><span style="color:red">*</span>กรุณาตรวจสอบความถูกต้องก่อนกดยืนยัน</p>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom:300px">
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
             function readURL(input, placeToInsertImagePreview) {
                console.log('hi');
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $($.parseHTML('<img style="max-width:200px;max-height:200px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image").on('change', function() {
                readURL(this, 'div.image');
            });   
        });
    </script>
@endsection