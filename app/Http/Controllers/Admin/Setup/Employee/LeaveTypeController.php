<?php

namespace App\Http\Controllers\Admin\Setup\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\Employee\LeaveTypeRequest;
use App\Model\Setup\Employee\LeaveType;
use App\Repositories\Setup\Employee\LeaveTypeRepository;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller {

	protected $request;
	protected $model;
	protected $repo;
	protected $view;
	protected $lang;

	public function __construct(
		Request $request,
		LeaveType $model,
		LeaveTypeRepository $repo
	) {
		$this->request = $request;
		$this->model = $model;
		$this->repo = $repo;
		$this->view = 'admin.setup.employee.leave_type.';
		$this->lang = 'setup.employee.leave_type.';
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
		if ($this->request->ajax()) {
			return view($this->view . 'form');
		} else {
			return abort(404);
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(LeaveTypeRequest $request) {
		$this->authorize('create', $this->repo->model());
		if ($this->request->ajax()) {
			$department = $this->repo->create($this->request->all());
			return $this->success(['message' => trans($this->lang . 'added')]);
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
	public function show($id) {
		$this->authorize('view', $this->repo->model());
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$this->authorize('update', $this->repo->model());
		if ($this->request->ajax()) {
			$model = $this->repo->findOrFail($id);
			return view($this->view . 'form', compact('model'));
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
	public function update(LeaveTypeRequest $request, $id) {
		$this->authorize('update', $this->repo->model());
		if ($this->request->ajax()) {
			$department = $this->repo->findOrFail($id);
			$department = $this->repo->update($department, $this->request->all());
			return $this->success(['message' => trans($this->lang . 'updated')]);
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
}
