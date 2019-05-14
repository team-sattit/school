<?php

namespace App\Http\Requests\Setup\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectAssaignRequest extends FormRequest {

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
			'class_id' => [
				'required',
			],
			'subject_id' => [
				'required',
			],
			'category' => [
				'required',
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
			'class_id' => trans('setup.student.subject_assaign.form.class_label'),
			'subject_id' => trans('setup.student.subject_assaign.form.subject_label'),
			'category' => trans('setup.student.subject_assaign.form.category_label'),
			
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
