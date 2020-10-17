@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header">
    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="right-header">
        {{$governorate}} <br>
        {{$education_administration}} <br>  
        {{$school_name}}     
    </div>
    <div class="clear"></div>
    <hr>
    <h4 class="center">{{ trans('student::local.statistics') }} - {{ trans('student::local.year') }} {{$year_name}}</h4>
</htmlpageheader>
<h4 style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">{{ trans('student::local.total_students') }} : {{$total_students}}</h4>

<table style="direction: {{session('lang') == 'ar' ? 'rtl' : 'ltr'}}">
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
                
                @foreach ($stageGrade as $stage)
                    
                    @if ($stage->grade_id == $grade->id && $stage->end_stage ==  trans('student::local.yes') )
                        <tr style="background-color: rgb(155, 155, 155);color:rgb(251, 249, 249)">
                            <td><strong>{{ trans('student::local.total_statge') }}</strong></td>
                            <td>
                                <strong> 
                                    @foreach ($total_male_muslim as $key =>$value)
                                        @if ($stage->stage_id == $key) 
                                            {{$total_male_muslim[$stage->stage_id ]}}                                   
                                        @endif  
                                    @endforeach                                                         
                                </strong>
                            </td>
                            <td>
                                <strong>
                                    @foreach ($total_female_muslim as $key =>$value)
                                        @if ($stage->stage_id == $key) 
                                            {{$total_female_muslim[$stage->stage_id ]}}                                   
                                        @endif  
                                    @endforeach  
                                </strong>
                            </td>
                            <td>                                        
                                <strong>
                                    {{$total_male_muslim[$stage->stage_id ] + $total_female_muslim[$stage->stage_id ]}}
                                </strong>
                            </td>
                            <td>
                                <strong> 
                                    @foreach ($total_male_non_muslim as $key =>$value)
                                        @if ($stage->stage_id == $key) 
                                            {{$total_male_non_muslim[$stage->stage_id ]}}                                   
                                        @endif  
                                    @endforeach                                                         
                                </strong>                                
                            </td>
                            <td>
                                <strong>
                                    @foreach ($total_female_non_muslim as $key =>$value)
                                        @if ($stage->stage_id == $key) 
                                            {{$total_female_non_muslim[$stage->stage_id ]}}                                   
                                        @endif  
                                    @endforeach  
                                </strong>                                
                            </td>
                            <td>
                                <strong>
                                    {{$total_male_non_muslim[$stage->stage_id ] + $total_female_non_muslim[$stage->stage_id ]}}
                                </strong>                                
                            </td>
                            <td>
                                <strong>
                                    {{$total_male_muslim[$stage->stage_id ] + $total_female_muslim[$stage->stage_id ]+
                                    $total_male_non_muslim[$stage->stage_id ] + $total_female_non_muslim[$stage->stage_id ]}}
                                </strong>
                            </td>                                 
                        </tr>
                    @endif
                @endforeach 
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
            <td class="red">
                <strong>
                    {{ array_sum($male_muslims) + array_sum($female_muslims)+ 
                    array_sum($male_non_muslims) + array_sum($female_non_muslims) }}
                </strong>
            </td>        
        </tr>                           
    </tbody>
</table>
<div style="{{session('lang') == 'ar' ?'direction: rtl;':'direction: ltr;'}}">
    {{ trans('student::local.available_students') }} : 
    <strong>
        {{$total_students - (array_sum($male_muslims) + array_sum($female_muslims)+ 
            array_sum($male_non_muslims) + array_sum($female_non_muslims)) }} 
    </strong>
    {{ trans('student::local.student') }}
</div>
<div class="signature">
    <h3 style="text-align: left; margin-left:80px;"><strong>{{ trans('admin.students_affairs') }}</strong></h3>
</div>
@include('layouts.backEnd.layout-report.footer')