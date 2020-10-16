@include('layouts.backEnd.layout-report.header')
<div class="right-header" style="margin-top: 20px;margin-right:-50px;">
    <img src="{{$logo}}" alt="" class="logo">
</div>
<div class="center-header">
    {{ trans('student::local.admission_department') }} <br>
    {{$schoolName}} 
    <h4 class="center">{{ trans('student::local.application_reprot') }}</h4>
</div>
<div class="left-header">
    <div class="photo">
        @if (!empty($student->student_image))
            <img height="128"  width="120" src="{{$studentPathImage}}{{$student->student_image}}">                        
        @endif
    </div>
</div>
<div class="clear"></div>
<hr>
<div style="margin-top: -10px;">
    <div class="{{session('lang') =='ar' ? 'right' : 'left;'}}" 
    style="width: 50%;{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
        <strong>{{ trans('student::local.application_date') }}:</strong>
            {{DateTime::createFromFormat("Y-m-d",$student->application_date)->format("Y/m/d")}} <br>       
        <strong>{{ trans('student::local.student_name') }} : </strong>
            @if (session('lang') == 'ar')
                {{$student->ar_student_name}} <br>
            @else
                {{$student->en_student_name}} <br>
            @endif   
        <strong>{{ trans('student::local.nationality_id') }}:</strong>
            @if (session('lang') == 'ar')
                @if ($student->gender == trans('student::local.male'))
                    {{$student->nationalities->ar_name_nat_male}}  <br>                 
                @else
                    {{$student->nationalities->ar_name_nat_female}}  <br>                                     
                @endif
            @else
                {{$student->nationalities->en_name_nationality}} <br>                                   
            @endif
        <strong>{{ trans('student::local.dob') }}:</strong>
            {{DateTime::createFromFormat("Y-m-d",$student->dob)->format("Y/m/d")}} <br> 
        <strong>{{ trans('student::local.type') }}:</strong>
            {{$student->gender}} <br>
        <strong>{{ trans('student::local.religion') }}:</strong>
            {{$student->religion}} <br>
        <strong>{{ trans('student::local.reg_type') }}:</strong>
            {{$student->reg_type}} <br>
    </div>
    {{-- ************************************************************************** --}}
    <div class="{{session('lang') =='ar' ? 'right' : 'left;'}}" 
    style="width: 50%;{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
        <strong>{{ trans('student::local.year') }}:</strong>
            {{fullAcademicYear($student->year_id)}} <br>
       
        <strong>{{ trans('student::local.student_number') }}:</strong>
            {{$student->student_number}} <br>
        <strong>{{ trans('student::local.student_id_number') }}:</strong>
            {{$student->student_id_number}} <br>
        <strong>{{ trans('student::local.place_birth') }}:</strong>
            {{$student->place_birth}} <br>
        <strong>{{ trans('student::local.native_lang_id') }}:</strong>
            @if (session('lang') == 'ar')
                {{$student->native->ar_name_lang}} <br>
            @else
                {{$student->native->en_name_lang}} <br>
            @endif 
        <strong>{{ trans('student::local.second_lang_id') }}:</strong>
            @if (session('lang') == 'ar')
                {{$student->languages->ar_name_lang}} <br>
            @else
                {{$student->languages->en_name_lang}} <br>
            @endif                                   
    </div>
</div>
<hr>
<div style="margin-top: -10px;">
    <div class="{{session('lang') =='ar' ? 'right' : 'left;'}}" 
    style="width: 50%;{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
        <strong>{{ trans('student::local.father_name') }} : </strong>
            @if (session('lang') == 'ar')
                {{$student->father->ar_st_name}} 
                {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} <br>
            @else
                {{$student->father->en_st_name}} 
                {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} <br>
            @endif  
        <strong>{{ trans('student::local.mother_name') }}:</strong>
            {{$student->mother->full_name}} <br>  
        <strong>{{ trans('student::local.father_mobile') }}:</strong>
            {{$student->father->mobile1}} -  {{$student->father->mobile2}} <br>  
        <strong>{{ trans('student::local.mother_mobile') }}:</strong>
            {{$student->mother->mobile1_m}} -  {{$student->mother->mobile2_m}} <br>    
        <strong>{{ trans('student::local.father_job') }}:</strong>
            {{$student->father->job}} <br>    
        <strong>{{ trans('student::local.father_nationality') }}:</strong>
        @if (session('lang') == 'ar')
            @if ($student->gender == trans('student::local.male'))
                {{$student->father->nationalities->ar_name_nat_male}}  <br>                 
            @else
                {{$student->father->nationalities->ar_name_nat_female}}  <br>                                     
            @endif
        @else
            {{$student->nationalities->en_name_nationality}} <br>                                   
        @endif                                                    
    </div>
        <div class="{{session('lang') =='ar' ? 'right' : 'left;'}}" 
    style="width: 50%;{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
        <strong>{{ trans('student::local.father_id_number') }}:</strong>
            {{$student->father->id_number}} <br>  
        <strong>{{ trans('student::local.id_number_m') }}:</strong>
            {{$student->mother->id_number_m}} <br> 
        <strong>{{ trans('student::local.father_email') }}:</strong>
            {{$student->father->email}} <br>   
        <strong>{{ trans('student::local.email_m') }}:</strong>
            {{$student->father->email_m}} <br>
        <strong>{{ trans('student::local.job_m') }}:</strong>
            {{$student->mother->job_m}} <br>                                                  
    </div>
</div>
<hr>
<div style="{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
    <strong>{{ trans('student::local.the_address') }}: </strong>
    {{$student->father->block_no}} {{$student->father->street_name}} 
    {{$student->father->state}} {{$student->father->government}}
</div>
<hr>
<div style="{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
    <strong>{{ trans('student::local.educational_mandate') }}: </strong>{{$student->father->educational_mandate}} <br>
    <strong>{{ trans('student::local.marital_status') }}: </strong>{{$student->father->marital_status}} <br>
    <strong>{{ trans('student::local.recognition') }}: </strong>{{$student->father->recognition}} <br>
</div>
<hr>
{{-- documents required --}}
<div style="{{session('lang') =='ar' ? 'direction:rtl' : 'direction:ltr;float:left'}}">
    <h4>{{ trans('student::local.student_documents') }}</h4>
    @php
              $reg_type = '';
            switch ($student->reg_type) {
                case 'مستجد':
                    $reg_type = 'new';
                    break;
                case 'محول':
                    $reg_type = 'transfer';
                    break; 
                case 'عائد':
                    $reg_type = 'return';
                    break;                                           
                default:
                    $reg_type = 'arrival';                
                    break;
            }
    @endphp
    <ol>
        @foreach ($required_documents as $doc)
            @if (str_contains($doc->registration_type, $reg_type))
                <li><input type="checkbox">
                    {{ session('lang') == 'ar'?$doc->ar_document_name:$doc->en_document_name}} 
                    @if (!empty($doc->notes))
                        [{{$doc->notes}}]                    
                    @endif
                </li>                             
            @endif            
        @endforeach
    </ol>
</div>
<div class="signature">
    <h3 style="text-align: left; margin-left:120px;">
        <strong>
            {{ trans('student::local.parent') }}	
            &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp; 	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;
            &nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;	&nbsp;
            {{ trans('student::local.signature') }}
        </strong>
    </h3>
</div>

@include('layouts.backEnd.layout-report.footer')