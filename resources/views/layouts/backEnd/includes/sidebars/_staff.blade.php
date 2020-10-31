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
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-users"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.employees') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='employees'?'active':''}}">
                    <a href="{{route('employees.index')}}"><i class="la la-database">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_data') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='advanced-search'?'active':''}}">
                    <a href="{{route('employees.advanced-search')}}"><i class="la la-search">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.advanced_search') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='attachments'?'active':''}}">
                    <a href="{{route('attachments.index')}}"><i class="la la-archive">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.attachments') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='leaved'?'active':''}}">
                    <a href="{{route('employees.leaved')}}"><i class="la la-external-link">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_leaved') }}</span>
                    </a>
                </li>                
                              

                <li class=" nav-item {{request()->segment(2)=='trash'?'active':''}}">
                    <a href="{{route('employees.trash')}}"><i class="la la-trash">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_trash') }}</span>
                    </a>
                </li>
            </ul>
        </li>   
     
        {{-- attendance --}}
        <li class=" nav-item {{request()->segment(2)=='attendances'?'active':''}}"><a href="#">
            <i class="la la-clock-o"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.attendance') }}</span></a>
            <ul class="menu-content">                
                {{-- <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.daily_absence') }}</span>
                    </a>
                </li> --}}
                <li class=" nav-item {{request()->segment(3)=='logs'?'active':''}}">
                    <a href="{{route('attendances.logs')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.attendance') }}</span>
                    </a>
                </li>                 
                <li class=" nav-item {{request()->segment(3)=='import' || request()->segment(3)=='sheet'?'active':''}}">
                    <a href="{{route('attendances.import')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.import_attendance') }}</span>
                    </a>
                </li>
            </ul>
        </li>    
        
        {{-- leaves requests --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-road"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.leave_permissions') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='leave-permissions'?'active':''}}">
                    <a href="{{route('leave-permissions.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.leave_permissions') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='leave-permissions-confirm'?'active':''}}">
                    <a href="{{route('leave-permissions.confirm')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_requests') }}</span>
                    </a>
                </li>       
                <li class=" nav-item {{request()->segment(2)=='leave-permissions-deduction'?'active':''}}">
                    <a href="{{route('leave-permissions.deduction')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.leave_deduction') }}</span>
                    </a>
                </li>           
            </ul>
        </li>  
        
        {{-- deductions --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-gavel"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.deductions') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='deductions'?'active':''}}">
                    <a href="{{route('deductions.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.deductions') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='deductions-confirm'?'active':''}}">
                    <a href="{{route('deductions.confirm')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_deductions') }}</span>
                    </a>
                </li>                
            </ul>
        </li>   
        
        {{-- loans --}}
         <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-minus-square"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.loans') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='loans'?'active':''}}">
                    <a href="{{route('loans.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.loans') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='loans-confirm'?'active':''}}">
                    <a href="{{route('loans.confirm')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_loans') }}</span>
                    </a>
                </li>                
            </ul>
        </li>   
        
        {{-- vacations --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-plane"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.vacations') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='vacations'?'active':''}}">
                    <a href="{{route('vacations.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.vacations') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='vacations-confirm'?'active':''}}">
                    <a href="{{route('vacations.confirm')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.confirm_vacations') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='vacations-balance'?'active':''}}">
                    <a href="{{route('vacations.balance')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.vacation_balance') }}</span>
                    </a>
                </li>                
            </ul>
        </li> 
        
        {{-- payrolls --}}
        <li class=" nav-item {{request()->segment(2)=='payrolls'?'active':''}}"><a href="#">
            <i class="la la-money"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.payrolls') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(3)=='payroll-process'?'active':''}}">
                    <a href="{{route('payroll-process.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.process_payroll') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(3)=='temporary-component'?'active':''}}">
                    <a href="{{route('temporary-component.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.temporary_components') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(3)=='fixed-component'?'active':''}}">
                    <a href="{{route('fixed-component.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.fixed_components') }}</span>
                    </a>
                </li>   
                <li class=" nav-item {{request()->segment(3)=='payrolls-sheets'?'active':''}}">
                    <a href="{{route('payrolls-sheets.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.payrolls_sheets') }}</span>
                    </a>
                </li>     
                {{-- <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-minus">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.reports') }}</span>
                    </a>
                </li>                                                 --}}
            </ul>
        </li>     

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
                <li><a class="menu-item" href="#" data-i18n="nav.form_elements.form_select.main"><i class="la la-folder"></i>{{ trans('student::local.reports_forms') }}</a>
                    <ul class="menu-content">
                      <li class="{{request()->segment(3)=='header'?'active':''}}"><a class="menu-item" href="{{route('header.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.header_form') }}</a></li>
                      <li class="{{request()->segment(3)=='footer'?'active':''}}"><a class="menu-item" href="{{route('footer.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.footer_form') }}</a></li>
                      <li class="{{request()->segment(3)=='hr-letter'?'active':''}}"><a class="menu-item" href="{{route('hr-letter.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.hr_letter_form') }}</a></li>                    
                      <li class="{{request()->segment(3)=='employee-leave'?'active':''}}"><a class="menu-item" href="{{route('employee-leave.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('staff::local.employee_leave_form') }}</a></li>                      
                      <li class="{{request()->segment(3)=='employee-experience'?'active':''}}"><a class="menu-item" href="{{route('employee-experience.get')}}" data-i18n="nav.form_elements.form_select.form_selectize"><i class="la la-file-text"></i>{{ trans('staff::local.employee_experience_form') }}</a></li>                      
                      <li class="{{request()->segment(3)=='employee-vacation'?'active':''}}"><a class="menu-item" href="{{route('employee-vacation.get')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('staff::local.employee_vacation_form') }}</a></li>                      
                      <li class="{{request()->segment(3)=='employee-loan'?'active':''}}"><a class="menu-item" href="{{route('employee-loan.get')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('staff::local.employee_loan_form') }}</a></li>                      
                    </ul>
                </li>                    
                <li class="{{request()->segment(3)=='timetables'?'active':''}}"><a class="menu-item" href="{{route('timetables.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.timetables') }}</a></li>           
                <li class="{{request()->segment(3)=='holidays'?'active':''}}"><a class="menu-item" href="{{route('holidays.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.holidays') }}</a></li>           
                <li class="{{request()->segment(3)=='leave-types'?'active':''}}"><a class="menu-item" href="{{route('leave-types.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.leave_types') }}</a></li>           
                <li class="{{request()->segment(3)=='sectors'?'active':''}}"><a class="menu-item" href="{{route('sectors.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.sectors') }}</a></li>           
                <li class="{{request()->segment(3)=='departments'?'active':''}}"><a class="menu-item" href="{{route('departments.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.departments') }}</a></li>           
                <li class="{{request()->segment(3)=='sections'?'active':''}}"><a class="menu-item" href="{{route('sections.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.sections') }}</a></li>           
                <li class="{{request()->segment(3)=='positions'?'active':''}}"><a class="menu-item" href="{{route('positions.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.positions') }}</a></li>           
                <li class="{{request()->segment(3)=='documents'?'active':''}}"><a class="menu-item" href="{{route('documents.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.required_documents') }}</a></li>                           
                <li class="{{request()->segment(3)=='skills'?'active':''}}"><a class="menu-item" href="{{route('skills.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.skills') }}</a></li>           
                <li class="{{request()->segment(3)=='machines'?'active':''}}"><a class="menu-item" href="{{route('machines.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.machines') }}</a></li>           
                <li class="{{request()->segment(3)=='salary-components'?'active':''}}"><a class="menu-item" href="{{route('salary-components.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.salary_components') }}</a></li>           
                <li class="{{request()->segment(3)=='external-codes'?'active':''}}"><a class="menu-item" href="{{route('external-codes.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('staff::local.external_codes') }}</a></li>           
                
            </ul>
        </li>                                                      
      </ul>
    </div>
  </div>
