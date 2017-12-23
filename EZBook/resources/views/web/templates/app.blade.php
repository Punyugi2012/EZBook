<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <style>
        .container-fluid {
            height:100%;
        }
        body {
		    font-family: 'Prompt', sans-serif;
            background-color: #F2F6F9;
        }
    </style>
</head>
<body>
    @yield('header')
    <div class="container-fluid">
        @yield('content')
    </div>
    <div class="footer" style="background-color:#C0C0C0;color:white">
        <div class="row" style="padding:20px;border-bottom:1px solid grey">
            <div class="col-md-4" style="border-right:1px solid grey">
                <h3 class="text-center">บริษัท EZBooks จำกัด</h3>
                <h3 class="text-center"><i class="fa fa-book" aria-hidden="true"></i> EZBooks</h3>
            </div>
            <div class="col-md-4" style="border-right:1px solid grey">
                <h3 class="text-center">การติดต่อ</h3>
                <p>ที่อยู่: มหาวิทยาลัยบูรพา 169 ถนน ลงหาดบางแสน อำเภอ เมืองชลบุรี จังหวัดชลบุรี</p>
                <p>เบอร์โทรศัพท์:  043851639</p>
                <p>อีเมลล์: EZBooks98@gmail.com</p>
            </div> 
            <div class="col-md-4">
                <h3 class="text-center">เว็ปไซต์ในเครือ</h3>
                <p>เร็วๆนี้</p>
            </div>    
        </div>
        <div class="row" style="padding:20px">
            <div class="col-md-3">
                <img class="rounded img-thumbnail" src="https://f.ptcdn.info/355/010/000/1380536996-1380153215-o.jpg" style="width:300px;height:300px">
            </div>
            <div class="col-md-3">
                <img class="rounded img-thumbnail" src="http://3.bp.blogspot.com/-5FTyqjf327M/VMIA5AkhbDI/AAAAAAAAAAg/_y_fP2DV7zA/s1600/intro.jpg" style="width:300px;height:300px">
            </div>
            <div class="col-md-3">
                <img class="rounded img-thumbnail" src="http://2.bp.blogspot.com/-12zXtTwm2XE/UeJCiqyNXVI/AAAAAAAAAnc/zX1RHk5OEeg/s1600/$RDIYIB7.JPG" style="width:300px;height:300px">
            </div>
            <div class="col-md-3">
                    <img class="rounded img-thumbnail" src="http://3.bp.blogspot.com/-fyGpiCRGcKI/T_qIORIwqzI/AAAAAAAAAHQ/cn_ci5yocLI/s1600/DSCN7164.JPG" style="width:300px;height:300px">
                </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    @yield('javascript')
</body>
</html>