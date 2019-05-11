<?php

namespace App\Http\Requests\Setup\Student;

use App\Model\Setup\Student\AcademicSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicSessionRequest extends FormRequest {
	protected $model;

	public function __construct(AcademicSession $model) {
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
				Rule::unique('academic_sessions')->ignore($this->academic_session),
			],
			'description' => [
				'sometimes', 'nullable', 'string', 'max:500',
			],
			'start_date' => [
				'required', 'date'
			],
			'end_date' => [
				'required', 'date','after:start_date'
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
			'name' => trans('setup.student.academic_session.form.name_label'),
			'description' => trans('setup.student.academic_session.form.description_label'),
			'start_date' => trans('setup.student.academic_session.form.start_date_label'),
			'end_date' => trans('setup.student.academic_session.form.end_date_label'),
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
