<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\EmployeeGroup;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class EmployeeGroupRepository {
	protected $group;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		EmployeeGroup $group
	) {
		$this->group = $group;
	}
	public function model() {
		return EmployeeGroup::class;
	}
	private function route() {
		return 'setup.employee.group.';
	}
	private function permission() {
		return '-employee_group';
	}

	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong>';
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
	 * Get group query
	 *
	 * @return group query
	 */
	public function getQuery() {
		return $this->group;
	}

	/**
	 * Count group
	 *
	 * @return integer
	 */
	public function count() {
		return $this->group->count();
	}

	/**
	 * List all group by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->group->all()->where('status', 1)->get()->pluck('name', 'id')->prepend(trans('select.employee_group'), '');
	}

	/**
	 * List all group by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->group->all(['name', 'id']);
	}

	/**
	 * List all group by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->group->all()->pluck('id')->all();
	}

	/**
	 * Get all group
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->group->all();
	}

	/**
	 * Find group with given id.
	 *
	 * @param integer $id
	 * @return group
	 */
	public function find($id) {
		return $this->group->find($id);
	}

	/**
	 * Find group with given id or throw an error.
	 *
	 * @param integer $id
	 * @return group
	 */
	public function findOrFail($id, $field = 'message') {
		$group = $this->group->find($id);

		if (!$group) {
			throw ValidationException::withMessages([$field => trans('setup.employee.group.not_find')]);
		}

		return $group;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return group
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->group->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all group using given params.
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
	 * @return group
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new group.
	 *
	 * @param array $params
	 * @return group
	 */
	public function create($params) {
		return $this->group->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $group_id
	 * @return array
	 */
	private function formatParams($params, $group_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given group.
	 *
	 * @param group $group
	 * @param array $params
	 *
	 * @return group
	 */
	public function update(EmployeeGroup $group, $params) {
		return $group->forceFill($this->formatParams($params, $group->id))->save();
	}

	/**
	 * Find group & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return group
	 */
	public function deletable($id) {
		$employee_group = $this->findOrFail($id);

		return $employee_group;
	}

	/**
	 * Delete group.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(EmployeeGroup $group) {
		return $group->delete();
	}

	/**
	 * Delete multiple group.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->group->whereIn('id', $ids)->delete();
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
