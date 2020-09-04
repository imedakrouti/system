<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab1" data-toggle="tab" href="#active1" aria-controls="active1"
                            aria-expanded="true">{{ trans('student::local.interviews_dates') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="link-tab1" data-toggle="tab" href="#active2" aria-controls="link1"
                            aria-expanded="false">{{ trans('student::local.add_edit_meetings') }}</a>
                        </li>      
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="active1" aria-labelledby="active-tab1"  aria-expanded="true">
                            <div class="row">
                                <div id='fc-basic-views'></div>
                            </div>
                                 
                        </div>
                        <div class="tab-pane" id="active2" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">
                            <div class="table-responsive">
                                <form action="" id='formData' method="post">
                                    @csrf
                                    <table id="dynamic-table" class="table data-table" style="width: 100%">
                                        <thead class="bg-info white">
                                            <tr>
                                                <th><input type="checkbox" class="ace" /></th>
                                                <th>#</th>
                                                <th>{{trans('student::local.father_name')}}</th>
                                                <th>{{trans('student::local.start_time')}}</th>                                                
                                                <th>{{trans('student::local.end_time')}}</th>                                                
                                                <th>{{trans('student::local.status')}}</th>
                                                <th>{{trans('student::local.edit')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  