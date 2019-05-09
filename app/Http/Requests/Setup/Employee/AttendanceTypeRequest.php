<?php

namespace App\Http\Requests\Setup\Employee;

use App\Model\Setup\Employee\AttendanceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendanceTypeRequest extends FormRequest {
	protected $model;

	public function __construct(AttendanceType $model) {
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
				Rule::unique('employee_attendance_types')->ignore($this->attendance_type),
			],
			'alias' => [
				'required', 'string', 'max:191',
				Rule::unique('employee_attendance_types')->ignore($this->attendance_type),
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
			'name' => trans('setup.employee.attendance_type.form.name_label'),
			'alias' => trans('setup.employee.attendance_type.form.alias_label'),
			'description' => trans('setup.employee.attendance_type.form.code_label'),
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
