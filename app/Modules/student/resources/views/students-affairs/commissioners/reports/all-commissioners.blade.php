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
    <h4 class="center">{{ trans('student::local.commissioners_data') }} </h4>
</htmlpageheader>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('student::local.commissioner_name') }}</th>
            <th>{{ trans('student::local.id_number_card') }}</th>
            <th>{{ trans('student::local.mobile_number') }}</th>
            <th>{{ trans('student::local.notes') }}</th>
        </tr>
    </thead>
    <tbody>
        {{$n=1}}
        @foreach ($commissioners as $commissioner)
            <tr>
                <td>{{$n}}</td>
                <td>{{$commissioner->commissioner_name}}</td>
                <td>{{$commissioner->id_number}}</td>
                <td>{{$commissioner->mobile}}</td>
                <td>{{$commissioner->notes}}</td>
            </tr>
        @endforeach
        {{$n++}}
    </tbody>
</table>


<htmlpagefooter name="page-footer">
   <p> {PAGENO}</p>
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')