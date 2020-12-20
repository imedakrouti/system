<table class="table table-bordered">
    <thead>
        <tr>
            <th>{{ trans('learning::local.title') }}</th>
            <th>{{ trans('learning::local.deliver_date') }}</th>
            <th>{{ trans('learning::local.mark') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($homeworks as $home)
            <tr>
                <td>{{ $home->homework->title }}</td>
                <td>{{ $home->created_at }}</td>
                <td>{{ $home->mark }} / <strong>{{ $home->homework->total_mark }}</strong></td>
            </tr>
        @endforeach
</tbody>
