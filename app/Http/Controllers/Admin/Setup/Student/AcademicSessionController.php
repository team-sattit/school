<?php

namespace App\Http\Controllers\Admin\Setup\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\Student\AcademicSessionRequest;
use App\Model\Setup\Student\AcademicSession;
use App\Repositories\Setup\Student\AcademicSessionRepository;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller {

	protected $request;
	protected $model;
	protected $repo;
	protected $view;
	protected $lang;
	public function __construct(
		Request $request,
		AcademicSession $model,
		AcademicSessionRepository $repo
	) {
		$this->request = $request;
		$this->model = $model;
		$this->repo = $repo;
		$this->view = 'admin.setup.student.academic_session.';
		$this->lang = 'setup.student.academic_session.';
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
	public function store(AcademicSessionRequest $request) {
		$this->authorize('create', $this->repo->model());
		if ($this->request->ajax()) {
			$naionality = $this->repo->create($this->request->all());
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
	public function update(AcademicSessionRequest $request, $id) {
		$this->authorize('update', $this->repo->model());
		if ($this->request->ajax()) {
			$nationality = $this->repo->findOrFail($id);
			$nationality = $this->repo->update($nationality, $this->request->all());
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
			$nationality = $this->repo->findOrFail($id);
			$this->repo->delete($nationality);
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
