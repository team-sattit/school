<?php

namespace App\Http\Requests\Setup\Employee;

use App\Model\Setup\Employee\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest {
	protected $model;

	public function __construct(Department $model) {
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
				Rule::unique('departments')->ignore($this->department),
			],
			'code' => [
				'required', 'string', 'max:50',
				Rule::unique('departments')->ignore($this->department),
			],
			'description' => [
				'sometimes', 'nullable', 'string', 'max:500',
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
			'name' => trans('setup.employee.department.form.name_label'),
			'code' => trans('setup.employee.department.form.code_label'),
			'description' => trans('setup.employee.department.form.description_label'),
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
