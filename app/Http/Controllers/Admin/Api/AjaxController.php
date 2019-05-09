<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Setup\Employee\EmployeeDocumentTypeRepository;
use App\Repositories\Setup\Finance\BankRepository;
use Illuminate\Http\Request;

class AjaxController extends Controller {
	protected $request;
	protected $document_type;
	protected $bank;
	public function __construct(
		Request $request,
		EmployeeDocumentTypeRepository $document_type,
		BankRepository $bank
	) {
		$this->request = $request;
		$this->document_type = $document_type;
		$this->bank = $bank;
	}
	public function academic_field() {
		$row = $this->request->row;
		$lang = $this->request->lang;
		return view('admin.ajax.academic_field', compact('row', 'lang'));
	}

	public function account_field() {
		$row = $this->request->row;
		$lang = $this->request->lang;
		$banks = $this->bank->listAll();
		return view('admin.ajax.account_field', compact('row', 'lang', 'banks'));
	}

	public function document_field() {
		$row = $this->request->row;
		$lang = $this->request->lang;
		$document_types = $this->document_type->listAll();
		return view('admin.ajax.document_field', compact('row', 'lang', 'document_types'));
	}
}
