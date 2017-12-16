@extends('web.templates.app')
@section('title', 'Dashboard')
@section('header')
    <nav class="navbar navbar-light bg-light justify-content-between">
        <span>
            <a class="navbar-brand">EZBooks Admin</a>
        </span>
        <span>
            <a href="/admin-logout" class="btn btn-primary">Logout</a>
        </span>
    </nav>
@endsection
@section('content')
    <style>
        .nav li {
            margin-left: 5px;
        }
    </style>
    <div style="margin-top:20px">
        <ul class="nav nav-pills flex-column flex-sm-row">
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isPublishers?'active':''}}" href="/admin-publishers">สำนักพิมพ์</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isMembers?'active':''}}" href="/admin-members">สมาชิก</a>
            </li>
             <li class="nav-item">
                <a class="nav-link btn btn-light {{$isAuthors?'active':''}}" href="/admin-authors">ผู้แต่ง</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isUploadBooks?'active':''}}" href="/admin-uploadbooks">เพิ่มหนังสือ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-light {{$isBooks?'active':''}}" href="/admin-books">หนังสือ</a>
            </li>
        </ul>
    </div>
    <div style="margin-bottom:60px;margin-top:10px">
        @if($isPublishers)
            <div class="card">
                <div class="card-header">
                    สำนักพิมพ์
                </div>
                <div class="card-body">
                    <a href="/admin-regis-publisher" class="btn btn-info">เพิ่มสำนักพิมพ์</a>
                    <table class="table table-striped" style="margin-top:10px">
                        <thead>
                            <tr>
                            <th>ชื่อ</th>
                            <th>ที่อยู่</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>อีเมลล์</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publishers as $publisher)
                                <tr>
                                    <td>{{$publisher->name}}</td>
                                    <td>{{$publisher->address}}</td>
                                    <td>{{$publisher->phone}}</td>
                                    <td>{{$publisher->email}}</td>
                                    <td>{{$publisher->username}}</td>
                                    <td>{{$publisher->password}}</td>
                                    <td>{{$publisher->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($isUploadBooks)
            <div class="card">
                <div class="card-header">
                    เพิ่มหนังสือ
                </div>
                <div class="card-body">
                    <form action="/admin-create-book" enctype="multipart/form-data" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="publisher">สำนักพิมพ์:</label>
                            <select class="form-control" id="publisher" name="publisher" required>
                                <option value="">เลือกสำนักพิมพ์</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type">ประเภทหนังสือ:</label>
                            <select class="form-control" id="type" name="type" required>
                                    <option value="">เลือกประเภทหนังสือ</option>
                                @foreach($bookTypes as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">ชื่อหนังสือ:</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อหนังสือ" required>
                        </div>
                        <div class="form-group">
                            <label for="detail">รายละเอียด:</label>
                            <textarea class="form-control" id="detail" name="detail" rows="3" placeholder="รายละเอียด"></textarea>
                        </div>
                        เลือกผู้แต่ง:
                        <div style="overflow:auto;height:100px;padding:10px;border:1px solid #ced4da" class="rounded">
                            @foreach($authors as $author)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="authors[]" class="form-check-input"  value="{{$author->id}}">
                                        {{$author->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="detail">ราคา:</label>
                            <input type="number" class="form-control" name="price" id="price" value="0" placeholder="ราคา" required>
                        </div>
                           <div class="form-group">
                            <label for="discount">% ส่วนลด:</label>
                            <input type="number" class="form-control" name="discount" id="discount" value="0" placeholder="%ส่วนลด" required>
                        </div>
                        <div class="form-group">
                            <label for="file_size">ขนาดไฟล์:</label>
                            <input type="text" class="form-control" name="file_size" id="file_size" placeholder="ขนาดไฟล์" required>
                        </div>
                        <div class="form-group">
                            <label for="num_page">จำนวนหน้า:</label>
                            <input type="number" class="form-control" name="num_page" id="num_page" placeholder="จำนวนหน้า" required>
                        </div>
                        <div class="form-group">
                            <label for="publish">วันที่ตีพิมพ์:</label>
                            <input type="date" class="form-control" name="publish" id="publish" required>
                        </div>
                        <div class="form-group">
                            <img id="blah" src="#" alt="your cover image" style="max-width:200px;max-height:200px"/>
                            <br>
                            <label for="cover_image">รูปปก:</label>
                            <input type="file" class="form-control" name="cover_image" id="cover_image" required>
                        </div>
                        <div class="form-group">
                            your images
                            <div class="gallery"></div>
                            <label for="images">รูป:</label>
                            <input type="file" class="form-control" multiple name="images[]" id="images">
                        </div>
                        <div class="form-group">
                           <label for="file">file:</label>
                           <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status"  value="able" checked>
                                วางขาย
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="status" value="unable">
                                ยังไม่วางขาย
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">เพิ่ม</button>
                            <button type="reset" class="btn btn-warning">clear</button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($isMembers)
             <div class="card">
                <div class="card-header">
                    สมาชิก
                </div>
                <div class="card-body">
        
                </div>
            </div>
        @elseif($isBooks)
            <div class="card">
                <div class="card-header">
                    มีทั้งหมด {{$numOfBook}} เล่ม
                </div>
                <div class="card-body">
                    <div id="accordion" role="tablist">
                        @foreach($publishers as $publisher)
                            <div class="card">
                                <div class="card-header" role="tab" id="heading{{$loop->index}}">
                                    <a data-toggle="collapse" href="#collapse{{$loop->index}}" aria-expanded="true" aria-controls="collapse{{$loop->index}}">
                                        สำนักพิมพ์: {{$publisher->name}}, มีหนังสือจำนวน {{count($publisher->books)}} เล่ม
                                    </a>
                                </div>
                                <div id="collapse{{$loop->index}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$loop->index}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="card-body row">
                                            @foreach($publisher->books as $book)
                                                <div  class="col-md-3">
                                                    <a href="/admin-book/{{$book->id}}/publisher/{{$publisher->id}}">
                                                        <img class="border border-secondary rounded" src="{{$book->url_cover_image}}" alt="cover image" style="width:150px;height:200px"/>
                                                    </a>
                                                    <p style="margin-top:10px">ชื่อหนังสือ: {{$book->name}}</p>
                                                    <p>ราคา: {{$book->price == 0 ? 'ฟรี' : $book->price.'บาท'}}</p>
                                                    <p>ประเภท: {{$book->type}}</p>
                                                    <p>สถานะ: <span class="{{$book->status == 'able' ? 'text-success' : 'text-danger'}}">{{$book->status == 'able' ? 'วางขายอยู่' : 'ยังไม่วางขาย'}}</span></p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif($isAuthors)
             <div class="card">
                <div class="card-header">
                    ผู้แต่ง
                </div>
                <div class="card-body">
                    <a href="/admin-regis-author" class="btn btn-info">เพิ่มผู้แต่ง</a>
                    <table class="table table-striped" style="margin-top:10px">
                        <thead>
                            <tr>
                                <th>ชื่อ</th>
                                <th>อีเมลล์</th>
                                <th>เบอร์โทรศัพท์</th>
                                <th>created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authors as $author)
                                <tr>
                                    <td>{{$author->name}}</td>
                                    <td>{{$author->email}}</td>
                                    <td>{{$author->phone}}</td>
                                    <td>{{$author->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('javascript')
    @if($isUploadBooks)
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
            $("#cover_image").change(function() {
                readURL(this);
            });   
            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img style="max-width:200px;max-height:200px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });

        });
    </script>
    @endif
@endsection
    