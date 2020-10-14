<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$classroom}}</title>
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
            margin-bottom: 20px;
            /* width: 370px;height:250px; */
            
        }
        .school-name-right{
            color: #fff;
            padding-right: 20px;
            padding-top: 2px;    
        
                  
        }
        .school-name-left{
            color: #fff;
            padding-left: 20px;
            padding-top: 2px;            
        }        

        .student-data-right{
            float:right;
            width: 200px;            
            font-size: 9px;
            padding-right: 20px;
            padding-top:-30px;
            text-align: right
        }
        .student-data-left{
            float:right;
            width: 200px;            
            font-size: 9px;
            padding-left: 20px;
            padding-top:-30px;
            text-align:left
        }
        .student-image-left{
            float: left;
            width: 80px;            
            margin-left: 220px;
            padding-top: 0px;
            line-height: .5;          
        }

        img {
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
    @foreach ($students as $student)
        <div class="design">
            <div class="{{session('lang') == 'ar' ? 'school-name-right' : 'school-name-left'}} position">
                <h4 class="">{{$schoolName}}</h4>
            </div>
            <div class="data position">
                <div class="{{session('lang') == 'ar' ? 'student-data-right':'student-data-left'}}">                
                    @if (session('lang') == 'ar')
                        <h3 class="center"> {{$student->ar_student_name}} {{$student->father->ar_st_name}}  {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} <br>
                            {{$student->en_student_name}} {{$student->father->en_st_name}}  {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
                        </h3>        
                    @else
                        <h3 class="center"> {{$student->en_student_name}} {{$student->father->en_st_name}}  {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} <br>
                            {{$student->ar_student_name}} {{$student->father->ar_st_name}}  {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
                        </h3>        
                    @endif      
                    @php
                        $grade = '';
                        $division = '';
                        if (session('lang') == 'ar') {
                            $grade = $student->grade->ar_grade_name;
                            $division = $student->division->ar_division_name;
                        }else{
                            $grade = $student->grade->en_grade_name;
                            $division = $student->division->en_division_name;
                        }
                    @endphp          
                    <h4 style="font-weight: 100">
                        {{ trans('student::local.student_number') }} : <strong><span class="red">{{$student->student_number}}</span></strong> <br>                    
                        {{ trans('student::local.grade') }} : {{$grade}} -  {{$division}}<br>                            
                        {{ trans('student::local.class_room') }} : {{$classroom}}<br>                            
                        {{ trans('student::local.father_mobile') }} : {{$student->father->mobile1}} - {{$student->father->mobile2}} <br>                  
                        {{ trans('student::local.mother_mobile') }} : {{$student->mother->mobile1_m}} - {{$student->mother->mobile2_m}}
                    </h4>                 
                </div>
                <div class="student-image-left">
                    <div class="photo">
                        <img height="76"  width="76" src="{{$studentPathImage}}{{$student->student_image}}">
                    </div>
                </div>
            </div>
        </div>         
    @endforeach

</body>
</html>