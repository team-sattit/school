<?php
namespace App\Repositories\Setup\Finance;

use App\Model\Setup\Finance\Bank;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class BankRepository {
	protected $bank;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Bank $bank
	) {
		$this->bank = $bank;
	}
	public function model() {
		return Bank::class;
	}
	private function route() {
		return 'setup.finance.bank.';
	}
	private function permission() {
		return '-bank';
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
	 * Get bank query
	 *
	 * @return Bank query
	 */
	public function getQuery() {
		return $this->bank;
	}

	/**
	 * Count bank
	 *
	 * @return integer
	 */
	public function count() {
		return $this->bank->count();
	}

	/**
	 * List all banks by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->bank->where('status', 1)->pluck('name', 'id')->prepend(trans('select.bank'), '');
	}

	/**
	 * List all banks by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->bank->all(['name', 'id']);
	}

	/**
	 * List all banks by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->bank->all()->pluck('id')->all();
	}

	/**
	 * Get all banks
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->bank->all();
	}

	/**
	 * Find bank with given id.
	 *
	 * @param integer $id
	 * @return Bank
	 */
	public function find($id) {
		return $this->bank->find($id);
	}

	/**
	 * Find bank with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Bank
	 */
	public function findOrFail($id) {
		$bank = $this->bank->find($id);

		if (!$bank) {
			throw ValidationException::withMessages(['message' => trans('misc.could_not_find_bank')]);
		}

		return $bank;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Bank
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->bank->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all banks using given params.
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
	 * @return Bank
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new bank.
	 *
	 * @param array $params
	 * @return Bank
	 */
	public function create($params) {
		return $this->bank->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $bank_id
	 * @return array
	 */
	private function formatParams($params, $bank_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given bank.
	 *
	 * @param Bank $bank
	 * @param array $params
	 *
	 * @return Bank
	 */
	public function update(Bank $bank, $params) {
		return $bank->forceFill($this->formatParams($params, $bank->id))->save();
	}

	/**
	 * Delete bank.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Bank $bank) {
		return $bank->delete();
	}

	/**
	 * Delete multiple banks.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->bank->whereIn('id', $ids)->delete();
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
