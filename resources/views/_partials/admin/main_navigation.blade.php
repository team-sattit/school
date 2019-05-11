<?php $index = 1;?>
<div class="card card-sidebar-mobile  noprint">
	<ul class="nav nav-sidebar" data-nav-type="accordion">
		@if(Request::segment($index) == 'setup')
		<!-- Main -->
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">@lang('main')</div> <i class="icon-menu" title="@lang('main')"></i></li>
		<li class="nav-item">
			<a href="{{route('home')}}" class="nav-link{{ Request::is('home') ? ' active' : '' }}">
				<i class="icon-home4"></i>
				<span>
					@lang('menu.dashboard')
				</span>
			</a>
		</li>
		@if(auth()->user()->can('view-branch') or auth()->user()->can('create-branch') )
		<li class="nav-item">
			<a href="{{route('setup.branch.index')}}" class="nav-link{{ Request::is('setup/branch') ? ' active' : '' }}">
				<i class="icon-git-branch"></i>
				<span>
					@lang('menu.setup.branch')
				</span>
			</a>
		</li>
		@endif
		@if(auth()->user()->can('view-employee_department') or auth()->user()->can('create-employee_department') or auth()->user()->can('view-employee_designation') or auth()->user()->can('create-employee_designation') or auth()->user()->can('view-employee_document_type') or auth()->user()->can('create-employee_document_type') or auth()->user()->can('view-employee_group') or auth()->user()->can('create-employee_group') or auth()->user()->can('view-employee_leave_type') or auth()->user()->can('create-employee_leave_type') or auth()->user()->can('view-employee_attendance_type') or auth()->user()->can('create-employee_attendance_type') )
		<li class="nav-item nav-item-submenu{{Request::segment($index + 1) == 'employee' ? ' nav-item-expanded nav-item-open' : ''}}">
			<a href="#" class="nav-link"><i class="icon-user-tie"></i> <span>@lang('menu.setup.employee')</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="@lang('menu.setup.employee')">
				<li class="nav-item"><a href="{{route('setup.employee.general')}}" class="nav-link{{ Request::is('setup/employee/general') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.general')</span></a></li>
				@if(auth()->user()->can('view-employee_department') or auth()->user()->can('create-employee_department'))
				<li class="nav-item"><a href="{{route('setup.employee.department.index')}}" class="nav-link{{ Request::is('setup/employee/department') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_department')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_category') or auth()->user()->can('create-employee_category'))
				<li class="nav-item"><a href="{{route('setup.employee.category.index')}}" class="nav-link{{ Request::is('setup/employee/category') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.category')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_designation') or auth()->user()->can('create-employee_designation'))
				<li class="nav-item"><a href="{{route('setup.employee.designation.index')}}" class="nav-link{{ Request::is('setup/employee/designation') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_designation')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_document_type') or auth()->user()->can('create-employee_document_type'))
				<li class="nav-item"><a href="{{route('setup.employee.employee_document_type.index')}}" class="nav-link{{ Request::is('setup/employee/employee_document_type') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_document_type')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_group') or auth()->user()->can('create-employee_group'))
				<li class="nav-item"><a href="{{route('setup.employee.group.index')}}" class="nav-link{{ Request::is('setup/employee/group') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_group')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_leave_type') or auth()->user()->can('create-employee_leave_type'))
				<li class="nav-item"><a href="{{route('setup.employee.leave_type.index')}}" class="nav-link{{ Request::is('setup/employee/leave_type') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_leave_type')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_attendance_type') or auth()->user()->can('create-employee_attendance_type'))
				<li class="nav-item"><a href="{{route('setup.employee.attendance_type.index')}}" class="nav-link{{ Request::is('setup/employee/attendance_type') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_attendance_type')</span></a></li>
				@endif
				@if(auth()->user()->can('view-employee_pay_head') or auth()->user()->can('create-employee_pay_head'))
				<li class="nav-item"><a href="{{route('setup.employee.payhead.index')}}" class="nav-link{{ Request::is('setup/employee/payhead') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.employee_pay_head')</span></a></li>
				@endif
				</ul>
		</li>
		@endif
		@if(auth()->user()->can('view-bank') or auth()->user()->can('create-bank') )
		<li class="nav-item nav-item-submenu{{Request::segment($index + 1) == 'finance' ? ' nav-item-expanded nav-item-open' : ''}}">
			<a href="#" class="nav-link"><i class="icon-coins"></i> <span>@lang('menu.setup.finance')</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="@lang('menu.setup.finance')">
				@if(auth()->user()->can('view-bank') or auth()->user()->can('create-bank'))
				<li class="nav-item"><a href="{{route('setup.finance.bank.index')}}" class="nav-link{{ Request::is('setup/finance/bank') ? ' active' : '' }}"><i class="icon-user-check"></i> <span>@lang('menu.setup.finance_bank')</span></a></li>
				@endif
				</ul>
		</li>
		@endif
		@if( auth()->user()->can('view-nationality') or auth()->user()->can('create-nationality') or auth()->user()->can('view-religion') or auth()->user()->can('create-religion') or auth()->user()->can('view-caste') or auth()->user()->can('create-caste') or auth()->user()->can('view-blood_group') or auth()->user()->can('create-blood_group') or auth()->user()->can('view-category') or auth()->user()->can('create-category') )
		<li class="nav-item nav-item-submenu{{Request::segment($index + 1) == 'misc' ? ' nav-item-expanded nav-item-open' : ''}}">
			<a href="#" class="nav-link"><i class="icon-equalizer2"></i> <span>@lang('menu.setup.misc')</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="@lang('menu.setup.misc')">
				@if(auth()->user()->can('view-nationality') or auth()->user()->can('create-nationality'))
				<li class="nav-item"><a href="{{route('setup.misc.nationality.index')}}" class="nav-link{{ Request::is('setup/misc/nationality') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.nationality')</span></a></li>
				@endif
				@if(auth()->user()->can('view-religion') or auth()->user()->can('create-religion'))
				<li class="nav-item"><a href="{{route('setup.misc.religion.index')}}" class="nav-link{{ Request::is('setup/misc/religion') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.religion')</span></a></li>
				@endif
				@if(auth()->user()->can('view-blood_group') or auth()->user()->can('create-blood_group'))
				<li class="nav-item"><a href="{{route('setup.misc.blood_group.index')}}" class="nav-link{{ Request::is('setup/misc/blood_group') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.blood_group')</span></a></li>
				@endif
				@if(auth()->user()->can('view-category') or auth()->user()->can('create-category'))
				<li class="nav-item"><a href="{{route('setup.misc.category.index')}}" class="nav-link{{ Request::is('setup/misc/category') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.category')</span></a></li>
				@endif
				@if(auth()->user()->can('view-caste') or auth()->user()->can('create-caste'))
				<li class="nav-item"><a href="{{route('setup.misc.caste.index')}}" class="nav-link{{ Request::is('setup/misc/caste') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.caste')</span></a></li>
				@endif
			</ul>
		</li>
		@endif
		@if( auth()->user()->can('view-academic_session') or auth()->user()->can('create-academic_session') )
		<li class="nav-item nav-item-submenu{{Request::segment($index + 1) == 'student' ? ' nav-item-expanded nav-item-open' : ''}}">
			<a href="#" class="nav-link"><i class="icon-equalizer2"></i> <span>@lang('menu.setup.student')</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="@lang('menu.setup.student')">
				@if(auth()->user()->can('view-academic_session') or auth()->user()->can('create-academic_session'))
				<li class="nav-item"><a href="{{route('setup.student.academic-session.index')}}" class="nav-link{{ Request::is('setup/student/academic-session') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.academic_session')</span></a></li>
				@endif
		
			</ul>
		</li>
		@endif

		@else
			<!-- Main -->
		<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">@lang('main')</div> <i class="icon-menu" title="@lang('main')"></i></li>
		<li class="nav-item">
			<a href="{{route('home')}}" class="nav-link{{ Request::is('home') ? ' active' : '' }}">
				<i class="icon-home4"></i>
				<span>
					@lang('menu.dashboard')
				</span>
			</a>
		</li>
		@if( auth()->user()->can('view-employee') or auth()->user()->can('create-employee') )
		<li class="nav-item nav-item-submenu{{Request::segment($index) == 'employee' ? ' nav-item-expanded nav-item-open' : ''}}">
			<a href="#" class="nav-link"><i class="icon-equalizer2"></i> <span>@lang('menu.employee')</span></a>
			<ul class="nav nav-group-sub" data-submenu-title="@lang('menu.employee')">
				@if(auth()->user()->can('view-employee') or auth()->user()->can('create-employee'))
				<li class="nav-item"><a href="{{route('employee.index')}}" class="nav-link{{ Request::is('employee') ? ' active' : '' }}"><i class="icon-stack-plus"></i> <span>@lang('menu.setup.employee')</span></a></li>
				@endif
			</ul>
		</li>
		@endif
		<li class="nav-item ">
			<a href="{{route('setup')}}" class="nav-link"><i class="icon-cog3 spinner"></i> <span>@lang('menu.setup_kits')</span></a>
		</li>
		@endif
	</ul>
</div>