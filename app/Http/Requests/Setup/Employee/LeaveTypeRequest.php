<?php

namespace App\Http\Requests\Setup\Employee;

use App\Model\Setup\Employee\LeaveType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveTypeRequest extends FormRequest {
	protected $model;

	public function __construct(LeaveType $model) {
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
				Rule::unique('employee_leave_types')->ignore($this->leave_type),
			],
			'alias' => [
				'required', 'string', 'max:191',
				Rule::unique('employee_leave_types')->ignore($this->leave_type),
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
			'name' => trans('setup.employee.leave_type.form.name_label'),
			'alias' => trans('setup.employee.leave_type.form.alias_label'),
			'description' => trans('setup.employee.leave_type.form.code_label'),
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
