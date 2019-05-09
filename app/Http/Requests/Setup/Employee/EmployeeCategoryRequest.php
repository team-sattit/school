<?php

namespace App\Http\Requests\Setup\Employee;

use App\Model\Setup\Employee\EmployeeCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeCategoryRequest extends FormRequest {
	protected $model;

	public function __construct(EmployeeCategory $model) {
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
				Rule::unique('employee_categories')->ignore($this->category),
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
			'name' => trans('setup.employee.category.form.name_label'),
			'description' => trans('setup.employee.category.form.code_label'),
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
