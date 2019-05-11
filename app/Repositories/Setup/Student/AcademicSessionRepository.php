<?php
namespace App\Repositories\Setup\Student;

use App\Model\Setup\Student\AcademicSession;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class AcademicSessionRepository {
	protected $academic_session;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		AcademicSession $academic_session
	) {
		$this->academic_session = $academic_session;
	}
	public function model() {
		return AcademicSession::class;
	}
	private function route() {
		return 'setup.student.academic-session.';
	}
	private function permission() {
		return '-academic_session';
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
	 * @return AcademicSession query
	 */
	public function getQuery() {
		return $this->academic_session;
	}

	/**
	 * Count AcademicSession
	 *
	 * @return integer
	 */
	public function count() {
		return $this->academic_session->count();
	}

	/**
	 * List all AcademicSession by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->academic_session->where('status', 1)->pluck('name', 'id')->prepend(trans('select.academic_session'), '');
	}

	/**
	 * List all AcademicSession by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->academic_session->all(['name', 'id']);
	}

	/**
	 * List all AcademicSession by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->academic_session->all()->pluck('id')->all();
	}

	/**
	 * Get all AcademicSession
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->academic_session->all();
	}

	/**
	 * Find academic_session with given id.
	 *
	 * @param integer $id
	 * @return AcademicSession
	 */
	public function find($id) {
		return $this->academic_session->find($id);
	}

	/**
	 * Find academic_session with given id or throw an error.
	 *
	 * @param integer $id
	 * @return AcademicSession
	 */
	public function findOrFail($id) {
		$academic_session = $this->academic_session->find($id);

		if (!$academic_session) {
			throw ValidationException::withMessages(['message' => trans('misc.could_not_find_academic_session')]);
		}

		return $academic_session;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return AcademicSession
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->academic_session->orderBy($sort_by, $order);
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
	 * @return AcademicSession
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new bank.
	 *
	 * @param array $params
	 * @return AcademicSession
	 */
	public function create($params) {
		return $this->academic_session->forceCreate($this->formatParams($params));
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
	 * Update given academic_session.
	 *
	 * @param AcademicSession $academic_session
	 * @param array $params
	 *
	 * @return AcademicSession
	 */
	public function update(AcademicSession $academic_session, $params) {
		return $academic_session->forceFill($this->formatParams($params, $academic_session->id))->save();
	}

	/**
	 * Delete AcademicSession.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(AcademicSession $academic_session) {
		return $academic_session->delete();
	}

	/**
	 * Delete multiple banks.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->academic_session->whereIn('id', $ids)->delete();
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
