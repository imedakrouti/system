<table class="table table-bordered">

    <tr>
        <th>{{ trans('student::local.student_name') }}</th>
        <td>{{ $student->student_name }}</td>
    </tr>
    <tr>
        <th>{{ trans('student::local.father_mobile') }}</th>
        <td>{{ $student->father->mobile1 }} {{ $student->father->mobile2 }}</td>
    </tr>
    <tr>
        <th>{{ trans('student::local.mother_mobile') }}</th>
        <td>{{ $student->mother->mobile1_m }} {{ $student->mother->mobile2_m }}</td>
    </tr>
    <tr>
        <th>{{ trans('student::local.gender') }}</th>
        <td>{{ $student->gender }}</td>
    </tr>
    <tr>
        <th>{{ trans('student::local.religion') }}</th>
        <td>{{ $student->religion }}</td>
    </tr>
    <tr>
        <th>{{ trans('student::local.nationality_id') }}</th>
        <td>{{ $student->nationality }}</td>
    </tr>

</table>
