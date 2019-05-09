<?php
namespace App\Repositories\Employee;

use App\Model\Employee\EmployeeSalary;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class EmployeeSalaryRepository {
	protected $employee_salary;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		EmployeeSalary $employee_salary
	) {
		$this->employee_salary = $employee_salary;
	}

	public function model() {
		return EmployeeSalary::class;
	}
	private function route() {
		return 'setup.employee.category.';
	}
	private function permission() {
		return '-employee_salary';
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			$employee_name = '<strong>' . $model->name . '</strong>';
			if ($model->name == config('trt.system_admin_category_name')) {
				$employee_name .= '<span class="badge badge-primary ml-1">' . __('trt.default') . '</span>';
			}
			return $employee_name;
		})->editColumn('description', function ($model) {
			return $model->description;
		})->addColumn('designation', function ($model) {
			$designation = '';
			foreach ($model->designations as $value) {
				$designation .= $value->name . '<br/>';
			}
			return $designation;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			if ($model->name != config('trt.system_admin_category_name')) {
				$route = $this->route();
				$permission = $this->permission();
				return view('admin.setup.action', compact('model', 'route', 'permission'));
			} else {
				return;
			}

		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description', 'designation'])->make(true);
	}
	/**
	 * Get employee category query
	 *
	 * @return EmployeeSalary query
	 */
	public function getQuery() {
		return $this->employee_salary;
	}

	/**
	 * Count employee category
	 *
	 * @return integer
	 */
	public function count() {
		return $this->employee_salary->count();
	}

	/**
	 * List all employee categories by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->employee_salary->where('status', 1)->get()->pluck('name', 'id')->prepend(trans('select.employee_salary'), '');
	}

	/**
	 * List all employee categories by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->employee_salary->all(['name', 'id']);
	}

	/**
	 * List all employee categories except default by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllExludingDefault() {
		return $this->employee_salary->info()->excludeDefault()->get(['name', 'id']);
	}

	/**
	 * List all employee categories by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->employee_salary->all()->pluck('id')->all();
	}

	/**
	 * Get all employee categories
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->employee_salary->get();
	}

	/**
	 * Get all employee categories excluding default
	 *
	 * @return array
	 */
	public function getAllExcludingDefault() {
		return $this->employee_salary->info()->excludeDefault()->get();
	}

	/**
	 * Find employee category with given id.
	 *
	 * @param integer $id
	 * @return EmployeeSalary
	 */
	public function find($id) {
		return $this->employee_salary->info()->find($id);
	}

	/**
	 * Find employee category with given id or throw an error.
	 *
	 * @param integer $id
	 * @return EmployeeSalary
	 */
	public function findOrFail($id, $field = 'message') {
		$employee_salary = $this->employee_salary->info()->find($id);

		if (!$employee_salary) {
			throw ValidationException::withMessages([$field => trans('setup.employee.category.not_find')]);
		}

		return $employee_salary;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return EmployeeSalary
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->employee_salary->info()->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all employee category using given params.
	 *
	 * @param array $params
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate($params) {
		$page_length = gv($params, 'page_length', config('trt.page_length'));

		return $this->getData($params)->paginate($page_length);
	}

	/**
	 * Get all filtered data for printing
	 *
	 * @param array $params
	 * @return EmployeeSalary
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new employee category.
	 *
	 * @param array $params
	 * @return EmployeeSalary
	 */
	public function create($params) {
		return $this->employee_salary->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $employee_salary_id
	 * @return array
	 */
	private function formatParams($params, $employee_salary_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given employee category.
	 *
	 * @param EmployeeSalary $employee_salary
	 * @param array $params
	 *
	 * @return EmployeeSalary
	 */
	public function update(EmployeeSalary $employee_salary, $params) {
		if ($employee_salary->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_salary')]);
		}

		return $employee_salary->forceFill($this->formatParams($params, $employee_salary->id))->save();
	}

	/**
	 * Find employee category & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return EmployeeSalary
	 */
	public function deletable($id) {
		$employee_salary = $this->findOrFail($id);

		if ($employee_salary->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_salary')]);
		}

		if ($employee_salary->designations()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.associated_with_designation')]);
		}

		return $employee_salary;
	}

	/**
	 * Delete employee category.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(EmployeeSalary $employee_salary) {
		return $employee_salary->delete();
	}

	/**
	 * Delete multiple employee categories.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->employee_salary->whereIn('id', $ids)->delete();
	}

	public function updateStatus($id) {
		$model = $this->findOrFail($id);
		if ($model->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_salary')]);
		}
		if ($model->status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		return $model->update(['status' => $status]);
	}
}
