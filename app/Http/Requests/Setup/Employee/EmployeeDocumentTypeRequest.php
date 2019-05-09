<?php

namespace App\Http\Requests\Setup\Employee;

use App\Model\Setup\Employee\EmployeeDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeDocumentTypeRequest extends FormRequest {
	protected $model;

	public function __construct(EmployeeDocumentType $model) {
		$this->model = $model;
	}
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		return [
			'name' => [
				'required', 'string', 'max:191',
				Rule::unique('employee_document_types')->ignore($this->employee_document_type),
			],
			'description' => [
				'sometimes', 'nullable', 'string', 'max:300',
			],
		];
	}

	/**
	 * Translate fields with user friendly name.
	 *
	 * @return array
	 */
	public function attributes() {
		return [
			'name' => trans('setup.employee.employee_document_type.form.name_label'),
			'description' => trans('setup.employee.employee_document_type.form.description_label'),
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages() {
		return [
		];
	}
}
