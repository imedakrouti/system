<table class="table">
    <thead>
        <tr>                        
            @foreach ($salary_components as $com_id)
                <th>
                    {{session('lang') == 'ar' ? $com_id->ar_item : $com_id->en_item}}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>                          
                @foreach ($employee->payrollComponents as $item)
                    @if ($item->employee_id == $employee->id)
                        <td>
                            {{$item->value}}
                        </td>                                      
                    @endif                                                            
                @endforeach
            </tr>
        @endforeach
    </tbody>
  
</table>