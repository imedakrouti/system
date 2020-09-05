<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .mt-1{margin-top: 100px;"}
        .text-align{text-align:justify}
    </style>
</head>
<body>
    <h4 class="mt-1">{{ trans('student::local.report_title') }} : {{$report_title}}</h4>
    <h6>{{ trans('student::local.created_by') }} : {{$admin['name']}}</h6>
    <h6>{{ trans('student::local.created_at') }} : {{$created_at}}</h6>
    <h6>{{ trans('student::local.updated_at') }} : {{$updated_at}}</h6>
    <h4 class="mt-1">{{ trans('student::local.parent_name') }} : 
        {{$fathers['ar_st_name']}}
        @if (session('lang') == trans('admin.ar'))
            {{$fathers['ar_st_name']}} {{$fathers['ar_nd_name']}} {{$fathers['ar_rd_name']}} {{$fathers['ar_th_name']}}
        @else
        {{$fathers['en_st_name']}} {{$fathers['en_nd_name']}} {{$fathers['en_rd_name']}} {{$fathers['en_th_name']}}
        @endif   
    </h4>
    <hr>
    <h4 >{{$report}}</h4>    
</body>
</html>