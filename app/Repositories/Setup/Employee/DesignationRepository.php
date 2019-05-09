<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\Designation;
use App\Repositories\Setup\Employee\EmployeeCategoryRepository;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class DesignationRepository {
	protected $designation;
	protected $employee_category;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Designation $designation,
		EmployeeCategoryRepository $employee_category
	) {
		$this->designation = $designation;
		$this->employee_category = $employee_category;
	}

	public function model() {
		return Designation::class;
	}

	private function route() {
		return 'setup.employee.designation.';
	}
	private function permission() {
		return '-employee_designation';
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			$employee_name = '<strong>' . $model->name . '</strong>';
			if ($model->name == config('trt.system_admin_designation')) {
				$employee_name .= '<span class="badge badge-primary ml-1">' . __('trt.default') . '</span>';
			}
			if ($model->is_teaching_employee) {
				$employee_name .= '<span class="badge badge-primary ml-1">' . __('trt.teaching_employee') . '</span>';
			};
			return $employee_name;
		})->addColumn('top_designation', function ($model) {
			if ($model->topDesignation) {
				return $model->topDesignation->name;
			} else {
				return '-';
			}
		})->addColumn('category', function ($model) {
			return $model->employeeCategory->name;
		})->addColumn('description', function ($model) {
			return $model->description;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			if ($model->name != config('trt.system_admin_designation')) {
				$route = $this->route();
				$permission = $this->permission();
				return view('admin.setup.action', compact('model', 'route', 'permission'));
			} else {
				return;
			}
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description'])->make(true);
	}

	/**
	 * Get designation query
	 *
	 * @return Designation query
	 */
	public function getQuery() {
		return $this->designation;
	}

	/**
	 * Count designation
	 *
	 * @return integer
	 */
	public function count() {
		return $this->designation->count();
	}

	/**
	 * List all designation by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->designation->all()->pluck('name', 'id')->all();
	}

	/**
	 * List all designation by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return generateSelectOption($this->designation->get()->pluck('name', 'id')->all());
	}

	/**
	 * List all designation except default by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllExludingDefault() {
		return $this->designation->with('employeeCategory')->whereHas('employeeCategory', function ($query) {$query->where('status', 1);})->where('name', '!=', config('trt.system_admin_designation'))->where('status', 1)->get()->pluck('designation_with_category', 'id')->prepend(trans('select.designation'), '');
	}

	/**
	 * Get designation option with employee category.
	 *
	 * @return Array $designations
	 */
	public function getDesignationOption() {
		$employee_categories = $this->employee_category->getAllExcludingDefault();

		$subordinate_ids = $this->getSubordinateId();

		$designations = array();
		foreach ($employee_categories as $employee_category) {
			$data = array();
			foreach ($employee_category->Designations as $designation) {
				if (in_array($designation->id, $subordinate_ids)) {
					$data[] = array(
						'id' => $designation->id,
						'name' => $designation->name,
					);
				}
			}

			$designations[] = array(
				'designations' => $data,
				'employee_category' => $employee_category->name,
			);
		}

		return $designations;
	}

	/**
	 * List all designation by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->designation->all()->pluck('id')->all();
	}

	/**
	 * Get all designation
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->designation->all();
	}

	/**
	 * Find designation with given id.
	 *
	 * @param integer $id
	 * @return Designation
	 */
	public function find($id) {
		return $this->designation->info()->find($id);
	}

	/**
	 * Find designation with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Designation
	 */
	public function findOrFail($id, $field = 'message') {
		$designation = $this->designation->info()->find($id);

		if (!$designation) {
			throw ValidationException::withMessages([$field => trans('employee.could_not_find_designation')]);
		}

		return $designation;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Designation
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->designation->info()->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all designation using given params.
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
	 * @return Designation
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Get all subordinate designation's id for given user.
	 *
	 * @param object $user
	 * @param boolean $self (Pass 1 to include given user's designation)
	 * @return array
	 */
	public function getSubordinateId($user = null, $self = 0) {
		$user = ($user) ?: \Auth::user();
		$user_designation_id = getEmployeeDesignationId($user->Employee);

		if ($user->can('access-all-employee')) {
			return $this->designation->all()->pluck('id')->all();
		} elseif ($user->can('access-subordinate-employee')) {
			$childs = ($user_designation_id) ? $this->getChild($user_designation_id, 1) : [];
			if ($self && $user_designation_id) {
				array_push($childs, $user_designation_id);
			}
			return $childs;
		} else {
			return ($self && $user_designation_id) ? [$user_designation_id] : [];
		}
	}

	/**
	 * List all subordinate designation for given designation.
	 *
	 * @param integer $designation_id
	 * @param boolean $only_id (Pass 0 to include given designation's name & id, 1 for only id)
	 * @param boolean $level
	 * @return array
	 */
	public function getChild($designation_id, $only_id = 0, $level = 1) {
		$auth_user = \Auth::user();

		$designations = $this->getAll();

		$designation_name = $designations->pluck('name', 'id')->all();

		if ($auth_user->can('access-all-employee')) {
			$children = $designations->pluck('id')->all();
		}

		if (!config('config.designation_subordinate_level')) {
			$children = $designations->where('top_designation_id', '=', $designation_id)->pluck('id')->all();
		}

		$tree = array();
		$all_designations = $designations->where('top_designation_id', '!=', null)->all();

		foreach ($all_designations as $designation) {
			$tree[$designation->id] = ['parent_id' => $designation->top_designation_id];
		}

		$children = getChilds($tree, $designation_id, $level);

		if ($only_id) {
			return $children;
		}

		$children_with_name = array();
		foreach ($children as $child) {
			$children_with_name[$child] = !empty($designation_name[$child]) ? $designation_name[$child] : null;
		}

		return $children_with_name;
	}

	/**
	 * Get designation pre requisite.
	 *
	 * @return Array
	 */
	public function getPreRequisite() {
		$employee_categories = $this->employee_category->selectAllExludingDefault()->pluck('name', 'id')->prepend('Select Employee Category', '');
		$top_designations = $this->designation->excludeDefault()->whereIn('id', $this->getSubordinateId())->get()->pluck('designation_with_category', 'id')->prepend('Select Employee Category', '');

		return compact('employee_categories', 'top_designations');
	}

	/**
	 * Create a new designation.
	 *
	 * @param array $params
	 * @return Designation
	 */
	public function create($params) {
		return $this->designation->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $designation_id
	 * @return array
	 */
	private function formatParams($params, $designation_id = null) {
		$employee_category = $this->employee_category->findOrFail(gv($params, 'employee_category_id'), 'employee_category_id');

		if ($employee_category->name == config('config.system_admin_employee_category')) {
			throw ValidationException::withMessages(['employee_category_id' => trans('setup.employee.category.not_find')]);
		}

		$top_designation_id = gv($params, 'top_designation_id');

		$top_designation = ($top_designation_id) ? $this->designation->find($top_designation_id) : $this->designation->filterByName(config('trt.system_admin_designation'), 1)->first();

		if (!$designation_id && $top_designation_id && $top_designation->name == config('trt.system_admin_designation')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.designation.not_find')]);
		}

		if ($designation_id && $top_designation_id && (in_array($top_designation_id, $this->getChild($designation_id, 1)) || $top_designation_id == $designation_id)) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.designation.cannot_become_child')]);
		}

		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'employee_category_id' => $employee_category->id,
			'top_designation_id' => optional($top_designation)->id,
			'is_teaching_employee' => gbv($params, 'is_teaching_employee'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given designation.
	 *
	 * @param Designation $designation
	 * @param array $params
	 *
	 * @return Designation
	 */
	public function update(Designation $designation, $params) {
		if ($designation->name == config('trt.system_admin_designation')) {
			throw ValidationException::withMessages(['message' => trans('trt.permission_denied')]);
		}
		return $designation->forceFill($this->formatParams($params, $designation->id))->save();
	}

	/**
	 * Find designation & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Designation
	 */
	public function deletable($id) {
		$designation = $this->findOrFail($id);

		if ($designation->name == config('trt.system_admin_designation')) {
			throw ValidationException::withMessages(['message' => trans('trt.permission_denied')]);
		}

		if ($designation->employeeDesignations()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.designation.associated_with_term')]);
		}

		if ($this->designation->filterByTopDesignationId($designation->id)->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.designation.associated_with_subordinates')]);
		}

		return $designation;
	}

	/**
	 * Delete designation.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Designation $designation) {
		return $designation->delete();
	}

	/**
	 * Delete multiple designation.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->designation->whereIn('id', $ids)->delete();
	}

	public function updateStatus($id) {
		$model = $this->findOrFail($id);
		if ($model->status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		return $model->update(['status' => $status]);
	}
}
