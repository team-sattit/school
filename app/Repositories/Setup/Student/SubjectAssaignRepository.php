<?php
namespace App\Repositories\Setup\Student;

use App\Repositories\Setup\Student\ClassRepository;
use App\Repositories\Setup\Student\SubjectRepository;

use App\Model\Setup\Student\SubjectAssaign;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class SubjectAssaignRepository {
	protected $subject_assaign;
	protected $subject;
	protected $class;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		SubjectAssaign $subject_assaign,
		SubjectRepository $subject,
		ClassRepository $class
	) {
		$this->subject_assaign = $subject_assaign;
		$this->subject = $subject;
		$this->class = $class;
	}
	public function model() {
		return SubjectAssaign::class;
	}
	private function route() {
		return 'setup.student.subject_assaign.';
	}
	private function permission() {
		return '-subject_assaign';
	}

	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('class', function ($model) {
			return '<strong>' . $model->class? $model->class->name : 'No Class' . '</strong>';
		})->addColumn('subject', function ($model) {
			return '<strong>' . $model->subject? $model->subject->name : 'No Class' . '</strong>';
		})->editColumn('category', function ($model) {
			return trans('list.'.$model->category);
		})->addColumn('action', function ($model) {
			$route = $this->route();
			$permission = $this->permission();
			return view('admin.setup.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'class', 'subject'])->make(true);
	}

	/**
	 * Get bank query
	 *
	 * @return subject_assaign query
	 */
	public function getQuery() {
		return $this->subject_assaign;
	}

	/**
	 * Count subject_assaign
	 *
	 * @return integer
	 */
	public function count() {
		return $this->subject_assaign->count();
	}

	/**
	 * List all subject_assaign by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->subject_assaign->where('status', 1)->pluck('name', 'id')->prepend(trans('select.subject_assaign'), '');
	}

	/**
	 * List all subject by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->subject_assaign->all(['name', 'id']);
	}

	/**
	 * List all subject by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->subject_assaign->all()->pluck('id')->all();
	}

	/**
	 * Get all subject
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->subject_assaign->all();
	}

	/**
	 * Find subject_assaign with given id.
	 *
	 * @param integer $id
	 * @return subject_assaign
	 */
	public function find($id) {
		return $this->subject_assaign->find($id);
	}

	/**
	 * Find subject_assaign with given id or throw an error.
	 *
	 * @param integer $id
	 * @return subject_assaign
	 */
	public function findOrFail($id) {
		$subject_assaign = $this->subject_assaign->find($id);

		if (!$subject_assaign) {
			throw ValidationException::withMessages(['message' => trans('misc.could_not_find_subject')]);
		}

		return $subject_assaign;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return subject_assaign
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->subject_assaign->orderBy($sort_by, $order);
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
	 * @return subject_assaign
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new bank.
	 *
	 * @param array $params
	 * @return subject_assaign
	 */
	public function create($params) {
		return $this->subject_assaign->forceCreate($this->formatParams($params));
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
			'class_id' => gv($params, 'class_id'),
			'subject_id' => gv($params, 'subject_id'),
			'category' => gv($params, 'category'),
		];
		$formatted['options'] = [];
		return $formatted;
	}

	/**
	 * Update given subject_assaign.
	 *
	 * @param subject_assaign $subject_assaign
	 * @param array $params
	 *
	 * @return subject_assaign
	 */
	public function update(SubjectAssaign $subject_assaign, $params) {
		return $subject_assaign->forceFill($this->formatParams($params, $subject_assaign->id))->save();
	}

	/**
	 * Delete Class.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(SubjectAssaign $subject_assaign) {
		return $subject_assaign->delete();
	}

	/**
	 * Delete multiple banks.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->subject_assaign->whereIn('id', $ids)->delete();
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
	public function preRequisite()
	{
		$subject = $this->subject->listAll();
		$class = $this->class->listAll();
		$list = getVar('list');
		$category = generateTranslatedSelectOption(isset($list['category']) ? $list['category'] : []);
		return compact('subject', 'class', 'category');

	}

}
