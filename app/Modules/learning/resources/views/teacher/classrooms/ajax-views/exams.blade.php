<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ trans('learning::local.exam_name') }}</th>
            <th>{{ trans('learning::local.date') }}</th>
            <th>{{ trans('learning::local.mark') }}</th>
            <th>{{ trans('learning::local.evaluation') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($exams as $exam)
            <tr>
                <td>{{ $exam->exam_name }}</td>
                <td>
                    @foreach ($exam->userExams as $answer)
                        @if ($exam->id == $answer->exam_id)
                            {{ $answer->created_at }} <br>
                        @endif
                    @endforeach
                </td>
                <td>
                    {{ $exam->userAnswers->sum('mark') }} / <strong>{{ $exam->total_mark }}</strong>
                </td>
                <td>
                    {{evaluation($exam->total_mark, $exam->userAnswers->sum('mark'))}}
                </td>

            </tr>
        @endforeach
    </tbody>
