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
            <a href="{{route('dashboard.admission')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>

        <li class=" nav-item {{request()->segment(2)=='parents'?'active':''}}">
            <a href="{{route('parents.index')}}"><i class="la la-users">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.parents') }}</span>
                <span class="badge badge badge-pill badge-danger float-right">
                    {{ Student\Models\Parents\Father::count() + Student\Models\Parents\Mother::count()}}
                </span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a href="{{route('students.index')}}"><i class="la la-graduation-cap">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students') }}</span>
                <span class="badge badge badge-pill badge-warning float-right">
                    {{Student\Models\Students\Student::count()}}
                </span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='guardians'?'active':''}}">
            <a href="{{route('guardians.index')}}"><i class="la la-male">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.guardians') }}</span>
                <span class="badge badge badge-pill badge-info float-right">
                    {{Student\Models\Guardians\Guardian::count()}}
                </span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='advanced-search'?'active':''}}">
            <a href="{{route('advanced.search')}}"><i class="la la-search">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.advanced_search') }}</span>
            </a>
        </li> 
        <li class=" nav-item {{request()->segment(2)=='calculate-student-age'?'active':''}}">
            <a href="{{route('calculate.age')}}"><i class="la la-calculator">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.calculate_student_page') }}</span>
            </a>
        </li>         
        {{-- admisssions --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#"><i class="la la-child"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.admissions') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='calendar'?'active':''}}">
                    <a href="{{route('calendar.index')}}"><i class="la la-calendar">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.calendar') }}</span>
                    </a>
                </li>
                          
                <li class=" nav-item {{request()->segment(2)=='meetings'?'active':''}}">
                    <a href="{{route('meetings.index')}}"><i class="la la-clock-o">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.interviews_dates') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='assessment-result'?'active':''}}">
                    <a href="{{route('assessment-result.index')}}"><i class="la la-check">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.assessment_results') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='parent-reports'?'active':''}}">
                    <a href="{{route('parent-reports.index')}}"><i class="la la-commenting">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.parent_reports') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='student-reports'?'active':''}}">
                    <a href="{{route('student-reports.index')}}"><i class="la la-commenting">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.student_reports') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='employee-admission'?'active':''}}">
                    <a href="{{route('employee-admission')}}"><i class="la la-user">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.employee_admission') }}</span>
                    </a>
                </li>                   
            </ul>
        </li>   
        {{-- students --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#"><i class="la la-graduation-cap"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.students_affairs') }}</span></a>
            <ul class="menu-content">
                {{-- reprots --}}
                <li><a class="menu-item" href="#" data-i18n="nav.form_elements.form_select.main"><i class="la la-folder"></i>{{ trans('student::local.reports') }}</a>
                    <ul class="menu-content">
                      <li class="{{request()->segment(3)=='statistics'?'active':''}}"><a class="menu-item" href="{{route('reports.statistics')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('student::local.statistics') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='student-data'?'active':''}}"><a class="menu-item" href="{{route('reports.student-data')}}" data-i18n="nav.form_elements.form_select.form_selectize"><i class="la la-file-text"></i>{{ trans('student::local.students_data') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='period'?'active':''}}"><a class="menu-item" href="{{route('reports.period')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('student::local.duration_reports') }}</a>
                      </li>                      
                    </ul>
                </li>              
                {{-- daily requests --}}
                <li class=" nav-item {{request()->segment(2)=='daily-requests'?'active':''}}">
                    <a href="{{route('daily-requests.index')}}"><i class="la la-sticky-note">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_permissions') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='statements'?'active':''}}">
                    <a href="{{route('statements.index')}}"><i class="la la-database">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_statements') }}</span>
                    </a>
                </li>                      
                <li class=" nav-item {{request()->segment(2)=='distribution-students'?'active':''}}">
                    <a href="{{route('distribution.index')}}"><i class="la la-arrows-v">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.distribution_students') }}</span>
                    </a>
                </li>  
            
                <li class=" nav-item {{request()->segment(2)=='absences'?'active':''}}">
                    <a href="{{route('absences.index')}}"><i class="la la-bed">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.absenece') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='parent-requests'?'active':''}}">
                    <a href="{{route('parent-requests.index')}}"><i class="la la-flag">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.parents_requests') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='commissioners'?'active':''}}">
                    <a href="{{route('commissioners.index')}}"><i class="la la-car">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.commissioners') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='transfers'?'active':''}}">
                    <a href="{{route('transfers.index')}}"><i class="la la-exchange">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.transfers') }}</span>
                    </a>
                </li>                 
                <li class=" nav-item {{request()->segment(2)=='leave-requests'?'active':''}}">
                    <a href="{{route('leave-requests.index')}}"><i class="la la-exchange">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.leave_requests') }}</span>
                    </a>
                </li>                 

                <li class=" nav-item {{request()->segment(2)=='student-cards'?'active':''}}">
                    <a href="{{route('student-cards.classroom')}}"><i class="la la-cc-discover">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_id_card') }}</span>
                    </a>
                </li> 
                                 
                <li class=" nav-item {{request()->segment(2)=='archives'?'active':''}}">
                    <a href="{{route('archives.index')}}"><i class="la la-archive">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.archive') }}</span>
                    </a>
                </li>                                                      
            </ul>
        </li>   
        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">
                {{-- reprots --}}
                <li><a class="menu-item" href="#" data-i18n="nav.form_elements.form_select.main"><i class="la la-folder"></i>{{ trans('student::local.reports_forms') }}</a>
                    <ul class="menu-content">
                      <li class="{{request()->segment(3)=='statement-request'?'active':''}}"><a class="menu-item" href="{{route('statement-request.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('student::local.statement_request') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='leave-request'?'active':''}}"><a class="menu-item" href="{{route('leave-request.get')}}" data-i18n="nav.form_elements.form_select.form_select2"><i class="la la-file-text"></i>{{ trans('student::local.student_leave_request') }}</a>
                      </li>                      
                      <li class="{{request()->segment(3)=='daily-request'?'active':''}}"><a class="menu-item" href="{{route('daily-request.get')}}" data-i18n="nav.form_elements.form_select.form_selectize"><i class="la la-file-text"></i>{{ trans('student::local.student_daily_request') }}</a>
                      </li>
                      <li class="{{request()->segment(3)=='proof-enrollment'?'active':''}}"><a class="menu-item" href="{{route('proof-enrollment.get')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('student::local.proof_enrollment') }}</a>
                      </li> 
                      <li class="{{request()->segment(3)=='parent-request'?'active':''}}"><a class="menu-item" href="{{route('parent-request.get')}}" data-i18n="nav.form_elements.form_select.form_selectivity"><i class="la la-file-text"></i>{{ trans('student::local.parent_request') }}</a>
                      </li>                                             
                    </ul>
                </li>                   
                <li class="{{request()->segment(3)=='years'?'active':''}}"><a class="menu-item" href="{{route('years.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.academic_years') }}</a></li>           
                <li class="{{request()->segment(3)=='divisions'?'active':''}}"><a class="menu-item" href="{{route('divisions.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.divisions') }}</a></li>           
                <li class="{{request()->segment(3)=='stages'?'active':''}}"><a class="menu-item" href="{{route('stages.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.stages') }}</a></li>           
                <li class="{{request()->segment(3)=='grades'?'active':''}}"><a class="menu-item" href="{{route('grades.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.grades') }}</a></li>           
                <li class="{{request()->segment(3)=='stages-grades'?'active':''}}"><a class="menu-item" href="{{route('stages-grades.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.stages_grades') }}</a></li>           
                <li class="{{request()->segment(3)=='classrooms'?'active':''}}"><a class="menu-item" href="{{route('classrooms.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.classrooms') }}</a></li>           
                <li class="{{request()->segment(3)=='admission-documents'?'active':''}}"><a class="menu-item" href="{{route('admission-documents.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.admission_documents') }}</a></li>           
                <li class="{{request()->segment(3)=='documents-grades'?'active':''}}"><a class="menu-item" href="{{route('documents-grades.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.grade_documents') }}</a></li>           
                <li class="{{request()->segment(3)=='steps'?'active':''}}"><a class="menu-item" href="{{route('steps.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.admission_steps') }}</a></li>           
                <li class="{{request()->segment(3)=='acceptance-tests'?'active':''}}"><a class="menu-item" href="{{route('acceptance-tests.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.acceptance_tests') }}</a></li>           
                <li class="{{request()->segment(3)=='registration-status'?'active':''}}"><a class="menu-item" href="{{route('registration-status.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.registration_status') }}</a></li>           
                <li class="{{request()->segment(3)=='nationalities'?'active':''}}"><a class="menu-item" href="{{route('nationalities.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.nationalities') }}</a></li>           
                <li class="{{request()->segment(3)=='interviews'?'active':''}}"><a class="menu-item" href="{{route('interviews.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.interviews') }}</a></li>           
                <li class="{{request()->segment(3)=='languages'?'active':''}}"><a class="menu-item" href="{{route('languages.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.languages') }}</a></li>           
                <li class="{{request()->segment(3)=='id-designs'?'active':''}}"><a class="menu-item" href="{{route('id-designs.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.id_designs') }}</a></li>           
                <li class="{{request()->segment(3)=='schools'?'active':''}}"><a class="menu-item" href="{{route('schools.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('admin.schools_names') }}</a></li>           
            </ul>
        </li>                                              
      </ul>
    </div>
  </div>
