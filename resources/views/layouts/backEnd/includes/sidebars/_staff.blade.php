<div class="main-menu menu-dark menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          {{-- back --}}
          <li class=" nav-item">
              <a href="{{route('main.dashboard')}}"><i class="la la-undo">
                  </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.main_departments') }}</span>
              </a>
          </li>        
        {{-- dashboard --}}
        <li class=" nav-item {{request()->segment(2)=='dashboard'?'active':''}}">
            <a href="{{route('dashboard.staff')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>      
        {{-- employees --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-users"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.employees') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-database">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_data') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-search">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.advanced_search') }}</span>
                    </a>
                </li>                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-archive">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.attachments') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-trash">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_trash') }}</span>
                    </a>
                </li>
            </ul>
        </li>    --}}
     
        {{-- attendance --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-clock-o"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.attendance') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.daily_absence') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.attendance') }}</span>
                    </a>
                </li>                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.import_attendance') }}</span>
                    </a>
                </li>
            </ul>
        </li>    --}}
        
        {{-- leaves requests --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-road"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.leave_requests') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.leave_requests') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_requests') }}</span>
                    </a>
                </li>                
            </ul>
        </li>    --}}
        
        {{-- deductions --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-gavel"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.deductions') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.deductions') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_deductions') }}</span>
                    </a>
                </li>                
            </ul>
        </li>   --}}
        
        {{-- loans --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-minus-square"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.loans') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.loans') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_loans') }}</span>
                    </a>
                </li>                
            </ul>
        </li>   --}}
        
        {{-- vacations --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-plane"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.vacations') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.vacations') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_vacations') }}</span>
                    </a>
                </li>                
            </ul>
        </li>    --}}
        
        {{-- payrolls --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-money"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.payrolls') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.process_payroll') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.temporary_components') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.fixed_components') }}</span>
                    </a>
                </li>    
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.reports') }}</span>
                    </a>
                </li>                                                
            </ul>
        </li>      --}}

        {{-- training --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-certificate"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.training') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.training') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.trainers') }}</span>
                    </a>
                </li>                
            </ul>
        </li>    --}}

        {{-- recruitment --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-flag"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.recruitment') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.applicants') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.vacancies') }}</span>
                    </a>
                </li>                
            </ul>
        </li>           --}}

        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">                
                {{-- <li><a class="menu-item" href="#" data-i18n="nav.form_elements.form_select.main"><i class="la la-folder"></i>{{ trans('student::local.reports_forms') }}</a>
                    <ul class="menu-content">
                      <li class="{{request()->segment(3)=='statement-request'?'active':''}}"><a class="menu-item" href="{{route('statement-request.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.hr_letter_form') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='leave-request'?'active':''}}"><a class="menu-item" href="{{route('leave-request.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.employee_leave_form') }}</a>
                      </li>                      
                      <li class="{{request()->segment(3)=='daily-request'?'active':''}}"><a class="menu-item" href="{{route('daily-request.get')}}" data-i18n="nav.form_elements.form_select.form_selectize"><i class="la la-file-text"></i>{{ trans('staff::local.employee_experience_form') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='proof-enrollment'?'active':''}}"><a class="menu-item" href="{{route('proof-enrollment.get')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('staff::local.employee_vacation_form') }}</a>
                      </li>                       
                    </ul>
                </li>                    --}}
                <li class="{{request()->segment(3)=='sectors'?'active':''}}"><a class="menu-item" href="{{route('sectors.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.sectors') }}</a></li>           
                <li class="{{request()->segment(3)=='departments'?'active':''}}"><a class="menu-item" href="{{route('departments.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.departments') }}</a></li>           
                <li class="{{request()->segment(3)=='sections'?'active':''}}"><a class="menu-item" href="{{route('sections.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.sections') }}</a></li>           
                <li class="{{request()->segment(3)=='positions'?'active':''}}"><a class="menu-item" href="{{route('positions.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.positions') }}</a></li>           
                <li class="{{request()->segment(3)=='documents'?'active':''}}"><a class="menu-item" href="{{route('documents.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.required_documents') }}</a></li>                           
                <li class="{{request()->segment(3)=='skills'?'active':''}}"><a class="menu-item" href="{{route('skills.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.skills') }}</a></li>           
                <li class="{{request()->segment(3)=='holidays'?'active':''}}"><a class="menu-item" href="{{route('holidays.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.holidays') }}</a></li>           
                {{--<li class="{{request()->segment(3)=='admission-documents'?'active':''}}"><a class="menu-item" href="{{route('admission-documents.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.leave_types') }}</a></li>           
                <li class="{{request()->segment(3)=='steps'?'active':''}}"><a class="menu-item" href="{{route('steps.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.timetables') }}</a></li>           
                <li class="{{request()->segment(3)=='acceptance-tests'?'active':''}}"><a class="menu-item" href="{{route('acceptance-tests.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.machines') }}</a></li>           
                <li class="{{request()->segment(3)=='registration-status'?'active':''}}"><a class="menu-item" href="{{route('registration-status.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.external_codes') }}</a></li>           
                <li class="{{request()->segment(3)=='nationalities'?'active':''}}"><a class="menu-item" href="{{route('nationalities.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.salary_components') }}</a></li>           
                <li class="{{request()->segment(3)=='interviews'?'active':''}}"><a class="menu-item" href="{{route('interviews.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.payrolls_statement') }}</a></li>                            --}}
            </ul>
        </li>                                                      
      </ul>
    </div>
  </div>
