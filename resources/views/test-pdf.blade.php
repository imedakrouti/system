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
            margin-right: 200px;         
            margin-bottom: 20px;            
            background-image: url({{$design}});
            background-size: cover;
            width: 350px;height:180px;
        }
        .school-name{
            width: 100%;height: 40px; line-height: 2;color: #fff;padding-right: 10px;
            font-weight: bold;
        }
        .data{
            width: 100%;height: 140px
        }
        .student-data{
            float:right;width: 200px;height: 140px;font-size: 11px;
            padding: 0 5px;padding-top:40px;
        }
        .student-image{
            float: left;width: 80px;height: 140px;margin-left: 10px;padding-top: 40px;
            line-height: .5;
          
        }

        img {`
            vertical-align: middle;
           
            border-radius: 50px
            }
        .photo{  border:2px solid #333;
                 background-color: white;
                }

    </style>
</head>
<body>
    @foreach ($students as $student)    
        <div class="design">
            <div class="school-name">
                {{$schoolName}}
            </div>
            <div class="data">
                <div class="student-data">
                    {{ trans('student::local.student_name') }} : {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}           
                    <br>
                    {{ trans('student::local.division') }} : {{$student->division->ar_division_name}}
                    <br>
                    {{ trans('student::local.grade') }} : {{$student->grade->ar_grade_name}}
                     <br>
                     {{ trans('student::local.father_mobile') }} : {{$student->father->mobile1}}
                     <br>
                     {{ trans('student::local.mother_mobile') }} : {{$student->mother->mobile1_m}}
                     <br>
                </div>
                <div class="student-image">
                    <div class="photo">
                        <img src="{{$studentPathImage}}{{$student->student_image}}">
                    </div>
                </div>
            </div>
        </div>        
    @endforeach

</body>
</html>