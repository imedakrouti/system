<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item"><a href="{{route('main.dashboard')}}"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::admin.dashboard') }}</span></a>
        </li>
        <li class=" nav-item"><a href="#"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.employees') }}</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.employees_data') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.advanced_search') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.employee_attachment') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.reports') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.employees_deleted') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.attendance ') }}</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.daily_attendance') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.attendance_leave') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.import_attendance_sheet') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.leave_request') }}</span><span class="badge badge badge-info badge-pill float-right mr-2">3</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.leaves') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.approve_leaves') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.deductions') }}</span><span class="badge badge badge-info badge-pill float-right mr-2">3</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.add_deduction') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.approve_deductions') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.deleted_deductions') }}</a></li>
            </ul>
        </li>
        <li class="disabled nav-item"><a href="#"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.disabled_menu.main">{{ trans('staff::admin.loans') }}</span><span class="badge badge badge-info badge-pill float-right mr-2">3</span></a>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.vacations') }}</span><span class="badge badge badge-info badge-pill float-right mr-2">3</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.add_vacation') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.approve_vacations') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.deleted_vacations') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.vacation_balance') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.payroll') }}</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.add_vacation') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.approve_vacations') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.deleted_vacations') }}</a></li>
              <li><a class="menu-item" href="dashboard-sales.html" data-i18n="nav.dash.sales">{{ trans('staff::admin.vacation_balance') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.training') }}</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.courses') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.trainers') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="index.html"><i class="la la-home"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::admin.recruitment') }}</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="dashboard-ecommerce.html" data-i18n="nav.dash.ecommerce">{{ trans('staff::admin.vacancies') }}</a></li>
              <li><a class="menu-item" href="dashboard-crypto.html" data-i18n="nav.dash.crypto">{{ trans('staff::admin.applicants') }}</a></li>
            </ul>
        </li>
        <li class=" nav-item"><a href="{{route('staff.setting')}}"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::admin.settings') }}</span></a>
        </li>
      </ul>
    </div>
  </div>
