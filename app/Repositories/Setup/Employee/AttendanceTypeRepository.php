<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\AttendanceType;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class AttendanceTypeRepository {
	protected $attendance_type;
	protected $route;
	protected $permission;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		AttendanceType $attendance_type
	) {
		$this->attendance_type = $attendance_type;
		$this->route = 'setup.employee.attendance_type.';
		$this->permission = '-employee_attendance_type';
	}

	public function model() {
		return AttendanceType::class;
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('type', function ($model) {
			return $model->type;
		})->addColumn('name', function ($model) {
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
	 * Get attendance type query
	 *
	 * @return AttendanceType query
	 */
	public function getQuery() {
		return $this->attendance_type;
	}

	/**
	 * Count attendance type
	 *
	 * @return integer
	 */
	public function count() {
		return $this->attendance_type->count();
	}

	/**
	 * List all attendance types by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->attendance_type->where('status', 1)->pluck('name', 'id')->prepend(trans('select.attendance_type'), '');
	}

	/**
	 * List all attendance types by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->attendance_type->all(['name', 'id']);
	}

	/**
	 * List all active attendance types by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllActive() {
		return $this->attendance_type->filterByStatus(1)->get(['name', 'id']);
	}

	/**
	 * List all attendance types by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->attendance_type->all()->pluck('id')->all();
	}

	/**
	 * List all production based attendance types by id
	 *
	 * @return array
	 */
	public function listProductionBasedId() {
		return $this->attendance_type->all()->pluck('id')->all();
	}

	/**
	 * Get all attendance types
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->attendance_type->all();
	}

	/**
	 * Get all production attendance types
	 *
	 * @return array
	 */
	public function getAllProductionBased() {
		return $this->attendance_type->select(['id', 'name', 'alias', 'type', 'unit'])->whereIn('type', ['production_based_earning', 'production_based_deduction'])->get();
	}

	/**
	 * Find attendance type with given id.
	 *
	 * @param integer $id
	 * @return AttendanceType
	 */
	public function find($id) {
		return $this->attendance_type->find($id);
	}

	/**
	 * Find attendance type with given id or throw an error.
	 *
	 * @param integer $id
	 * @return AttendanceType
	 */
	public function findOrFail($id) {
		$attendance_type = $this->attendance_type->find($id);

		if (!$attendance_type) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_attendance_type')]);
		}

		return $attendance_type;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return AttendanceType
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->attendance_type->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all attendance types using given params.
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
	 * @return AttendanceType
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new attendance type.
	 *
	 * @param array $params
	 * @return AttendanceType
	 */
	public function create($params) {
		return $this->attendance_type->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $attendance_type_id
	 * @return array
	 */
	private function formatParams($params, $attendance_type_id = null) {
		$type = gv($params, 'type');
		$unit = gv($params, 'unit');
		$alias = gv($params, 'alias');

		if (!in_array($type, ['present', 'holiday', 'absent', 'half_day', 'production_based_earning', 'production_based_deduction'])) {
			throw ValidationException::withMessages(['message' => trans('general.invalid_input')]);
		}

		if (in_array($type, ['production_based_earning', 'production_based_deduction']) && !$unit) {
			throw ValidationException::withMessages(['message' => trans('validation.required', ['attribute' => trans('employee.attendance_type_unit')])]);
		}

		if ($alias == 'L' || ($alias == 'H' && $type != 'holiday')) {
			throw ValidationException::withMessages(['message' => trans('employee.attendance_type_reserved_alias', ['alias' => $alias])]);
		}

		$formatted = [
			'type' => $type,
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'alias' => $alias,
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given attendance type.
	 *
	 * @param AttendanceType $attendance_type
	 * @param array $params
	 *
	 * @return AttendanceType
	 */
	public function update(AttendanceType $attendance_type, $params) {
		if ($attendance_type->attendances()->count() && $attendance_type->type != gv($params, 'type')) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.attendance_type.associated_with_attendance')]);
		}

		return $attendance_type->forceFill($this->formatParams($params, $attendance_type->id))->save();
	}

	/**
	 * Find attendance type & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return AttendanceType
	 */
	public function deletable($id) {
		$attendance_type = $this->findOrFail($id);

		if ($attendance_type->attendances()->count()) {
			throw ValidationException::withMessages(['message' => trans('employee.attendance_type_associated_with_attendance')]);
		}
		return $attendance_type;
	}

	/**
	 * Delete attendance type.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(AttendanceType $attendance_type) {
		return $attendance_type->delete();
	}

	/**
	 * Delete multiple attendance types.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->attendance_type->whereIn('id', $ids)->delete();
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
