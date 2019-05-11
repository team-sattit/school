<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['suspend', 'auth']], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::group(['prefix' => 'setup', 'namespace' => 'Admin\Setup'], function () {
		/*
			     * Configuration Routes Start
		*/
		Route::get('/variable', 'ConfigurationController@getConfigurationVariable');
		Route::get('/', 'ConfigurationController@index');
		Route::post('/', 'ConfigurationController@store')->name('setup.configuration.store');
		Route::post('/{type}', 'ConfigurationController@uploadImage');
		Route::delete('/{type}/remove', 'ConfigurationController@removeImage');
		Route::get('/fetch/lists', 'ConfigurationController@fetchList');
		Route::post('/wizard', 'ConfigurationController@setupWizard');
/*
Route::get('/locale', 'LocaleController@index');
Route::post('/locale', 'LocaleController@store');
Route::get('/locale/{id}', 'LocaleController@show');
Route::patch('/locale/{id}', 'LocaleController@update');
Route::delete('/locale/{id}', 'LocaleController@destroy');
Route::post('/locale/fetch', 'LocaleController@fetch');
Route::post('/locale/translate', 'LocaleController@translate');
Route::post('/locale/add-word', 'LocaleController@addWord');

Route::get('/role', 'RoleController@index');
Route::get('/role/employee/list', 'RoleController@employeeRoleList');
Route::get('/role/{id}', 'RoleController@show');
Route::post('/role', 'RoleController@store');
Route::delete('/role/{id}', 'RoleController@destroy');

Route::get('/permission', 'PermissionController@index');
Route::get('/permission/pre-requisite', 'PermissionController@preRequisite');
Route::get('/permission/{module}/pre-requisite', 'PermissionController@modulePreRequisite');
Route::get('/permission/{id}', 'PermissionController@show');
Route::post('/permission', 'PermissionController@assignPermission');
Route::post('/permission/module', 'PermissionController@assignModulePermission');*/
		/*
			     * Configuration Routes End
		*/

		Route::group(['prefix' => 'employee', 'namespace' => 'Employee'], function () {
			Route::get('/general', 'GeneralController@index')->name('setup.employee.general');

			//Department Routes
			Route::resource('department', 'DepartmentController', [
				'as' => 'setup.employee',
			]);
			Route::put('/department/{department}/status', 'DepartmentController@status')->name('setup.employee.department.status');
			Route::get('/datatable/department', 'DepartmentController@datatable')->name('setup.employee.department.datatable');

			//Designation Routes
			Route::resource('designation', 'DesignationController', [
				'as' => 'setup.employee',
			]);
			Route::put('/designation/{designation}/status', 'DesignationController@status')->name('setup.employee.designation.status');
			Route::get('datatable/designation', 'DesignationController@datatable')->name('setup.employee.designation.datatable');

			//Employee Document Type Routes
			Route::resource('employee_document_type', 'EmployeeDocumentTypeController', [
				'as' => 'setup.employee',
			]);
			Route::put('/employee_document_type/{employee_document_type}/status', 'EmployeeDocumentTypeController@status')->name('setup.employee.employee_document_type.status');
			Route::get('datatable/employee_document_type', 'EmployeeDocumentTypeController@datatable')->name('setup.employee.employee_document_type.datatable');

			//Employee Category Routes
			Route::resource('category', 'EmployeeCategoryController', [
				'as' => 'setup.employee',
			]);
			Route::put('/category/{category}/status', 'EmployeeCategoryController@status')->name('setup.employee.category.status');
			Route::get('datatable/category', 'EmployeeCategoryController@datatable')->name('setup.employee.category.datatable');

			//Employee Group Routes
			Route::resource('group', 'EmployeeGroupController', [
				'as' => 'setup.employee',
			]);
			Route::put('/group/{group}/status', 'EmployeeGroupController@status')->name('setup.employee.group.status');
			Route::get('datatable/group', 'EmployeeGroupController@datatable')->name('setup.employee.group.datatable');

			//Employee Leave Type Routes
			Route::resource('leave_type', 'LeaveTypeController', [
				'as' => 'setup.employee',
			]);
			Route::put('/leave_type/{leave_type}/status', 'LeaveTypeController@status')->name('setup.employee.leave_type.status');
			Route::get('datatable/leave_type', 'LeaveTypeController@datatable')->name('setup.employee.leave_type.datatable');

			//Employee Attendance Type Routes
			Route::resource('attendance_type', 'AttendanceTypeController', [
				'as' => 'setup.employee',
			]);
			Route::put('/attendance_type/{attendance_type}/status', 'AttendanceTypeController@status')->name('setup.employee.attendance_type.status');
			Route::get('datatable/attendance_type', 'AttendanceTypeController@datatable')->name('setup.employee.attendance_type.datatable');

			//Employee PayHead Routes
			Route::resource('payhead', 'PayHeadController', [
				'as' => 'setup.employee',
			]);
			Route::put('/payhead/{payhead}/status', 'PayHeadController@status')->name('setup.employee.payhead.status');
			Route::get('datatable/payhead', 'PayHeadController@datatable')->name('setup.employee.payhead.datatable');
		});
		Route::group(['prefix' => 'misc', 'namespace' => 'Misc'], function () {
			//Nationality Routes
			Route::resource('nationality', 'NationalityController', [
				'as' => 'setup.misc',
			]);
			Route::put('/nationality/{nationality}/status', 'NationalityController@status')->name('setup.misc.nationality.status');
			Route::get('datatable/nationality', 'NationalityController@datatable')->name('setup.misc.nationality.datatable');

			//Nationality Routes
			Route::resource('religion', 'ReligionController', [
				'as' => 'setup.misc',
			]);
			Route::put('/religion/{religion}/status', 'ReligionController@status')->name('setup.misc.religion.status');
			Route::get('datatable/religion', 'ReligionController@datatable')->name('setup.misc.religion.datatable');

			//Category Routes
			Route::resource('category', 'CategoryController', [
				'as' => 'setup.misc',
			]);
			Route::put('/category/{category}/status', 'CategoryController@status')->name('setup.misc.category.status');
			Route::get('datatable/category', 'CategoryController@datatable')->name('setup.misc.category.datatable');

			//Category Routes
			Route::resource('caste', 'CasteController', [
				'as' => 'setup.misc',
			]);
			Route::put('/caste/{caste}/status', 'CasteController@status')->name('setup.misc.caste.status');
			Route::get('datatable/caste', 'CasteController@datatable')->name('setup.misc.caste.datatable');

			//Blood Group Routes
			Route::resource('blood_group', 'BloodGroupController', [
				'as' => 'setup.misc',
			]);
			Route::put('/blood_group/{blood_group}/status', 'BloodGroupController@status')->name('setup.misc.blood_group.status');
			Route::get('datatable/blood_group', 'BloodGroupController@datatable')->name('setup.misc.blood_group.datatable');
		});

		Route::group(['prefix' => 'finance', 'namespace' => 'Finance'], function () {
			//Nationality Routes
			Route::resource('bank', 'BankController', [
				'as' => 'setup.finance',
			]);
			Route::put('/bank/{bank}/status', 'BankController@status')->name('setup.finance.bank.status');
			Route::get('datatable/bank', 'BankController@datatable')->name('setup.finance.bank.datatable');
		});


		Route::group(['prefix' => 'student', 'namespace' => 'Student'], function () {
			//Nationality Routes
			Route::resource('academic-session', 'AcademicSessionController', [
				'as' => 'setup.student',
			]);
			Route::put('/academic-session/{academic-session}/status', 'AcademicSessionController@status')->name('setup.student.academic-session.status');
			Route::get('datatable/academic-session', 'AcademicSessionController@datatable')->name('setup.student.academic-session.datatable');
		});
		//Branch Routes
		Route::resource('branch', 'BranchController', [
			'as' => 'setup',
		]);
		Route::put('/branch/{branch}/status', 'BranchController@status')->name('setup.branch.status');
		Route::get('datatable/branch', 'BranchController@datatable')->name('setup.branch.datatable');
	});
	Route::group(['prefix' => 'employee', 'namespace' => 'Admin\Employee'], function () {
		Route::resource('salary', 'SalaryController', [
			'as' => 'employee',
		]);
		Route::resource('qualification', 'EmployeeQualificationController', [
			'as' => 'employee',
		]);
		Route::resource('account', 'EmployeeAccountController', [
			'as' => 'employee',
		]);
		Route::resource('document', 'EmployeeDocumentController', [
			'as' => 'employee',
		]);
		Route::resource('designation', 'EmployeeDesignationController', [
			'as' => 'employee',
		]);
		Route::resource('terms', 'EmployeeTermController', [
			'as' => 'employee',
		]);
	});
	Route::resource('employee', 'Admin\Employee\EmployeeController');
	Route::put('/employee/{employee}/status', 'Admin\Employee\EmployeeController@status')->name('employee.status');
	Route::get('datatable/employee', 'Admin\Employee\EmployeeController@datatable')->name('employee.datatable');

	Route::view('setup', 'admin.setup.index')->name('setup');

});