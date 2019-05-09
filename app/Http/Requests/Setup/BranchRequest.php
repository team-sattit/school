<?php

namespace App\Http\Requests\Setup;

use App\Model\Setup\Branch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest {
	protected $model;

	public function __construct(Branch $model) {
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
		if ($this->method() === 'POST') {
			$rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
		} elseif ($this->method() === 'PATCH' or $this->method() === 'PUT') {
			$rules['password'] = ['sometimes', 'nullable', 'string', 'min:6', 'confirmed'];
		}

		return [
			'name' => [
				'required', 'string', 'max:191',
				Rule::unique('branches')->ignore($this->branch),
			],
			'name' => [
				'required', 'string', 'max:191',
			],
			'branch_no' => [
				'required', 'string', 'max:50',
				Rule::unique('branches')->ignore($this->branch),
			],
			'mobile_no' => [
				'required', 'string', 'size:11',
				Rule::unique('branches')->ignore($this->branch),
			],
			'phone_no' => [
				'sometimes', 'nullable', 'string', 'min:6', 'max:13',
				Rule::unique('branches')->ignore($this->branch),
			],
			'email' => [
				'required', 'email', 'max:50',
				Rule::unique('branches')->ignore($this->branch),
			],
			'username' => [
				'required', 'string', 'max:50',
				Rule::unique('branches')->ignore($this->branch),
			],
			'password' => $rules['password'],
			'logo' => [
				'sometimes', 'nullable', 'mimes:jpeg,bmp,png',
			],
			'favicon' => [
				'sometimes', 'nullable', 'mimes:jpeg,bmp,png',
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
			'name' => trans('setup.branch.form.name_label'),
			'address' => trans('setup.branch.form.address_label'),
			'branch_no' => trans('setup.branch.form.branch_no_label'),
			'mobile_no' => trans('setup.branch.form.mobile_no_label'),
			'phone_no' => trans('setup.branch.form.phone_no_label'),
			'email' => trans('setup.branch.form.email_label'),
			'username' => trans('setup.branch.form.username_label'),
			'password' => trans('setup.branch.form.password_label'),
			'logo' => trans('setup.branch.form.logo_label'),
			'favicon' => trans('setup.branch.form.favicon_label'),
			'description' => trans('setup.branch.form.description_label'),
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
