@extends('web.templates.app')
@section('title', 'Register')
    @include('web.components.header')
@section('content')
    <div class="card" style="margin-top:100px">
        <div class="card-header">
            สมัครสมาชิก
        </div>
        <div class="card-body">
            <form action="/user-register" method="post" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                 <div class="form-group">
                    <label for="id_card">เลขที่บัตรประชาชน:</label>
                    <input type="text" class="form-control" name="id_card" id="id_card" placeholder="เลขที่บัตรประชาชน" required>
                </div>
                <div class="form-group">
                    <label for="name">ชื่อ:</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อ" required>
                </div>
                <div class="form-group">
                    <label for="surname">นามสกุล:</label>
                    <input type="text" class="form-control" name="surname" id="surname" placeholder="นามสกุล" required>
                </div>
                <div class="form-group">
                    <label for="phone">เบอร์โทรศัพท์:</label>
                    <input type="number" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" required>
                </div>
                <div class="form-group">
                    <label for="address">ที่อยุ่:</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="จังหวัด/อำเภอ/ตำบล/บ้านเลขที่/หมู่" required>
                </div>
                เพศ:
                <div class="form-group">
                    <div class="form-check d-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked>
                        เพศชาย
                    </label>
                    </div>
                    <div class="form-check d-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="female">
                        เพศหญิง
                    </label>
                    </div>
                </div>
                <div class"form-group">
                    <label for="birthday">วันเกิด:</label>
                    <input type="date" name="birthday" id="birthday" class="form-control" required>
                </div>
                <div class="form-group" style="margin-top:10px">
					<img id="blah" src="#" alt="image" style="max-width:200px;max-height:200px" />
					<br>
					<label for="image">รูป:</label>
					<input type="file" class="form-control" name="image" id="image">
				</div>
                <div class="form-group">
                    <label for="username">username:</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
                </div>
                <div class="form-group">
                    <label for="email">email:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="อีเมลล์" required>
                </div>
                <div class="form-group">
                    <label for="password">password:</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-success">ยืนยัน</button>
                    <button type="reset" class="btn btn-warning">ล้าง</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
             function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#image").on('change', function() {
                readURL(this);
            });   
        });
    </script>
@endsection