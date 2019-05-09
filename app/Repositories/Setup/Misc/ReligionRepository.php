<?php
namespace App\Repositories\Setup\Misc;

use App\Model\Setup\Misc\Religion;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class ReligionRepository {
	protected $religion;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Religion $religion
	) {
		$this->religion = $religion;
	}
	public function model() {
		return Religion::class;
	}
	private function route() {
		return 'setup.misc.religion.';
	}
	private function permission() {
		return '-religion';
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
	 * Get religion query
	 *
	 * @return religion query
	 */
	public function getQuery() {
		return $this->religion;
	}

	/**
	 * Count religion
	 *
	 * @return integer
	 */
	public function count() {
		return $this->religion->count();
	}

	/**
	 * List all religion by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->religion->where('status', 1)->pluck('name', 'id')->prepend(trans('select.religion'), '');
	}

	/**
	 * List all religion by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->religion->all(['name', 'id']);
	}

	/**
	 * List all religion by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->religion->all()->pluck('id')->all();
	}

	/**
	 * Get all religion
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->religion->all();
	}

	/**
	 * Find religion with given id.
	 *
	 * @param integer $id
	 * @return religion
	 */
	public function find($id) {
		return $this->religion->find($id);
	}

	/**
	 * Find religion with given id or throw an error.
	 *
	 * @param integer $id
	 * @return religion
	 */
	public function findOrFail($id, $field = 'message') {
		$religion = $this->religion->find($id);

		if (!$religion) {
			throw ValidationException::withMessages([$field => trans('setup.misc.religion.not_find')]);
		}

		return $religion;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return religion
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->religion->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all religion using given params.
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
	 * @return religion
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new religion.
	 *
	 * @param array $params
	 * @return religion
	 */
	public function create($params) {
		return $this->religion->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $religion_id
	 * @return array
	 */
	private function formatParams($params, $religion_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given religion.
	 *
	 * @param religion $religion
	 * @param array $params
	 *
	 * @return religion
	 */
	public function update(religion $religion, $params) {
		return $religion->forceFill($this->formatParams($params, $religion->id))->save();
	}

	/**
	 * Delete religion.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(religion $religion) {
		return $religion->delete();
	}

	/**
	 * Delete multiple religion.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->religion->whereIn('id', $ids)->delete();
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
