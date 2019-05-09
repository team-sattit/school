<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Model\Employee\Employee;
use App\Repositories\Employee\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class EmployeeController extends Controller {

	protected $request;
	protected $model;
	protected $repo;
	protected $view;
	protected $lang;

	public function __construct(
		Request $request,
		Employee $model,
		EmployeeRepository $repo
	) {
		$this->request = $request;
		$this->model = $model;
		$this->repo = $repo;
		$this->view = 'admin.employee.';
		$this->lang = 'employee.';
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$this->authorize('view', $this->repo->model());
		if ($this->request->ajax()) {
			return view('admin.error');
		}
		return view($this->view . 'index');
	}

	public function datatable() {
		$this->authorize('view', $this->repo->model());
		if ($this->request->ajax()) {
			return $this->repo->datatable();
		} else {
			return abort(404);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$this->authorize('create', $this->repo->model());
		return view($this->view . 'form', $this->repo->getPreRequisite(), $this->repo->getBasicPreRequisite());

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(EmployeeRequest $request) {
		//dd($this->request->all());
		$this->authorize('create', $this->repo->model());
		if ($this->request->ajax()) {
			$employee = $this->repo->create($this->request->all());
			return $this->success(['message' => trans($this->lang . 'added'), 'goto' => route($this->repo->route() . 'show', $employee->uuid)]);
		} else {
			return abort(404);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($uuid) {
		$this->authorize('view', $this->repo->model());
		$employee = $this->repo->findByUuidOrFail($uuid);

		$this->repo->isAccessible($employee);
		return view($this->view . 'show', compact('employee'), $this->repo->getPreRequisite());
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($uuid) {
		$field = $this->request->field;
		$this->authorize('update', $this->repo->model());
		if ($this->request->ajax() && $field) {
			$model = $this->repo->findByUuidOrFail($uuid);
			if (View::exists($this->view . $field)) {
				return view($this->view . $field, $this->repo->getPreRequisite(), $this->repo->getBasicPreRequisite())->with(['model' => $model]);
			} else {
				return '<div class="alert alert-danger">' . trans($this->lang . 'view_not_found') . '</div>';
			}
		} else {
			return abort(404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(EmployeeRequest $request, $uuid) {
		$this->authorize('update', $this->repo->model());
		if ($this->request->ajax()) {
			$employee = $this->repo->findByUuidOrFail($uuid);
			$updated_employee = $this->repo->update($employee, $this->request->all());
			return $this->success(['message' => trans($this->lang . 'updated'), 'goto' => $this->repo->route() . 'show']);
		} else {
			return abort(404);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$this->authorize('delete', $this->repo->model());
		if ($this->request->ajax()) {
			$department = $this->repo->deletable($id);
			$this->repo->delete($department);
			return $this->success(['message' => trans($this->lang . 'deleted')]);
		} else {
			return abort(404);
		}
	}

	/**
	 * Change Status the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function status($id) {
		$this->authorize('status', $this->repo->model());
		if ($this->request->ajax()) {
			$this->repo->updateStatus($id);
			return $this->success(['message' => trans($this->lang . 'status_change')]);
		} else {
			return abort(404);
		}
	}

	/**
	 * Get field from ajax Request.
	 *
	 * @param  int  $field
	 * @return \Illuminate\Http\Response
	 */
	public function get_field($field) {
		if ($this->request->ajax()) {
			if (View::exists($this->view . $field)) {
				return view($this->view . $field);
			}
		} else {
			return abort(404);
		}
	}
}
