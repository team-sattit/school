<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\Department;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class DepartmentRepository {
	protected $department;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Department $department
	) {
		$this->department = $department;
	}
	public function model() {
		return Department::class;
	}
	private function route() {
		return 'setup.employee.department.';
	}
	private function permission() {
		return '-employee_department';
	}

	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong> (' . $model->code . ')';
		})->editColumn('description', function ($model) {
			return $model->description;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			$route = $this->route();
			$permission = $this->permission();
			return view('admin.setup.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description'])->make(true);
	}

	/**
	 * Get Department query
	 *
	 * @return Department query
	 */
	public function getQuery() {
		return $this->department;
	}

	/**
	 * Count Department
	 *
	 * @return integer
	 */
	public function count() {
		return $this->department->count();
	}

	/**
	 * List all Department by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->department->where('status', 1)->pluck('name', 'id')->prepend(trans('select.department'), '');
	}

	/**
	 * List all Department by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->department->all(['name', 'id']);
	}

	/**
	 * List all Department by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->department->all()->pluck('id')->all();
	}

	/**
	 * Get all Department
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->department->all();
	}

	/**
	 * Find Department with given id.
	 *
	 * @param integer $id
	 * @return Department
	 */
	public function find($id) {
		return $this->department->find($id);
	}

	/**
	 * Find Department with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Department
	 */
	public function findOrFail($id, $field = 'message') {
		$department = $this->department->find($id);

		if (!$department) {
			throw ValidationException::withMessages([$field => trans('setup.employee.department.not_find')]);
		}

		return $department;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Department
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->department->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all Department using given params.
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
	 * @return Department
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new Department.
	 *
	 * @param array $params
	 * @return Department
	 */
	public function create($params) {
		return $this->department->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $department_id
	 * @return array
	 */
	private function formatParams($params, $department_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'code' => gv($params, 'code'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given Department.
	 *
	 * @param Department $Department
	 * @param array $params
	 *
	 * @return Department
	 */
	public function update(Department $department, $params) {
		return $department->forceFill($this->formatParams($params, $department->id))->save();
	}

	/**
	 * Find Department & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Department
	 */
	public function deletable($id) {
		$department = $this->findOrFail($id);

		if ($department->employeeDesignations()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.department.associated_with_term')]);
		}

		return $department;
	}

	/**
	 * Delete Department.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Department $department) {
		return $department->delete();
	}

	/**
	 * Delete multiple Department.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->department->whereIn('id', $ids)->delete();
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
