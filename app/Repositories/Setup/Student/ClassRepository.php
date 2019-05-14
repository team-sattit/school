<?php
namespace App\Repositories\Setup\Student;

use App\Model\Setup\Student\AcademicClass;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class ClassRepository {
	protected $class;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		AcademicClass $class
	) {
		$this->class = $class;
	}
	public function model() {
		return AcademicClass::class;
	}
	private function route() {
		return 'setup.student.class.';
	}
	private function permission() {
		return '-class';
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
	 * @return Class query
	 */
	public function getQuery() {
		return $this->class;
	}

	/**
	 * Count Class
	 *
	 * @return integer
	 */
	public function count() {
		return $this->class->count();
	}

	/**
	 * List all Class by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->class->where('status', 1)->pluck('name', 'id')->prepend(trans('select.class'), '');
	}

	/**
	 * List all Class by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->class->all(['name', 'id']);
	}

	/**
	 * List all Class by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->class->all()->pluck('id')->all();
	}

	/**
	 * Get all Class
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->class->all();
	}

	/**
	 * Find class with given id.
	 *
	 * @param integer $id
	 * @return Class
	 */
	public function find($id) {
		return $this->class->find($id);
	}

	/**
	 * Find class with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Class
	 */
	public function findOrFail($id) {
		$class = $this->class->find($id);

		if (!$class) {
			throw ValidationException::withMessages(['message' => trans('misc.could_not_find_class')]);
		}

		return $class;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Class
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->class->orderBy($sort_by, $order);
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
	 * @return Class
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new bank.
	 *
	 * @param array $params
	 * @return Class
	 */
	public function create($params) {
		return $this->class->forceCreate($this->formatParams($params));
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
	 * Update given class.
	 *
	 * @param Class $class
	 * @param array $params
	 *
	 * @return Class
	 */
	public function update(AcademicClass $class, $params) {
		return $class->forceFill($this->formatParams($params, $class->id))->save();
	}

	/**
	 * Delete Class.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(AcademicClass $class) {
		return $class->delete();
	}

	/**
	 * Delete multiple banks.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->class->whereIn('id', $ids)->delete();
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
