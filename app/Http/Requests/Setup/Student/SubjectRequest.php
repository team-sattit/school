<?php

namespace App\Http\Requests\Setup\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest {

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
				Rule::unique('classes')->ignore($this->class),
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
			'name' => trans('setup.student.subject.form.name_label'),
			'description' => trans('setup.student.subject.form.description_label'),
			
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
