<?php

namespace App\Repositories\Setup\Employee;

use App\Model\Setup\Employee\EmployeeDocumentType;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

//use Your Model

/**
 * Class NationalityRepository.
 */
class EmployeeDocumentTypeRepository {
	protected $employee_document_type;
	protected $route;
	protected $permission;

	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		EmployeeDocumentType $employee_document_type
	) {
		$this->employee_document_type = $employee_document_type;
		$this->route = 'setup.employee.employee_document_type.';
		$this->permission = '-employee_document_type';
	}
	public function model() {
		return EmployeeDocumentType::class;
	}

	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong>';
		})->addColumn('description', function ($model) {
			return $model->description;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			$route = $this->route;
			$permission = $this->permission;
			return view('admin.setup.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'employees', 'description'])->make(true);
	}

	/**
	 * Get employee document type query
	 *
	 * @return EmployeeDocumentType query
	 */
	public function getQuery() {
		return $this->employee_document_type;
	}

	/**
	 * Count employee document type
	 *
	 * @return integer
	 */
	public function count() {
		return $this->employee_document_type->count();
	}

	/**
	 * List all employee document types by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->employee_document_type->where('status', 1)->pluck('name', 'id')->prepend(trans('select.document_type'), '');
	}

	/**
	 * List all employee document types by name & id for select option
	 *
	 * @return array
	 */

	public function selectAll() {
		return $this->employee_document_type->all(['name', 'id']);
	}

	/**
	 * List all employee document types by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->employee_document_type->all()->pluck('id')->all();
	}

	/**
	 * Get all employee document types
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->employee_document_type->all();
	}

	/**
	 * Find employee document type with given id.
	 *
	 * @param integer $id
	 * @return EmployeeDocumentType
	 */
	public function find($id) {
		return $this->employee_document_type->find($id);
	}

	/**
	 * Find employee document type with given id or throw an error.
	 *
	 * @param integer $id
	 * @return EmployeeDocumentType
	 */
	public function findOrFail($id) {
		$employee_document_type = $this->employee_document_type->find($id);

		if (!$employee_document_type) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.employee_document_type.not_find')]);
		}

		return $employee_document_type;
	}

	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return EmployeeDocumentType
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');

		return $this->employee_document_type->orderBy($sort_by, $order);
	}

	/**
	 * Paginate all employee document types using given params.
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
	 * @return EmployeeDocumentType
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}

	/**
	 * Create a new employee document type.
	 *
	 * @param array $params
	 * @return EmployeeDocumentType
	 */
	public function create($params) {
		return $this->employee_document_type->forceCreate($this->formatParams($params));
	}

	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $employee_document_type_id
	 * @return array
	 */
	private function formatParams($params, $employee_document_type_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description'),
			'status' => gbv($params, 'status'),
		];
		$formatted['options'] = [];

		return $formatted;
	}

	/**
	 * Update given employee document type.
	 *
	 * @param EmployeeDocumentType $employee_document_type
	 * @param array $params
	 *
	 * @return EmployeeDocumentType
	 */
	public function update(EmployeeDocumentType $employee_document_type, $params) {
		return $employee_document_type->forceFill($this->formatParams($params, $employee_document_type->id))->save();
	}

	/**
	 * Find employee document type & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return EmployeeDocumentType
	 */
	public function deletable($id) {
		$employee_document_type = $this->findOrFail($id);

		if ($employee_document_type->employeeDocuments()->count()) {
			throw ValidationException::withMessages(['message' => trans('setup.employee.employee_document_type.associated_with_document')]);
		}

		return $employee_document_type;
	}

	/**
	 * Delete employee document type.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(EmployeeDocumentType $employee_document_type) {
		return $employee_document_type->delete();
	}

	/**
	 * Delete multiple employee document types.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->employee_document_type->whereIn('id', $ids)->delete();
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
