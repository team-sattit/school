@php
$route = 'employee.';
$lang = 'employee.show.';
$js = ['employee/employee_show'];
@endphp
@extends('layouts.master', ['title' => __($lang.'title'), 'modal' => true])
@section('page.header')
<div class="page-header page-header-light">
	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				<a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> @lang('trt.home')</a>
				<span class="breadcrumb-item active">@lang($lang.'title')</span>
			</div>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>
@stop
@section('content')
<!-- Stacked nav position -->
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">@lang($lang.'title')</h6>
				<div class="header-elements">
					<div class="list-icons">
						<a class="list-icons-item" data-action="collapse"></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<ul class="nav nav-pills nav-pills-bordered nav-pills-toolbar nav-justified">
					<li class="nav-item">
						<a href="#stacked-left-pill1" class="nav-link active" data-toggle="tab"><i class="icon-quill4 mr-2"></i>@lang($lang.'section1')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill2" class="nav-link" data-toggle="tab"><i class="icon-price-tags mr-2"></i>@lang($lang.'section2')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill3" class="nav-link" data-toggle="tab"><i class="icon-graduation2 mr-2"></i>@lang($lang.'section3')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill4" class="nav-link" data-toggle="tab"><i class="icon-file-text2 mr-2"></i>@lang($lang.'section4')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill5" class="nav-link" data-toggle="tab"><i class="icon-coins mr-2"></i>@lang($lang.'section5')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill6" class="nav-link" data-toggle="tab"><i class="icon-key mr-2"></i>@lang($lang.'section6')</a>
					</li>
					<li class="nav-item">
						<a href="#stacked-left-pill7" class="nav-link" data-toggle="tab"><i class="icon-key mr-2"></i>@lang($lang.'section6')</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="stacked-left-pill1">
						<div class="table-responsive">
							<table class="table table-bordered">
								<tbody>
									<tr class="text-center">
										<td colspan="2"><img src="{{ asset('storage/'.$employee->photo) }}" alt="{{ $employee->name."'s Photo" }}" height="130px" width="100px"></td>
										<td colspan="2">
											<button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#modal_remote" id="content_show" data-url="{{route($route.'edit', [$employee->uuid, 'field' => 'upload_photo'])}}"><i class="icon-file-plus mr-2"></i> @lang($lang.'update_photo')</button> <br>
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_remote" id="content_show" data-url="{{route($route.'edit', [$employee->uuid, 'field' => 'update_basic'])}}"><i class="icon-pencil7 mr-2"></i> @lang($lang.'update_basic')</button>
										</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'id')</td>
										<td class="text-right">{{ $employee->EmployeeCode }}</td>
										<td class="text-left">@lang($lang.'joining_date')</td>
										<td class="text-right">{{ $employee->joining_date->format('F d, Y') }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'total_salary')</td>
										<td class="text-right">{{ $employee->employeeSalaries ? format_number($employee->employeeSalaries->first()->total) : format_number(0) }}</td>
										<td class="text-left">@lang($lang.'branch')</td>
										<td class="text-right">{{ $employee->branch? $employee->branch->name : __($lang.'no_branch') }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'name')</td>
										<td class="text-right">{{ $employee->name }}</td>
										<td class="text-left">@lang($lang.'father_name')</td>
										<td class="text-right">{{ $employee->father_name }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'mother_name')</td>
										<td class="text-right">{{ $employee->mother_name }}</td>
										<td class="text-left">@lang($lang.'marital_status')</td>
										<td class="text-right">{{ __('list.'.$employee->marital_status)}}</td>
									</tr>
									@if($employee->marital_status == 'married')
									<tr>
										<td class="text-left">@lang($lang.'spouse_name')</td>
										<td class="text-right">{{ $employee->spouse_name }}</td>
										<td class="text-left">@lang($lang.'anniversary_date')</td>
										<td class="text-right">{{ $employee->anniversary_date }}</td>
									</tr>
									@endif
									<tr>
										<td class="text-left">@lang($lang.'gender')</td>
										<td class="text-right">{{ __('list.'.$employee->gender) }}</td>
										<td class="text-left">@lang($lang.'date_of_birth')</td>
										<td class="text-right">{{ $employee->date_of_birth->format('F d, Y') }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'nid_no')</td>
										<td class="text-right">{{ $employee->nid_no }}</td>
										<td class="text-left">@lang($lang.'birth_certificate_no')</td>
										<td class="text-right">{{ $employee->birth_certificate_no }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'mobile_no')</td>
										<td class="text-right">{{ $employee->mobile_no }}</td>
										<td class="text-left">@lang($lang.'phone_no')</td>
										<td class="text-right">{{ $employee->phone_no }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'email')</td>
										<td class="text-right">{{ $employee->email }}</td>
										<td class="text-left">@lang($lang.'alternate_email')</td>
										<td class="text-right">{{ $employee->alternate_email }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'emergency_contact_name')</td>
										<td class="text-right">{{ $employee->emergency_contact_name }}</td>
										<td class="text-left">@lang($lang.'emergency_contact')</td>
										<td class="text-right">{{ $employee->emergency_contact }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'present.title')</td>
										<td class="text-right">
											{!!  '<strong>'. __($lang.'present.house').'</strong> : '. $employee->present_house !!}, <br>
											{!!  '<strong>'. __($lang.'present.road').'</strong> : '. $employee->present_road !!}, <br>
											{!!  '<strong>'. __($lang.'present.village').'</strong> : '. $employee->present_village !!}, <br>
											{!!  '<strong>'. __($lang.'present.post').'</strong> : '. $employee->present_post !!}, <br>
											{!!  '<strong>'. __($lang.'present.upozila').'</strong> : '. $employee->present_upozila !!}, <br>
											{!!  '<strong>'. __($lang.'present.district').'</strong> : '. $employee->present_district.'- '.$employee->present_postcode !!}
										</td>
										<td class="text-left">@lang($lang.'permanent.title')</td>
										<td class="text-right">
											@if($employee->same_as_present)
											@lang($lang.'permanent.same')
											@else
											{!!  '<strong>'. __($lang.'permanent.house').'</strong> : '. $employee->permanent_house !!}, <br>
											{!!  '<strong>'. __($lang.'permanent.road').'</strong> : '. $employee->permanent_road !!}, <br>
											{!!  '<strong>'. __($lang.'permanent.village').'</strong> : '. $employee->permanent_village !!}, <br>
											{!!  '<strong>'. __($lang.'permanent.post').'</strong> : '. $employee->permanent_post !!}, <br>
											{!!  '<strong>'. __($lang.'permanent.upozila').'</strong> : '. $employee->permanent_upozila !!}, <br>
											{!!  '<strong>'. __($lang.'permanent.district').'</strong> : '. $employee->permanent_district !!}
											@endif
										</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'religion')</td>
										<td class="text-right">{{ $employee->religion ? $employee->religion->name: __($lang.'no_religion') }}</td>
										<td class="text-left">@lang($lang.'caste')</td>
										<td class="text-right">{{ $employee->caste ? $employee->caste->name: __($lang.'no_caste') }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'nationality')</td>
										<td class="text-right">{{ $employee->nationality ? $employee->nationality->name: __($lang.'no_nationality') }}</td>
										<td class="text-left">@lang($lang.'blood_group')</td>
										<td class="text-right">{{ $employee->bloodGroup ? $employee->bloodGroup->name: __($lang.'no_blood_group') }}</td>
									</tr>
									<tr>
										<td class="text-left">@lang($lang.'weight')</td>
										<td class="text-right">{{ $employee->weight }}</td>
										<td class="text-left">@lang($lang.'height')</td>
										<td class="text-right">{{ $employee->height }}</td>
									</tr>
									<tr>
										<td class="text-left" colspan="1">@lang($lang.'mark')</td>
										<td class="text-right" colspan="3">{{ $employee->mark }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill2">
						<div class="table-responsive">
							<span class="btn btn-primary" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'salary.create', ['employee' => $employee->uuid] )}}"><i class="icon-plus2 mr-2"></i> @lang($lang.'create.salary')</span>
							<table class="table content_managment_table" >
								<thead>
									<tr>
										<th>@lang($lang.'table_id')</th>
										<th>@lang($lang.'total_salary')</th>
										<th>@lang($lang.'date_effective')</th>
										<th>@lang($lang.'date_end')</th>
										<th>@lang($lang.'remarks')</th>
										<th>@lang($lang.'action')</th>
									</tr>
								</thead>
								<tbody>
									@forelse($employee->employeeSalaries as $salary)
									<tr>
										<td>{{ $loop->index +1 }}</td>
										<td>{{ format_number($salary->total) }}</td>
										<td>{{ $salary->date_effective->format('F d, Y') }}</td>
										<td>{{ $salary->date_end ?  $salary->date_end->format('F d, Y') : now()->format('F d, Y') }}</td>
										<td>{{ $salary->remarks }}</td>
										@if($salary->status == 1)
										<td>
											<img src="{{ asset('asset/ajaxloader.gif') }}" id="delete_loading_{{$salary->id}}" style="display: none;">
											<div class="list-icons" id="action_menu_{{$salary->id}}">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'salary.show', [$salary->id, 'employee' => $employee->uuid] )}}"><i class="icon-eye"></i> @lang('trt.action.view')</span>
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'salary.edit', [$salary->id, 'employee' => $employee->uuid] )}}"><i class="icon-pencil7"></i> @lang('trt.action.edit')</span>
														<span class="dropdown-item" id="delete_item" data-id="{{ $salary->id }}" data-url="{{ route($route.'salary.destroy', [$salary->id, 'employee' => $employee->uuid] )}}"><i class="icon-trash"></i> @lang('trt.action.delete')</span>
													</div>
												</div>
											</div>
										</td>
										@else
										<td></td>
										@endif
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill3">
						<div class="table-responsive">
							<table class="table content_managment_table datatable-responsive" >
								<thead>
									<tr>
										<th>@lang($lang.'table_id')</th>
										<th>@lang($lang.'exam_name')</th>
										<th>@lang($lang.'institute_name')</th>
										<th>@lang($lang.'board_or_university')</th>
										<th>@lang($lang.'group')</th>
										<th>@lang($lang.'result')</th>
										<th>@lang($lang.'passing_year')</th>
										<th>@lang($lang.'action')</th>
									</tr>
								</thead>
								<tbody>
									@forelse($employee->EmployeeQualifications as $education)
									<tr>
										<td>{{ $loop->index +1 }}</td>
										<td>{{ $education->exam_name }}</td>
										<td>{{ $education->institute_name }}</td>
										<td>{{ $education->board }}</td>
										<td>{{ $education->group }}</td>
										<td>{{ $education->result }}</td>
										<td>{{ $education->passing_year }}</td>
										<td>
											<img src="{{ asset('asset/ajaxloader.gif') }}" id="delete_loading_{{$education->id}}" style="display: none;">
											<div class="list-icons" id="action_menu_{{$education->id}}">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'qualification.show', [$education->id, 'employee' => $employee->uuid] )}}"><i class="icon-eye"></i> @lang('trt.action.view')</span>
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'qualification.edit', [$education->id, 'employee' => $employee->uuid] )}}"><i class="icon-pencil7"></i> @lang('trt.action.edit')</span>
														<span class="dropdown-item" id="delete_item" data-id="{{ $education->id }}" data-url="{{ route($route.'qualification.destroy', [$education->id, 'employee' => $employee->uuid] )}}"><i class="icon-trash"></i> @lang('trt.action.delete')</span>
													</div>
												</div>
											</div>
										</td>
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill4">
						<div class="table-responsive">
							<table class="table content_managment_table datatable-responsive" >
								<thead>
									<tr>
										<th>@lang($lang.'table_id')</th>
										<th>@lang($lang.'document_name')</th>
										<th>@lang($lang.'document_type')</th>
										<th>@lang($lang.'description')</th>
										<th max-width="10%">@lang($lang.'document')</th>
										<th>@lang($lang.'action')</th>
									</tr>
								</thead>
								<tbody>
									@forelse($employee->EmployeeDocuments as $document)
									<tr>
										<td>{{ $loop->index +1 }}</td>
										<td>{{ $document->document_name }}</td>
										<td>{{ $document->employeeDocumentType ? $document->employeeDocumentType->name : __($lang.'no_document') }}</td>
										<td>{{ $document->description }}</td>
										<td><a href="{{  asset('storage/'.$document->document) }}" download="" class="btn btn-link"> {!! document_icon(document_name($document->document)) !!}{{ document_name($document->document) }}</a></td>
										<td>
											<img src="{{ asset('asset/ajaxloader.gif') }}" id="delete_loading_{{$document->id}}" style="display: none;">
											<div class="list-icons" id="action_menu_{{$document->id}}">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'document.show', [$document->id, 'employee' => $employee->uuid] )}}"><i class="icon-eye"></i> @lang('trt.action.view')</span>
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'document.edit', [$document->id, 'employee' => $employee->uuid] )}}"><i class="icon-pencil7"></i> @lang('trt.action.edit')</span>
														<span class="dropdown-item" id="delete_item" data-id="{{ $document->id }}" data-url="{{ route($route.'document.destroy', [$document->id, 'employee' => $employee->uuid] )}}"><i class="icon-trash"></i> @lang('trt.action.delete')</span>
													</div>
												</div>
											</div>
										</td>
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill5">
						<div class="table-responsive">

							<table class="table content_managment_table datatable-responsive" >
								<thead>
									<tr>
										<th>@lang($lang.'table_id')</th>
										<th>@lang($lang.'account_name')</th>
										<th>@lang($lang.'bank')</th>
										<th>@lang($lang.'branch_name')</th>
										<th>@lang($lang.'account_no')</th>
										<th>@lang($lang.'action')</th>
									</tr>
								</thead>
								<tbody>
									@forelse($employee->EmployeeAccounts as $account)
									<tr>
										<td>{{ $loop->index +1 }}</td>
										<td>{{ $account->account_name }}</td>
										<td>{{ $account->bank ? $account->bank->name : __($lang.'no_bank') }}</td>
										<td>{{ $account->branch_name }}</td>
										<td>{{ $account->account_number }}</a></td>
										<td>
											<img src="{{ asset('asset/ajaxloader.gif') }}" id="delete_loading_{{$account->id}}" style="display: none;">
											<div class="list-icons" id="action_menu_{{$account->id}}">
												<div class="dropdown">
													<a href="#" class="list-icons-item" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'account.show', [$account->id, 'employee' => $employee->uuid] )}}"><i class="icon-eye"></i> @lang('trt.action.view')</span>
														<span class="dropdown-item" id="content_managment" data-toggle="modal" data-target="#modal_remote" data-url="{{ route($route.'account.edit', [$account->id, 'employee' => $employee->uuid] )}}"><i class="icon-pencil7"></i> @lang('trt.action.edit')</span>
														<span class="dropdown-item" id="delete_item" data-id="{{ $account->id }}" data-url="{{ route($route.'account.destroy', [$account->id, 'employee' => $employee->uuid] )}}"><i class="icon-trash"></i> @lang('trt.action.delete')</span>
													</div>
												</div>
											</div>
										</td>
									</tr>
									@empty
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill6">
						<div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <div class="col-lg-6 offset-lg-3">
                                    <span style="font-size: 14px; margin-left: 3px;">
                                        {{ Form::checkbox('login_enable', 'login_enable', Null, ['id'=> 'login_enable']) }} @lang($lang.'form.login_enable')
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="login_row" style="display: none">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    {{ Form::label('role', __($lang.'role_label') , ['class' => 'col-form-label col-lg-2 text-right required']) }}
                                    <div class="col-lg-10">
                                        {{ Form::select('role', $roles, Null, ['class' => 'form-control select', 'data-placeholder' =>  __($lang.'form.role'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('email', __($lang.'email_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::email('email', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'email'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('username', __($lang.'username_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::text('username', Null, ['class' => 'form-control', 'placeholder' =>  __($lang.'username'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('password', __($lang.'password_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' =>  __($lang.'password'), 'autocomplete' => 'off']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    {{ Form::label('password_confirmation', __($lang.'form.password_confirmation_label') , ['class' => 'col-form-label col-lg-4 text-right required']) }}
                                    <div class="col-lg-8">
                                        {{ Form::password('password_confirmation',['class' => 'form-control', 'placeholder' =>  __($lang.'password_confirmation'), 'autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					</div>
					<div class="tab-pane fade" id="stacked-left-pill7">
						Aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthet.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /stacked nav position -->
@stop
@push('admin.scripts')
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('asset/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js') }}"></script>
<!-- Theme JS files -->
@if ($js != '')
@forelse ($js as $element)
<script src="{{ asset('js/pages/'.$element.'.js') }}"></script>
@empty
@endforelse
@endif
<!-- /theme JS files -->
@endpush