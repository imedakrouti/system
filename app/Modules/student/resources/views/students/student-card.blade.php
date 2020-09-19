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
        .center{text-align: center}
        .design{   
            margin-right: 190px;         
            margin-bottom: 20px;            
            background-image: url({{$design}});
            background-size: cover;
            width: 370px;height:180px;
        }
        .school-name{
            width: 100%;height: 40px; line-height: 2;color: #fff;padding-right: 10px;
            /* font-weight: bold; */
        }
        .data{
            width: 100%;height: 140px
        }
        .student-data{
            float:right;width: 200px;height: 140px;font-size: 9px;
            padding: 0 10px;padding-top:40px;
        }
        .student-image{
            float: left;width: 80px;height: 140px;margin-left: 10px;padding-top: 40px;
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
        <div class="school-name">
            <h3>{{$schoolName}}</h3>
        </div>
        <div class="data">
            <div class="student-data">                
                @if (session('lang') == 'ar')
                    <h3 class="center">{{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}<br>          
                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}    </h3>        
                @else
                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} <br>         
                    {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}           
                @endif                
                <h4 style="font-weight: 100">{{ trans('student::local.division') }} : {{$student->division->ar_division_name}} <br>
                    {{ trans('student::local.grade') }} : {{$student->grade->ar_grade_name}} <br>                            
                    {{ trans('student::local.father_mobile') }} : {{$student->father->mobile1}} <br>                  
                    {{ trans('student::local.mother_mobile') }} : {{$student->mother->mobile1_m}} 
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