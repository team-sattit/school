<?php
namespace App\Repositories\Setup\Student;

use App\Model\Setup\Student\Subject;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class SubjectRepository {
	protected $subject;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Subject $subject
	) {
		$this->subject = $subject;
	}
	public function model() {
		return Subject::class;
	}
	private function route() {
		return 'setup.student.subject.';
	}
	private function permission() {
		return '-subject';
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
	 * @return subject query
	 */
	public function getQuery() {
		return $this->subject;
	}

	/**
	 * Count subject
	 *
	 * @return integer
	 */
	public function count() {
		return $this->subject->count();
	}

	/**
	 * List all subject by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->subject->where('status', 1)->pluck('name', 'id')->prepend(trans('select.subject'), '');
	}

	/**
	 * List all subject by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->subject->all(['name', 'id']);
	}

	/**
	 * List all subject by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->subject->all()->pluck('id')->all();
	}

	/**
	 * Get all subject
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->subject->all();
	}

	/**
	 * Find subject with given id.
	 *
	 * @param integer $id
	 * @return subject
	 */
	public function find($id) {
		return $this->subject->find($id);
	}

	/**
	 * Find subject with given id or throw an error.
	 *
	 * @param integer $id
	 * @return subject
	 */
	public function findOrFail($id) {
		$subject = $this->subject->find($id);

		if (!$subject) {
			throw ValidationException::withMessages(['message' => trans('misc.could_not_find_subject')]);
		}

		return $subject;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return subject
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->subject->orderBy($sort_by, $order);
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
	 * @return subject
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new bank.
	 *
	 * @param array $params
	 * @return subject
	 */
	public function create($params) {
		return $this->subject->forceCreate($this->formatParams($params));
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
	 * Update given subject.
	 *
	 * @param subject $subject
	 * @param array $params
	 *
	 * @return subject
	 */
	public function update(Subject $subject, $params) {
		return $subject->forceFill($this->formatParams($params, $subject->id))->save();
	}

	/**
	 * Delete Class.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Subject $subject) {
		return $subject->delete();
	}

	/**
	 * Delete multiple banks.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->subject->whereIn('id', $ids)->delete();
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
