<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Student Id</title>
    <style>
        body{
            font-family: 'XBRiyaz';
            
        }
        .red{color: red}
        .center{text-align: center}
        .position{
            margin-right: 190px;         
            margin-bottom: 20px;         
        }
        .design{                  
            background-image: url({{$design}});
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            /* width: 370px;height:250px; */
            
        }
        .school-name{
            color: #fff;
            padding-right: 20px;
            padding-top: 8px;            
        }

        .student-data{
            float:right;
            width: 200px;            
            font-size: 9px;
            padding-right: 20px;
            padding-top:-40px;
        }
        .student-image{
            float: left;
            width: 80px;
            /* height: 100px; */
            margin-left: 220px;
            padding-top: 0px;
            line-height: .5;          
        }

        img {`
            vertical-align: middle;           
            border-radius: 50px
            }
        .photo{  
            border:2px solid #333;
            background-color: white;
            }

    </style>
</head>
<body>
    <div class="design">
        <div class="school-name position">
            <h3 class="school-size">{{$schoolName}}</h3>
        </div>
        <div class="data position">zz
            <div class="student-data">                
                @if (session('lang') == 'ar')
                    <h3 class="center">{{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}<br>          
                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}    </h3>        
                @else
                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} <br>         
                    {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}           
                @endif                
                <h4 style="font-weight: 100">
                    {{ trans('student::local.student_number') }} : <strong><span class="red">{{$student->student_number}}</span></strong> <br>                    
                    {{ trans('student::local.grade') }} : {{$grade}} -  {{$division}}<br>                            
                    {{ trans('student::local.class_room') }} : {{$class_room}}<br>                            
                    {{ trans('student::local.father_mobile') }} : {{$student->father->mobile1}} - {{$student->father->mobile2}} <br>                  
                    {{ trans('student::local.mother_mobile') }} : {{$student->mother->mobile1_m}} - {{$student->mother->mobile2_m}} 
                </h4>                 
            </div>
            <div class="student-image">
                <div class="photo">
                    <img src="{{$studentPathImage}}{{$student->student_image}}">
                </div>
            </div>
        </div>
    </div> 

</body>
</html>