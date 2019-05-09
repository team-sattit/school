<?php
namespace App\Repositories\Setup\Misc;

use App\Model\Setup\Misc\Nationality;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class NationalityRepository {
	protected $nationality;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Nationality $nationality
	) {
		$this->nationality = $nationality;
	}
	public function model() {
		return Nationality::class;
	}
	private function route() {
		return 'setup.misc.nationality.';
	}
	private function permission() {
		return '-nationality';
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
	 * Get nationality query
	 *
	 * @return nationality query
	 */
	public function getQuery() {
		return $this->nationality;
	}

	/**
	 * Count nationality
	 *
	 * @return integer
	 */
	public function count() {
		return $this->nationality->count();
	}

	/**
	 * List all nationality by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->nationality->where('status', 1)->pluck('name', 'id')->prepend(trans('select.nationality'), '');
	}

	/**
	 * List all nationality by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->nationality->all(['name', 'id']);
	}

	/**
	 * List all nationality by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->nationality->all()->pluck('id')->all();
	}

	/**
	 * Get all nationality
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->nationality->all();
	}

	/**
	 * Find nationality with given id.
	 *
	 * @param integer $id
	 * @return nationality
	 */
	public function find($id) {
		return $this->nationality->find($id);
	}

	/**
	 * Find nationality with given id or throw an error.
	 *
	 * @param integer $id
	 * @return nationality
	 */
	public function findOrFail($id, $field = 'message') {
		$nationality = $this->nationality->find($id);

		if (!$nationality) {
			throw ValidationException::withMessages([$field => trans('setup.misc.nationality.not_find')]);
		}

		return $nationality;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return nationality
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->nationality->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all nationality using given params.
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
	 * @return nationality
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new nationality.
	 *
	 * @param array $params
	 * @return nationality
	 */
	public function create($params) {
		return $this->nationality->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $nationality_id
	 * @return array
	 */
	private function formatParams($params, $nationality_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given nationality.
	 *
	 * @param nationality $nationality
	 * @param array $params
	 *
	 * @return nationality
	 */
	public function update(nationality $nationality, $params) {
		return $nationality->forceFill($this->formatParams($params, $nationality->id))->save();
	}

	/**
	 * Delete nationality.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(nationality $nationality) {
		return $nationality->delete();
	}

	/**
	 * Delete multiple nationality.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->nationality->whereIn('id', $ids)->delete();
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
