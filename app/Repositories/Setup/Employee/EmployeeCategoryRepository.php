<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\EmployeeCategory;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class EmployeeCategoryRepository {
	protected $employee_category;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		EmployeeCategory $employee_category
	) {
		$this->employee_category = $employee_category;
	}

	public function model() {
		return EmployeeCategory::class;
	}
	private function route() {
		return 'setup.employee.category.';
	}
	private function permission() {
		return '-employee_category';
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
	 * @return EmployeeCategory query
	 */
	public function getQuery() {
		return $this->employee_category;
	}

	/**
	 * Count employee category
	 *
	 * @return integer
	 */
	public function count() {
		return $this->employee_category->count();
	}

	/**
	 * List all employee categories by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->employee_category->where('status', 1)->get()->pluck('name', 'id')->prepend(trans('select.employee_category'), '');
	}

	/**
	 * List all employee categories by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->employee_category->all(['name', 'id']);
	}

	/**
	 * List all employee categories except default by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllExludingDefault() {
		return $this->employee_category->info()->excludeDefault()->get(['name', 'id']);
	}

	/**
	 * List all employee categories by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->employee_category->all()->pluck('id')->all();
	}

	/**
	 * Get all employee categories
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->employee_category->get();
	}

	/**
	 * Get all employee categories excluding default
	 *
	 * @return array
	 */
	public function getAllExcludingDefault() {
		return $this->employee_category->info()->excludeDefault()->get();
	}

	/**
	 * Find employee category with given id.
	 *
	 * @param integer $id
	 * @return EmployeeCategory
	 */
	public function find($id) {
		return $this->employee_category->info()->find($id);
	}

	/**
	 * Find employee category with given id or throw an error.
	 *
	 * @param integer $id
	 * @return EmployeeCategory
	 */
	public function findOrFail($id, $field = 'message') {
		$employee_category = $this->employee_category->info()->find($id);

		if (!$employee_category) {
			throw ValidationException::withMessages([$field => trans('setup.employee.category.not_find')]);
		}

		return $employee_category;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return EmployeeCategory
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->employee_category->info()->orderBy($sort_by, $order);
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
	 * @return EmployeeCategory
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new employee category.
	 *
	 * @param array $params
	 * @return EmployeeCategory
	 */
	public function create($params) {
		return $this->employee_category->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $employee_category_id
	 * @return array
	 */
	private function formatParams($params, $employee_category_id = null) {
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
	 * @param EmployeeCategory $employee_category
	 * @param array $params
	 *
	 * @return EmployeeCategory
	 */
	public function update(EmployeeCategory $employee_category, $params) {
		if ($employee_category->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_category')]);
		}

		return $employee_category->forceFill($this->formatParams($params, $employee_category->id))->save();
	}

	/**
	 * Find employee category & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return EmployeeCategory
	 */
	public function deletable($id) {
		$employee_category = $this->findOrFail($id);

		if ($employee_category->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_category')]);
		}

		if ($employee_category->designations()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.associated_with_designation')]);
		}

		return $employee_category;
	}

	/**
	 * Delete employee category.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(EmployeeCategory $employee_category) {
		return $employee_category->delete();
	}

	/**
	 * Delete multiple employee categories.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->employee_category->whereIn('id', $ids)->delete();
	}

	public function updateStatus($id) {
		$model = $this->findOrFail($id);
		if ($model->name == config('trt.system_admin_category_name')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.category.default_employee_category')]);
		}
		if ($model->status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		return $model->update(['status' => $status]);
	}
}
