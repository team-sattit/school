<?php
namespace App\Repositories\Employee;

use App\Model\Employee\Employee;
use App\Model\Employee\EmployeeAccount;
use App\Model\Employee\EmployeeDesignation;
use App\Model\Employee\EmployeeDocument;
use App\Model\Employee\EmployeeQualification;
use App\Model\Employee\EmployeeSalary;
use App\Model\Employee\EmployeeTerm;
use App\Repositories\Setup\BranchRepository;
use App\Repositories\Setup\Employee\DepartmentRepository;
use App\Repositories\Setup\Employee\DesignationRepository;
use App\Repositories\Setup\Employee\EmployeeDocumentTypeRepository;
use App\Repositories\Setup\Employee\EmployeeGroupRepository;
use App\Repositories\Setup\Finance\BankRepository;
use App\Repositories\Setup\Misc\BloodGroupRepository;
use App\Repositories\Setup\Misc\CasteRepository;
use App\Repositories\Setup\Misc\CategoryRepository;
use App\Repositories\Setup\Misc\NationalityRepository;
use App\Repositories\Setup\Misc\ReligionRepository;
use App\Repositories\Setup\RoleRepository;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class EmployeeRepository {
	protected $employee;
	protected $designation;
	protected $department;
	protected $employee_term;
	protected $employee_designation;
	protected $caste;
	protected $category;
	protected $religion;
	protected $blood_group;
	protected $user;
	protected $employee_group;
	protected $role;
	protected $branch;
	protected $nationality;
	protected $document_type;
	protected $document;
	protected $bank;
	protected $qualification;
	protected $account;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Employee $employee,
		DesignationRepository $designation,
		DepartmentRepository $department,
		EmployeeTerm $employee_term,
		EmployeeDesignation $employee_designation,
		CasteRepository $caste,
		CategoryRepository $category,
		ReligionRepository $religion,
		BloodGroupRepository $blood_group,
		User $user,
		EmployeeGroupRepository $employee_group,
		RoleRepository $role,
		BranchRepository $branch,
		NationalityRepository $nationality,
		EmployeeDocumentTypeRepository $document_type,
		EmployeeDocument $document,
		BankRepository $bank,
		EmployeeSalary $employee_salary,
		EmployeeQualification $qualification,
		EmployeeAccount $account
	) {
		$this->employee = $employee;
		$this->designation = $designation;
		$this->department = $department;
		$this->employee_term = $employee_term;
		$this->employee_designation = $employee_designation;
		$this->caste = $caste;
		$this->category = $category;
		$this->religion = $religion;
		$this->blood_group = $blood_group;
		$this->user = $user;
		$this->employee_group = $employee_group;
		$this->role = $role;
		$this->branch = $branch;
		$this->nationality = $nationality;
		$this->document_type = $document_type;
		$this->document = $document;
		$this->bank = $bank;
		$this->employee_salary = $employee_salary;
		$this->qualification = $qualification;
		$this->account = $account;
	}

	public function model() {
		return Employee::class;
	}
	public function route() {
		return 'employee.';
	}
	private function permission() {
		return '-employee';
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addColumn('code', function ($model) {
				return $model->EmployeeCode;
			})->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong> ';
		})->editColumn('date_of_birth', function ($model) {
			return $model->date_of_birth->format('M d, Y');
		})->editColumn('joining_date', function ($model) {
			return $model->joining_date->format('M d, Y');
		})->addColumn('department', function ($model) {
			$designation = getEmployeeDesignation($model);
			if (!$designation) {
				return 'No Department';
			}
			return $designation->department->name;
		})->addColumn('designation', function ($model) {
			$designation = getEmployeeDesignationName($model);
			if (!$designation) {
				return 'No Designation';
			}
			return $designation;
		})->addColumn('status', function ($model) {
			return view('admin.employee.status', compact('model'));
		})->addColumn('action', function ($model) {
			$route = $this->route();
			$permission = $this->permission();
			return view('admin.employee.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description'])->make(true);
	}

	/**
	 * Get employee query
	 *
	 * @return Employee query
	 */
	public function getQuery() {
		return $this->employee;
	}

	/**
	 * Count employee
	 *
	 * @return integer
	 */
	public function count() {
		return $this->employee->count();
	}

	/**
	 * List all employees by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->employee->get()->pluck('id')->all();
	}

	/**
	 * Get all employees
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->employee->get();
	}

	/**
	 * List all employees by name & id for select option
	 *
	 * @return array
	 */
	public function selectAll() {
		$employees = $this->employee->all();

		$data = array();
		foreach ($employees as $employee) {
			$data[] = array(
				'name' => $employee->name . ' (' . $employee->contact_number . ')',
				'id' => $employee->id,
			);
		}

		return $data;
	}

	/**
	 * Find employee with given id.
	 *
	 * @param integer $id
	 * @return Employee
	 */
	public function find($id) {
		return $this->employee->info()->filterById($id)->first();
	}

	/**
	 * Find employee with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Employee
	 */
	public function findOrFail($id, $field = 'message') {
		$employee = $this->employee->info()->filterById($id)->first();

		if (!$employee) {
			throw ValidationException::withMessages([$field => trans('employee.not_find')]);
		}

		return $employee;
	}

	/**
	 * Find employee with given uuid or throw an error.
	 *
	 * @param string $uuid
	 * @return Employee
	 */
	public function findByUuidOrFail($uuid, $field = 'message') {
		$employee = $this->employee->info()->filterByUuid($uuid)->first();

		if (!$employee) {
			throw ValidationException::withMessages([$field => trans('employee.not_find')]);
		}

		return $employee;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Employee
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'first_name');
		$order = gv($params, 'order', 'asc');
		$first_name = gv($params, 'first_name');
		$middle_name = gv($params, 'middle_name');
		$last_name = gv($params, 'last_name');
		$father_name = gv($params, 'father_name');
		$status = gv($params, 'status');
		$designation_id = gv($params, 'designation_id');
		$department_id = gv($params, 'department_id');
		$employee_category_id = gv($params, 'employee_category_id');
		$employee_group_id = gv($params, 'employee_group_id');
		$self = gv($params, 'self', 0);
		$date = gv($params, 'date', date('Y-m-d'));

		$this->employee->whereNull('prefix')->update(['prefix' => config('config.employee_code_prefix')]);

		$designation_id = is_array($designation_id) ? $designation_id : ($designation_id ? explode(',', $designation_id) : []);
		$department_id = is_array($department_id) ? $department_id : ($department_id ? explode(',', $department_id) : []);
		$employee_group_id = is_array($employee_group_id) ? $employee_group_id : ($employee_group_id ? explode(',', $employee_group_id) : []);
		$employee_category_id = is_array($employee_category_id) ? $employee_category_id : ($employee_category_id ? explode(',', $employee_category_id) : []);

		$system_admins = $this->employee->whereHas('user', function ($q) {
			$q->role(config('system.default_role.admin'));
		})->get()->pluck('id')->all();

		$query = $this->employee->whereNotNull('id');

		if (gbv($params, 'summary')) {
			$query->summary();
		} else {
			$query->info();
		}

		$employee_ids = $this->getAccessibleEmployeeId();

		if ($self) {
			array_push($employee_ids, \Auth::user()->Employee->id);
			$employee_ids = array_unique($employee_ids);
		}

		$query->whereNotIn('id', $system_admins)->whereIn('id', $employee_ids)->filterByFirstName($first_name)->filterByMiddleName($middle_name)->filterByLastName($last_name)->filterByFatherName($father_name);

		if (count($designation_id)) {
			$query->whereHas('employeeDesignations', function ($q) use ($designation_id, $date) {
				$q->where('date_effective', '<=', $date)->where(function ($q1) use ($date) {
					$q1->where('date_end', '=', null)->orWhere(function ($q2) use ($date) {
						$q2->where('date_end', '!=', null)->where('date_end', '>=', $date);
					});
				})->whereIn('designation_id', $designation_id);
			});
		}

		if (count($employee_category_id)) {
			$query->whereHas('employeeDesignations', function ($q) use ($employee_category_id, $date) {
				$q->where('date_effective', '<=', $date)->where(function ($q1) use ($date) {
					$q1->where('date_end', '=', null)->orWhere(function ($q2) use ($date) {
						$q2->where('date_end', '!=', null)->where('date_end', '>=', $date);
					});
				})->whereHas('designation', function ($q) use ($employee_category_id) {
					$q->whereHas('employeeCategory', function ($q1) use ($employee_category_id) {
						$q1->whereIn('employee_category_id', $employee_category_id);
					});
				});
			});
		}

		if (count($department_id)) {
			$query->whereHas('employeeDesignations', function ($q) use ($department_id, $date) {
				$q->where('date_effective', '<=', $date)->where(function ($q1) use ($date) {
					$q1->where('date_end', '=', null)->orWhere(function ($q2) use ($date) {
						$q2->where('date_end', '!=', null)->where('date_end', '>=', $date);
					});
				})->whereIn('department_id', $department_id);
			});
		}

		if (count($employee_group_id)) {
			$query->whereHas('employeeGroups', function ($q) use ($employee_group_id) {
				$q->whereIn('employee_group_id', $employee_group_id);
			});
		}

		if ($status == 'active') {
			$query->whereHas('employeeTerms', function ($q) use ($date) {
				$q->where(function ($q1) use ($date) {
					$q1->whereNull('date_of_leaving')->where('joining_date', '<=', $date);
				})->orWhere(function ($q2) use ($date) {
					$q2->whereNotNull('date_of_leaving')->where('joining_date', '<=', $date)->where('date_of_leaving', '>=', $date);
				});
			});
		} elseif ($status == 'inactive') {
			$query->whereHas('employeeTerms', function ($q) use ($date) {
				$q->Where(function ($q1) use ($date) {
					$q1->whereNotNull('date_of_leaving')->where('date_of_leaving', '<', $date);
				});
			});
		}

		return $query->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all employees using given params.
	 *
	 * @param array $params
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate($params) {
		$page_length = gv($params, 'page_length', config('config.page_length'));

		return $this->getData($params)->paginate($page_length);
	}

	/**
	 * Get all filtered data for printing
	 *
	 * @param array $params
	 * @return Employee
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Get employee filters.
	 *
	 * @return Array
	 */
	public function getFilters() {
		$departments = $this->department->selectAll();
		$designations = $this->designation->getDesignationOption();
		$employee_groups = $this->employee_group->selectAll();

		return compact('departments', 'designations', 'employee_groups');
	}

	/**
	 * Get employee pre requisite.
	 *
	 * @return Array
	 */
	public function getPreRequisite() {
		$departments = $this->department->listAll();
		$designations = $this->designation->selectAllExludingDefault();
		$branches = $this->branch->listAll();
		$document_types = $this->document_type->listAll();
		$banks = $this->bank->listAll();
		$roles = $this->role->employeeRoleList();
		$list = getVar('list');
		$genders = generateTranslatedSelectOption(isset($list['gender']) ? $list['gender'] : []);
		$codes = $this->employee->groupBy('prefix')->get(['prefix', \DB::raw('MAX(code) as code')]);

		return compact('departments', 'genders', 'designations', 'codes', 'branches', 'document_types', 'banks', 'roles');
	}

	/**
	 * Get employee basic pre requisite.
	 *
	 * @return Array
	 */
	public function getBasicPreRequisite() {
		$castes = $this->caste->listAll();
		$categories = $this->category->listAll();
		$religions = $this->religion->listAll();
		$nationalities = $this->nationality->listAll();
		$blood_groups = $this->blood_group->listAll();
		$list = getVar('list');
		$genders = generateTranslatedSelectOption(isset($list['gender']) ? $list['gender'] : []);
		$marital_statuses = generateTranslatedSelectOption(isset($list['marital_status']) ? $list['marital_status'] : []);

		return compact('castes', 'categories', 'religions', 'blood_groups', 'genders', 'marital_statuses', 'nationalities');
	}

	/**
	 * Create a new employee.
	 *
	 * @param array $params
	 * @return Employee
	 */
	public function create($params) {
		$this->validateInput($params);

		$employee = $this->employee->forceCreate($this->formatParams($params));

		$employee_term = $this->createEmployeeTerm($employee, $params);

		$this->createEmployeeDesignation($employee, $params, $employee_term->id);

		$this->createEmployeeSalary($employee, $params);

		$this->createEmployeeQualification($employee, $params);

		$this->createEmployeeAccounts($employee, $params);

		$this->createEmployeeDocuments($employee, $params);

		if (gbv($params, 'login_enable')) {
			$this->updateUserLogin($employee, $params);
		}

		return $employee;
	}

	/**
	 * Validate all input.
	 *
	 * @param array $params
	 */
	public function validateInput($params = array()) {
		$joining_date = gv($params, 'joining_date');
		$gender = gv($params, 'gender');
		$department_id = gv($params, 'department_id');
		$designation_id = gv($params, 'designation_id');

		$brance_id = gv($params, 'brance_id');

		if ($brance_id) {
			$this->brance->findOrFail($brance_id, 'brance_id');
		}

		if ($department_id) {
			$this->department->findOrFail($department_id, 'department_id');
		}

		$designation = $this->designation->findOrFail($designation_id, 'designation_id');

		if ($designation->name == config('config.system_admin_designation')) {
			throw ValidationException::withMessages(['designation_id' => trans('employee.not_find_designation')]);
		}

		$list = getVar('list');
		$genders = isset($list['gender']) ? $list['gender'] : [];
		if (!in_array($gender, $genders)) {
			throw ValidationException::withMessages(['gender' => trans('employee.not_find_gender')]);
		}

		if (request('caste_id')) {
			$this->caste->findOrFail(request('caste_id'), 'caste_id');
		}

		if (request('category_id')) {
			$this->category->findOrFail(request('category_id'), 'category_id');
		}

		if (request('religion_id')) {
			$this->religion->findOrFail(request('religion_id'), 'religion_id');
		}

		if (request('blood_group_id')) {
			$this->blood_group->findOrFail(request('blood_group_id'), 'blood_group_id');
		}
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param string $type
	 * @return array
	 */
	private function formatParams($params) {
		$code = ltrim(gv($params, 'code'), '0');

		if (!isInteger($code)) {
			throw ValidationException::withMessages(['code' => trans('validation.integer', ['attribute' => trans('employee.form.code')])]);
		}

		$prefix = gv($params, 'prefix');

		if ($this->employee->filterByCode($code)->filterByPrefix($prefix)->count()) {
			throw ValidationException::withMessages(['code' => trans('employee.code_exists')]);
		}
		$marital_status = gv($params, 'marital_status');
		if ($marital_status == 'married') {
			$anniversary_date = gv($params, 'anniversary_date');
			$spouse_name = gv($params, 'spouse_name');
		} else {
			$anniversary_date = Null;
			$spouse_name = Null;
		}
		$same_as_present_address = gbv($params, 'same_as_present');
		$name = gv($params, 'name');
		$photo = gv($params, 'photo');
		$upload_photo = upload_file($photo, $name, 'employee/photo');

		$formatted = [
			'uuid' => Str::uuid(),
			'branch_id' => gv($params, 'branch_id'),
			'prefix' => gv($params, 'prefix'),
			'code' => gv($params, 'code'),
			'name' => gv($params, 'name'),
			'joining_date' => gv($params, 'joining_date'),
			'photo' => $upload_photo,
			'date_of_birth' => gv($params, 'date_of_birth'),
			'anniversary_date' => $anniversary_date,
			'gender' => gv($params, 'gender'),
			'marital_status' => $marital_status,
			'mobile_no' => gv($params, 'mobile_no'),
			'phone_no' => gv($params, 'phone_no'),
			'email' => gv($params, 'user_email'),
			'alternate_email' => gv($params, 'alternate_email'),
			'nationality_id' => gv($params, 'nationality_id'),
			'blood_group_id' => gv($params, 'blood_group_id'),
			'religion_id' => gv($params, 'religion_id'),
			'category_id' => gv($params, 'category_id'),
			'caste_id' => gv($params, 'caste_id'),
			'nid_no' => gv($params, 'nid_no'),
			'birth_certificate_no' => gv($params, 'birth_certificate_no'),
			'father_name' => gv($params, 'father_name'),
			'mother_name' => gv($params, 'mother_name'),
			'spouse_name' => $spouse_name,
			'emergency_contact_name' => gv($params, 'emergency_contact_name'),
			'emergency_contact' => gv($params, 'emergency_contact'),
			'present_house' => gv($params, 'present_house'),
			'present_road' => gv($params, 'present_road'),
			'present_village' => gv($params, 'present_village'),
			'present_post' => gv($params, 'present_post'),
			'present_upozila' => gv($params, 'present_upozila'),
			'present_district' => gv($params, 'present_district'),
			'present_postcode' => gv($params, 'present_postcode'),
			'same_as_present' => gbv($params, 'same_as_present'),
			'height' => gv($params, 'height'),
			'weight' => gv($params, 'weight'),
			'mark' => gv($params, 'mark'),
			'permanent_house' => !$same_as_present_address ? gv($params, 'permanent_house') : '',
			'permanent_road' => !$same_as_present_address ? gv($params, 'permanent_road') : '',
			'permanent_village' => !$same_as_present_address ? gv($params, 'permanent_village') : '',
			'permanent_post' => !$same_as_present_address ? gv($params, 'permanent_post') : '',
			'permanent_upozila' => !$same_as_present_address ? gv($params, 'permanent_upozila') : '',
			'permanent_district' => !$same_as_present_address ? gv($params, 'permanent_district') : '',
			'permanent_postcode' => !$same_as_present_address ? gv($params, 'permanent_postcode') : '',
		];

		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Create new employee designation
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeDesignation(Employee $employee, $params = array(), $employee_term_id) {
		$this->employee_designation->forceCreate([
			'employee_id' => $employee->id,
			'department_id' => gv($params, 'department_id'),
			'designation_id' => gv($params, 'designation_id'),
			'date_effective' => gv($params, 'joining_date'),
			'upload_token' => Str::uuid(),
			'employee_term_id' => $employee_term_id,
			'options' => [],
		]);
	}

	/**
	 * Create new employee salary
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeSalary(Employee $employee, $params = array()) {
		$this->employee_salary->forceCreate([
			'employee_id' => $employee->id,
			'basic_salary' => gv($params, 'basic_salary', 0),
			'house_rent' => gv($params, 'house_rent', 0),
			'medical_allowance' => gv($params, 'medical_allowance', 0),
			'transport_allowance' => gv($params, 'transport_allowance', 0),
			'insurance' => gv($params, 'insurance', 0),
			'commission' => gv($params, 'commission', 0),
			'extra' => gv($params, 'extra', 0),
			'overtime' => gv($params, 'overtime'),
			'total' => gv($params, 'basic_salary', 0) + gv($params, 'house_rent', 0) + gv($params, 'medical_allowance', 0) + gv($params, 'transport_allowance', 0) + gv($params, 'insurance', 0) + gv($params, 'commission', 0) + gv($params, 'extra', 0),
			'date_effective' => gv($params, 'joining_date'),
			'status' => 1,
			'options' => [],
		]);
	}

	/**
	 * Create new employee Qualification
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeQualification(Employee $employee, $params = array()) {
		$academic_row = gv($params, 'academic_total_row');
		if ($academic_row > 0) {
			for ($i = 0; $i < $academic_row; $i++) {
				if (gv(gv($params, 'exam_name'), $i)) {
					$this->qualification->forceCreate([
						'employee_id' => $employee->id,
						'institute_name' => gv(gv($params, 'institute_name'), $i),
						'exam_name' => gv(gv($params, 'exam_name'), $i),
						'board' => gv(gv($params, 'board_or_university'), $i),
						'group' => gv(gv($params, 'group'), $i),
						'result' => gv(gv($params, 'result'), $i),
						'passing_year' => gv(gv($params, 'passing_year'), $i),
						'upload_token' => Str::uuid(),
						'options' => [],
					]);
				}
			}
		}
	}

	/**
	 * Create new employee Accounts
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeAccounts(Employee $employee, $params = array()) {
		$row = gv($params, 'account_total_row');
		if ($row > 0) {
			for ($i = 0; $i < $row; $i++) {
				if (gv(gv($params, 'account_name'), $i)) {
					$this->account->forceCreate([
						'employee_id' => $employee->id,
						'account_name' => gv(gv($params, 'account_name'), $i),
						'account_number' => gv(gv($params, 'account_no'), $i),
						'bank_id' => gv(gv($params, 'bank_id'), $i),
						'branch_name' => gv(gv($params, 'branch_name'), $i),
						'options' => [],
					]);
				}
			}
		}
	}

	/**
	 * Create new employee Documents
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeDocuments(Employee $employee, $params = array()) {
		$row = gv($params, 'document_total_row');
		if ($row > 0) {
			for ($i = 0; $i < $row; $i++) {
				if (gv(gv($params, 'document'), $i)) {
					$document_name = gv(gv($params, 'document_name'), $i);
					$employee_document_type_id = gv(gv($params, 'employee_document_type_id'), $i);
					$document_full_name = $document_name . '-' . $employee_document_type_id;
					$doucment = gv(gv($params, 'document'), $i);
					$upload_document = upload_file($doucment, $document_full_name, 'employee/document');
					$this->document->forceCreate([
						'employee_id' => $employee->id,
						'document_name' => gv(gv($params, 'document_name'), $i),
						'employee_document_type_id' => gv(gv($params, 'employee_document_type_id'), $i),
						'document' => $upload_document,
						'description' => gv(gv($params, 'description'), $i),
						'options' => [],
					]);
				}
			}
		}
	}

	/**
	 * Create new employee term
	 *
	 * @param Employee $employee
	 * @param array $params
	 */
	public function createEmployeeTerm(Employee $employee, $params = array()) {
		return $this->employee_term->forceCreate([
			'employee_id' => $employee->id,
			'joining_date' => gv($params, 'joining_date'),
			'upload_token' => Str::uuid(),
			'options' => [],
		]);
	}

	/**
	 * Get employee query who are accessible for given user
	 *
	 * @param User $user
	 * @param boolean $self (Pass 1 to include given user id)
	 * @return Query
	 */
	public function getAccessibleEmployee($user = null, $self = 0) {
		$user = ($user) ?: \Auth::user();

		$self = $user->hasRole(config('system.default_role.admin')) ? 0 : 0;

		$system_admins = $this->employee->whereHas('user', function ($q) {
			$q->role(config('system.default_role.admin'));
		})->get()->pluck('id')->all();

		$query = $this->employee->whereNotIn('id', $system_admins);

		if ($user->hasRole(config('system.default_role.admin'))) {
			return $query;
		}

		$subordinate_ids = $this->designation->getSubordinateId($user);

		$employees = $this->employee->with('employeeDesignations')->get();

		$accessible_employees = array();
		foreach ($employees as $employee) {
			if (in_array(getEmployeeDesignationId($employee), $subordinate_ids)) {
				$accessible_employees[] = $employee->id;
			}
		}

		if ($self) {
			$accessible_employees[] = $user->Employee->id;
		}

		return $query->whereIn('id', $accessible_employees);
	}

	/**
	 * Get all employee's id who are accessible for given user id
	 *
	 * @param User $user
	 * @param boolean $self (Pass 1 to include given user id)
	 * @return array
	 */
	public function getAccessibleEmployeeId($user = null, $self = 0) {
		return $this->getAccessibleEmployee($user, $self)->get()->pluck('id')->all();
	}

	/**
	 * Get all employee's list who are accessible for given user id
	 *
	 * @param User $user
	 * @param boolean $self (Pass 1 to include given user id)
	 * @return array
	 */
	public function getAccessibleEmployeeList($user = null, $self = 0) {
		return generateSelectOption($this->getAccessibleEmployee($user, $self)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get()->pluck('name_with_code', 'id')->all());
	}

	/**
	 * Check whether employee is accessible for authenticated user
	 *
	 * @param Employee $employee
	 * @return boolean
	 */
	public function isAccessible($employee, $self = 0) {
		$auth_user = \Auth::user();
		if ($auth_user->hasRole(config('trt.default_role.admin'))) {
			return true;
		}

		if ($self && $employee->id == $auth_user->Employee->id) {
			return true;
		}

		if (!in_array($employee->id, $this->getAccessibleEmployeeId())) {
			throw ValidationException::withMessages(['message' => trans('employee.not_accessible')]);
		}
	}

	/**
	 * Check whether user is accessible for authenticated user
	 *
	 * @param Employee $employee
	 * @return boolean
	 */
	public function userAccessible($employee, $self = 0) {
		$auth_user = \Auth::user();
		if ($self && $employee->id == $auth_user->Employee->id) {
			return true;
		}

		return in_array($employee->id, $this->getAccessibleEmployeeId()) ? true : false;
	}

	/**
	 * Update given employee.
	 *
	 * @param Employee $employee
	 * @param array $params
	 *
	 * @return Employee
	 */
	public function update(Employee $employee, $params) {
		$type = gv($params, 'field');

		if ($type == 'upload_photo') {
			return $employee->forceFill($this->updatePhoto($employee, $params))->save();
		} elseif ($type == 'basic_info') {
			return $employee->forceFill($this->updateBasic($employee, $params))->save();
		} else {
			return $employee;
		}
	}

	/**
	 * Prepare basic params for inserting into database.
	 *
	 * @param Employee $employee
	 * @param array $params
	 * @return array
	 */
	private function updatePhoto(Employee $employee, $params) {
		remove_image($employee->photo);
		$name = $employee->name;
		$photo = gv($params, 'photo');
		$upload_photo = upload_file($photo, $name, 'employee/photo');
		return [
			'photo' => $upload_photo,
		];
	}

	/**
	 * Prepare basic params for inserting into database.
	 *
	 * @param Employee $employee
	 * @param array $params
	 * @return array
	 */
	private function updateBasic(Employee $employee, $params) {
		$gender = gv($params, 'gender');

		$list = getVar('list');
		$genders = isset($list['gender']) ? $list['gender'] : [];
		if (!in_array($gender, $genders)) {
			throw ValidationException::withMessages(['gender' => trans('employee.not_find_gender')]);
		}

		if (request('caste_id')) {
			$this->caste->findOrFail(request('caste_id'), 'caste_id');
		}

		if (request('religion_id')) {
			$this->religion->findOrFail(request('religion_id'), 'religion_id');
		}

		if (request('blood_group_id')) {
			$this->blood_group->findOrFail(request('blood_group_id'), 'blood_group_id');
		}

		$marital_status = gv($params, 'marital_status');
		if ($marital_status == 'married') {
			$anniversary_date = gv($params, 'anniversary_date');
			$spouse_name = gv($params, 'spouse_name');
		} else {
			$anniversary_date = Null;
			$spouse_name = Null;
		}
		$same_as_present_address = gbv($params, 'same_as_present');

		return [
			'name' => gv($params, 'name'),
			'date_of_birth' => gv($params, 'date_of_birth'),
			'anniversary_date' => $anniversary_date,
			'gender' => gv($params, 'gender'),
			'marital_status' => $marital_status,
			'mobile_no' => gv($params, 'mobile_no'),
			'phone_no' => gv($params, 'phone_no'),
			'email' => gv($params, 'user_email'),
			'alternate_email' => gv($params, 'alternate_email'),
			'nationality_id' => gv($params, 'nationality_id'),
			'blood_group_id' => gv($params, 'blood_group_id'),
			'religion_id' => gv($params, 'religion_id'),
			'category_id' => gv($params, 'category_id'),
			'caste_id' => gv($params, 'caste_id'),
			'nid_no' => gv($params, 'nid_no'),
			'birth_certificate_no' => gv($params, 'birth_certificate_no'),
			'father_name' => gv($params, 'father_name'),
			'mother_name' => gv($params, 'mother_name'),
			'spouse_name' => $spouse_name,
			'emergency_contact_name' => gv($params, 'emergency_contact_name'),
			'emergency_contact' => gv($params, 'emergency_contact'),
			'present_house' => gv($params, 'present_house'),
			'present_road' => gv($params, 'present_road'),
			'present_village' => gv($params, 'present_village'),
			'present_post' => gv($params, 'present_post'),
			'present_upozila' => gv($params, 'present_upozila'),
			'present_district' => gv($params, 'present_district'),
			'present_postcode' => gv($params, 'present_postcode'),
			'same_as_present' => gbv($params, 'same_as_present'),
			'height' => gv($params, 'height'),
			'weight' => gv($params, 'weight'),
			'mark' => gv($params, 'mark'),
			'permanent_house' => !$same_as_present_address ? gv($params, 'permanent_house') : '',
			'permanent_road' => !$same_as_present_address ? gv($params, 'permanent_road') : '',
			'permanent_village' => !$same_as_present_address ? gv($params, 'permanent_village') : '',
			'permanent_post' => !$same_as_present_address ? gv($params, 'permanent_post') : '',
			'permanent_upozila' => !$same_as_present_address ? gv($params, 'permanent_upozila') : '',
			'permanent_district' => !$same_as_present_address ? gv($params, 'permanent_district') : '',
			'permanent_postcode' => !$same_as_present_address ? gv($params, 'permanent_postcode') : '',
		];

	}

	/**
	 * Prepare basic params for inserting into database.
	 *
	 * @param Employee $employee
	 * @param array $params
	 * @return array
	 */
	private function updateContact(Employee $employee, $params) {
		$same_as_present_address = gbv($params, 'same_as_present_address');

		return [
			'contact_number' => gv($params, 'contact_number'),
			'alternate_contact_number' => gv($params, 'alternate_contact_number'),
			'email' => gv($params, 'email'),
			'alternate_email' => gv($params, 'alternate_email'),
			'emergency_contact_number' => gv($params, 'emergency_contact_number'),
			'emergency_contact_name' => gv($params, 'emergency_contact_name'),
			'present_address_line_1' => gv($params, 'present_address_line_1'),
			'present_address_line_2' => gv($params, 'present_address_line_2'),
			'present_city' => gv($params, 'present_city'),
			'present_state' => gv($params, 'present_state'),
			'present_zipcode' => gv($params, 'present_zipcode'),
			'present_country' => gv($params, 'present_country'),
			'same_as_present_address' => $same_as_present_address,
			'permanent_address_line_1' => !$same_as_present_address ? gv($params, 'permanent_address_line_1') : '',
			'permanent_address_line_2' => !$same_as_present_address ? gv($params, 'permanent_address_line_2') : '',
			'permanent_city' => !$same_as_present_address ? gv($params, 'permanent_city') : '',
			'permanent_state' => !$same_as_present_address ? gv($params, 'permanent_state') : '',
			'permanent_zipcode' => !$same_as_present_address ? gv($params, 'permanent_zipcode') : '',
			'permanent_country' => !$same_as_present_address ? gv($params, 'permanent_country') : '',
		];
	}

	/**
	 * Update user login
	 *
	 * @param Employee $employee
	 * @param array $params
	 * @return Employee
	 */
	public function updateUserLogin(Employee $employee, $params) {
		$enable_employee_login = gbv($params, 'login_enable');
		$change_employee_password = gbv($params, 'change_employee_password');
		$employee_email = gv($params, 'email');
		$employee_username = gv($params, 'username');
		$employee_password = gv($params, 'password');
		$role = gv($params, 'role');

		$employee_user = $employee->User;

		if ($enable_employee_login && !$employee_user) {
			if (!$employee_password) {
				throw ValidationException::withMessages(['employee_password' => trans('validation.required', ['attribute' => trans('employee.employee_password')])]);
			}

			if (!$employee_username && !$employee_email) {
				throw ValidationException::withMessages(['message' => trans('auth.username_or_email_required')]);
			}

			if ($employee_email && $this->user->whereEmail($employee_email)->count()) {
				throw ValidationException::withMessages(['message' => trans('auth.email_already_exists')]);
			}

			if ($employee_username && $this->user->whereUsername($employee_username)->count()) {
				throw ValidationException::withMessages(['message' => trans('auth.username_already_exists')]);
			}

			$employee_user = $this->user->forceCreate([
				'email' => $employee_email,
				'name' => gv($params, 'name'),
				'username' => $employee_username,
				'password' => bcrypt($employee_password),
				'status' => 1,
				'uuid' => Str::uuid(),
				'activation_token' => Str::uuid(),
			]);

			$employee->user_id = $employee_user->id;
			$employee->save();
		}

		if ($enable_employee_login) {
			$employee_user->syncRoles([$role]);
			if (!$change_employee_password) {
				$employee_user->status = 1;
				$employee_user->email = $employee_email;
				$employee_user->username = $employee_username;
				$employee_user->save();
			} else {
				$employee_user->password = bcrypt($employee_password);
				$employee_user->save();
			}
		} else {
			$employee_user->status = 2;
			$employee_user->save();
		}

		return $employee;
	}

	/**
	 * Search employee by name
	 *
	 * @param array $params
	 * @return Employee
	 */
	public function searchByName($params) {
		$name = gv($params, 'name');
		$array_of_name = explode(' ', $name);
		$first_name = gv($array_of_name, 0);
		$middle_name = (str_word_count($name) > 2) ? gv($array_of_name, 1) : '';
		$last_name = gv($array_of_name, (str_word_count($name) > 2) ? 2 : 1);

		$page_length = gv($params, 'page_length', config('config.page_length'));

		return $this->employee->with('employeeTerms', 'employeeDesignations', 'employeeDesignations.designation', 'employeeDesignations.designation.employeeCategory')->filterByFirstName($first_name)->filterByMiddleName($middle_name)->filterByLastName($last_name)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->paginate($page_length);
	}

	/**
	 * Search employee
	 *
	 * @param array $params
	 * @return Employee
	 */
	public function search($q) {
		if (!\Auth::user()->can('list-employee')) {
			return [];
		}

		$system_admins = $this->employee->whereHas('user', function ($q) {
			$q->role(config('system.default_role.admin'));
		})->get()->pluck('id')->all();

		return $this->employee->select('id', 'uuid', 'first_name', 'middle_name', 'last_name', 'code', 'contact_number')
			->with('employeeTerms:id,employee_id,joining_date,date_of_leaving', 'employeeDesignations:id,employee_id,designation_id,date_effective,date_end', 'employeeDesignations.designation:id,name,employee_category_id', 'employeeDesignations.designation.employeeCategory:id,name')
			->whereNotIn('id', $system_admins)
			->whereIn('id', $this->getAccessibleEmployeeId())
			->where(function ($q1) use ($q) {
				$q1->where(\DB::raw('concat_ws(first_name," ",middle_name," ",last_name)'), 'LIKE', '%' . $q . '%')
					->orWhere(\DB::raw('concat_ws(prefix," ",LPAD(code, ' . config('config.employee_code_digit') . ', 0))'), 'LIKE', '%' . $q . '%');;
			})->take(10)->get();
	}

	/**
	 * Validate employee
	 *
	 * @param integer $employee_id
	 * @return Employee
	 */
	public function validateEmployeeOrFail($employee_id) {
		$employee = $this->employee->with(['employeeTerms' => function ($q) {
			$q->whereNull('date_of_leaving')->orderBy('joining_date', 'desc');
		}])->filterById($employee_id)->whereHas('employeeTerms', function ($q) {
			$q->whereNull('date_of_leaving');
		})->first();

		if (!$employee) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_employee')]);
		}

		return $employee;
	}

	/**
	 * Validate employee on a date
	 *
	 * @param integer $employee_id
	 * @param date $date
	 * @return Employee
	 */
	public function validateEmployeeWithDateOrFail($employee_id, $date) {
		$employee = $this->employee->with(['employeeTerms' => function ($q) {
			$q->whereNull('date_of_leaving')->orderBy('joining_date', 'desc');
		}])->filterById($employee_id)->whereHas('employeeTerms', function ($q) use ($date) {
			$q->where('joining_date', '<=', $date)->whereNull('date_of_leaving');
		})->first();

		if (!$employee) {
			throw ValidationException::withMessages(['message' => trans('employee.invalid_record_for_given_date', ['date' => showDate($date)])]);
		}

		return $employee;
	}

	/**
	 * Update employee group
	 *
	 * @param array $params
	 * @return null
	 */
	public function updateGroup($params) {
		$employee_group_id = gv($params, 'employee_group_id');
		$action = gv($params, 'action');
		$ids = gv($params, 'ids', []);

		if (!in_array($action, ['attach', 'detach'])) {
			throw ValidationException::withMessages(['message' => trans('general.invalid_action')]);
		}

		if (!count($ids)) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_employee')]);
		}

		$accessible_employee_ids = $this->getAccessibleEmployeeId();

		if (count(array_diff($ids, $accessible_employee_ids))) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_some_employee')]);
		}

		$employees = $this->employee->whereIn('id', $ids)->get();

		foreach ($employees as $employee) {
			if ($action == 'attach') {
				$employee->employeeGroups()->attach($employee_group_id);
			} else {
				$employee->employeeGroups()->detach($employee_group_id);
			}
		}
	}
}
