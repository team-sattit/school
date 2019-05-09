<?php
namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\PayHead;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class PayHeadRepository {
	protected $pay_head;
	protected $route;
	protected $permission;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		PayHead $pay_head
	) {
		$this->pay_head = $pay_head;
		$this->route = 'setup.employee.payhead.';
		$this->permission = '-employee_pay_head';
	}
	public function model() {
		return PayHead::class;
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
	 * Get pay head query
	 *
	 * @return PayHead query
	 */
	public function getQuery() {
		return $this->pay_head;
	}

	/**
	 * Count pay head
	 *
	 * @return integer
	 */
	public function count() {
		return $this->pay_head->count();
	}

	/**
	 * List all pay heads by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->pay_head->all()->pluck('name', 'id')->all();
	}

	/**
	 * List all pay heads by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->pay_head->all(['name', 'id']);
	}

	/**
	 * List all active pay heads by name & id for select option
	 *
	 * @return array
	 */

	public function selectAllActive() {
		return $this->pay_head->filterbyStatus(1)->get(['name', 'id']);
	}

	/**
	 * List all pay heads by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->pay_head->all()->pluck('id')->all();
	}

	/**
	 * Get all pay heads
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->pay_head->all();
	}

	/**
	 * Find pay head with given id.
	 *
	 * @param integer $id
	 * @return PayHead
	 */
	public function find($id) {
		return $this->pay_head->find($id);
	}

	/**
	 * Find pay head with given id or throw an error.
	 *
	 * @param integer $id
	 * @return PayHead
	 */
	public function findOrFail($id) {
		$pay_head = $this->pay_head->find($id);

		if (!$pay_head) {
			throw ValidationException::withMessages(['message' => trans('employee.could_not_find_pay_head')]);
		}

		return $pay_head;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return PayHead
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->pay_head->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all pay heads using given params.
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
	 * @return PayHead
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new pay head.
	 *
	 * @param array $params
	 * @return PayHead
	 */
	public function create($params) {
		return $this->pay_head->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $pay_head_id
	 * @return array
	 */
	private function formatParams($params, $pay_head_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'type' => gv($params, 'type'),
			'description' => gv($params, 'description'),
			'alias' => gv($params, 'alias'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given pay head.
	 *
	 * @param PayHead $pay_head
	 * @param array $params
	 *
	 * @return PayHead
	 */
	public function update(PayHead $pay_head, $params) {
		if ($pay_head->payrollTemplateDetails()->count() && $pay_head->type != gv($params, 'type')) {
			throw ValidationException::withMessages(['message' => trans('employee.pay_head_associated_with_payroll_template')]);
		}

		return $pay_head->forceFill($this->formatParams($params, $pay_head->id))->save();
	}

	/**
	 * Find pay head & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return PayHead
	 */
	public function deletable($id) {
		$pay_head = $this->findOrFail($id);

		if ($pay_head->payrollTemplateDetails()->count()) {
			throw ValidationException::withMessages(['message' => trans('employee.pay_head_associated_with_payroll_template')]);
		}

		$pay_head = $this->findOrFail($id);

		return $pay_head;
	}

	/**
	 * Delete pay head.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(PayHead $pay_head) {
		return $pay_head->delete();
	}

	/**
	 * Delete multiple pay heads.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->pay_head->whereIn('id', $ids)->delete();
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
