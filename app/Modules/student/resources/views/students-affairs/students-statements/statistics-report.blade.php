@include('layouts.backEnd.layout-report.header')
<div class="left-header" >
    <img src="{{$logo}}" alt="" class="logo">
</div>
<div class="right-header">
    {{ trans('admin.students_affairs') }} <br>
    {{$schoolName}}     
</div>
<div class="clear"></div>
<hr>
<h4 class="center">{{ trans('student::local.statistics') }}</h4>
<table>
    <thead>
        <tr>
            <th rowspan="2">{{ trans('student::local.grade') }}</th>
            <th colspan="3">{{ trans('student::local.muslim') }}</th>
            <th colspan="3">{{ trans('student::local.non_muslim') }}</th>
            <th rowspan="2">{{ trans('student::local.totalStudents') }}</th>
        </tr>
        <tr>
            <th>{{ trans('student::local.boy') }}</th>
            <th>{{ trans('student::local.girl') }}</th>
            <th>{{ trans('student::local.totalStudents') }}</th>
            <th>{{ trans('student::local.boy') }}</th>
            <th>{{ trans('student::local.girl') }}</th>
            <th>{{ trans('student::local.totalStudents') }}</th>
        </tr>      
    </thead>
    <tbody>
        {{$i = 0}}
        @foreach ($grades as $grade)                        
                <tr>
                    <td>{{ $grade->ar_grade_name}}</td>
                    <td>{{ $male_muslims[$i] }}</td>
                    <td>{{ $female_muslims[$i] }}</td>
                    <td class="blue"><strong>{{ $male_muslims[$i] +  $female_muslims[$i] }}</strong></td>
                    <td>{{ $male_non_muslims[$i] }}</td>
                    <td>{{ $female_non_muslims[$i] }}</td>
                    <td class="blue"><strong>{{ $male_non_muslims[$i] + $female_non_muslims[$i] }}</strong></td>
                    <td class="blue">
                        <strong>{{ $male_muslims[$i] +  $female_muslims[$i] + $male_non_muslims[$i] + $female_non_muslims[$i] }}</strong>
                    </td>
                </tr>    
                {{$i++}}                                  
        @endforeach    
        <tr>
            <td class="red"><strong>{{ trans('student::local.totalStudents') }}</strong></td>     
            <td class="red"><strong>{{ array_sum($male_muslims) }}</strong></td>     
            <td class="red"><strong>{{ array_sum($female_muslims) }}</strong></td>     
            <td class="red"><strong>{{ array_sum($male_muslims) + array_sum($female_muslims) }}</strong></td>     
            <td class="red"><strong>{{ array_sum($male_non_muslims) }}</strong></td>     
            <td class="red"><strong>{{ array_sum($female_non_muslims) }}</strong></td>     
            <td class="red"><strong>{{ array_sum($male_non_muslims) + array_sum($female_non_muslims) }}</strong></td>     
            <td class="red"><strong>
                {{ array_sum($male_muslims) + array_sum($female_muslims)+ 
                 array_sum($male_non_muslims) + array_sum($female_non_muslims) }}
            </strong></td>     
   
        </tr>                           
    </tbody>
</table>
<div class="signature">
    <h3 style="text-align: left; margin-left:80px;"><strong>{{ trans('admin.students_affairs') }}</strong></h3>
</div>
@include('layouts.backEnd.layout-report.footer')