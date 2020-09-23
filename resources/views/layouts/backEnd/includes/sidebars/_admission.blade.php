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
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a href="{{route('students.index')}}"><i class="la la-graduation-cap">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students') }}</span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='guardians'?'active':''}}">
            <a href="{{route('guardians.index')}}"><i class="la la-male">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.guardians') }}</span>
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
                <li class=" nav-item {{request()->segment(2)=='meetsings'?'active':''}}">
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
                <li class=" nav-item {{request()->segment(2)=='statements'?'active':''}}">
                    <a href="{{route('statements.index')}}"><i class="la la-database">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_statements') }}</span>
                    </a>
                </li>                      
                <li class=" nav-item {{request()->segment(2)=='meetings'?'active':''}}">
                    <a href="{{route('meetings.index')}}"><i class="la la-arrows-v">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.distribution_students') }}</span>
                    </a>
                </li>  
            
                <li class=" nav-item {{request()->segment(2)=='meetsings'?'active':''}}">
                    <a href="{{route('assessment-result.index')}}"><i class="la la-bed">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.absenece') }}</span>
                    </a>
                </li>  
                <li class=" nav-item {{request()->segment(2)=='parent-reports'?'active':''}}">
                    <a href="{{route('parent-reports.index')}}"><i class="la la-archive">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.archive') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='student-reports'?'active':''}}">
                    <a href="{{route('student-reports.index')}}"><i class="la la-car">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.commissioners') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='employee-admission'?'active':''}}">
                    <a href="{{route('employee-admission')}}"><i class="la la-exchange">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.transfers') }}</span>
                    </a>
                </li> 
                <li class=" nav-item {{request()->segment(2)=='employee-admission'?'active':''}}">
                    <a href="{{route('employee-admission')}}"><i class="la la-cc-discover">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_id_card') }}</span>
                    </a>
                </li>                             
            </ul>
        </li>   
        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">
                <li class="{{request()->segment(3)=='years'?'active':''}}"><a class="menu-item" href="{{route('years.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.academic_years') }}</a></li>           
                <li class="{{request()->segment(3)=='divisions'?'active':''}}"><a class="menu-item" href="{{route('divisions.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.divisions') }}</a></li>           
                <li class="{{request()->segment(3)=='stages'?'active':''}}"><a class="menu-item" href="{{route('stages.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.stages') }}</a></li>           
                <li class="{{request()->segment(3)=='grades'?'active':''}}"><a class="menu-item" href="{{route('grades.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.grades') }}</a></li>           
                <li class="{{request()->segment(3)=='stages-grades'?'active':''}}"><a class="menu-item" href="{{route('stages-grades.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.stages_grades') }}</a></li>           
                <li class="{{request()->segment(3)=='admission-documents'?'active':''}}"><a class="menu-item" href="{{route('admission-documents.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.admission_documents') }}</a></li>           
                <li class="{{request()->segment(3)=='documents-grades'?'active':''}}"><a class="menu-item" href="{{route('documents-grades.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.grade_documents') }}</a></li>           
                <li class="{{request()->segment(3)=='steps'?'active':''}}"><a class="menu-item" href="{{route('steps.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.admission_steps') }}</a></li>           
                <li class="{{request()->segment(3)=='acceptance-tests'?'active':''}}"><a class="menu-item" href="{{route('acceptance-tests.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.acceptance_tests') }}</a></li>           
                <li class="{{request()->segment(3)=='registration-status'?'active':''}}"><a class="menu-item" href="{{route('registration-status.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.registration_status') }}</a></li>           
                <li class="{{request()->segment(3)=='nationalities'?'active':''}}"><a class="menu-item" href="{{route('nationalities.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.nationalities') }}</a></li>           
                <li class="{{request()->segment(3)=='interviews'?'active':''}}"><a class="menu-item" href="{{route('interviews.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.interviews') }}</a></li>           
                <li class="{{request()->segment(3)=='languages'?'active':''}}"><a class="menu-item" href="{{route('languages.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.languages') }}</a></li>           
                <li class="{{request()->segment(3)=='classrooms'?'active':''}}"><a class="menu-item" href="{{route('classrooms.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.classrooms') }}</a></li>           
                <li class="{{request()->segment(3)=='id-designs'?'active':''}}"><a class="menu-item" href="{{route('id-designs.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.id_designs') }}</a></li>           
                <li class="{{request()->segment(3)=='schools'?'active':''}}"><a class="menu-item" href="{{route('schools.index')}}" ><i class="la la-angle-left"></i> {{ trans('admin.schools_names') }}</a></li>           
            </ul>
        </li>                                              
      </ul>
    </div>
  </div>
