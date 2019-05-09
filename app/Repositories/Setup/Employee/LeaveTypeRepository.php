<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\LeaveType;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class LeaveTypeRepository {
	protected $leave_type;
	protected $route;
	protected $permission;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		LeaveType $leave_type
	) {
		$this->leave_type = $leave_type;
		$this->route = 'setup.employee.leave_type.';
		$this->permission = '-employee_leave_type';

	}
	public function model() {
		return LeaveType::class;
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong> ';
		})->editColumn('description', function ($model) {
			return $model->description;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			$route = $this->route;
			$permission = $this->permission;
			return view('admin.setup.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description'])->make(true);
	}
	/**
	 * Get leave type query
	 *
	 * @return LeaveType query
	 */
	public function getQuery() {
		return $this->leave_type;
	}

	/**
	 * Count leave type
	 *
	 * @return integer
	 */
	public function count() {
		return $this->leave_type->count();
	}

	/**
	 * List all leave types by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->leave_type->where('status', 1)->get()->pluck('name', 'id')->prepend(trans('select.employee_leave_type'), '');
	}

	/**
	 * List all leave types by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->leave_type->all(['name', 'id']);
	}

	/**
	 * List all active leave types by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllActive() {
		return $this->leave_type->filterByStatus(1)->get(['name', 'id']);
	}

	/**
	 * List all leave types by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->leave_type->all()->pluck('id')->all();
	}

	/**
	 * Get all leave types
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->leave_type->all();
	}

	/**
	 * Find leave type with given id.
	 *
	 * @param integer $id
	 * @return LeaveType
	 */
	public function find($id) {
		return $this->leave_type->find($id);
	}

	/**
	 * Find leave type with given id or throw an error.
	 *
	 * @param integer $id
	 * @return LeaveType
	 */
	public function findOrFail($id) {
		$leave_type = $this->leave_type->find($id);

		if (!$leave_type) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_leave_type')]);
		}

		return $leave_type;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return LeaveType
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->leave_type->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all leave types using given params.
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
	 * @return LeaveType
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new leave type.
	 *
	 * @param array $params
	 * @return LeaveType
	 */
	public function create($params) {
		return $this->leave_type->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $leave_type_id
	 * @return array
	 */
	private function formatParams($params, $leave_type_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'alias' => gv($params, 'alias'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given leave type.
	 *
	 * @param LeaveType $leave_type
	 * @param array $params
	 *
	 * @return LeaveType
	 */
	public function update(LeaveType $leave_type, $params) {
		return $leave_type->forceFill($this->formatParams($params, $leave_type->id))->save();
	}

	/**
	 * Find leave type & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return LeaveType
	 */
	public function deletable($id) {
		$leave_type = $this->findOrFail($id);

		if ($leave_type->leaveRequests()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.leave_type.associated_with_leave_request')]);
		}

		if ($leave_type->leaveAllocationDetails()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.leave_type.associated_with_leave_allocation')]);
		}

		return $leave_type;
	}

	/**
	 * Delete leave type.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(LeaveType $leave_type) {
		return $leave_type->delete();
	}

	/**
	 * Delete multiple leave types.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->leave_type->whereIn('id', $ids)->delete();
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
