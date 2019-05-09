<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest {
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
			return [
				'branch_id' => 'required|min:1|integer',
				'department_id' => 'required|min:1|integer',
				'designation_id' => 'required|min:1|integer',
				'code' => 'required|min:1|numeric',
				'name' => 'required|min:2|string',
				'date_of_birth' => 'required|date',
				'marital_status' => 'required',
				'joining_date' => 'required|date|after:date_of_birth',
				'anniversary_date' => 'required_if:marital_status,married|nullable|date',
				'gender' => 'required',
				'mobile_no' => 'required|unique:employees,mobile_no',
				'phone_no' => 'sometimes|nullable|size:11',
				'user_email' => [
					'required', 'email', 'max:191',
				],
				'alternate_email' => 'sometimes|nullable|email',
				'photo' => 'required|mimes:jpeg,bmp,png,jpg',
				'nid_no' => 'required|string|between:10,18|unique:employees,nid_no',
				'birth_certificate_no' => 'sometimes|nullable|string|between:10,18|unique:employees,birth_certificate_no',
				'basic_salary' => 'required|numeric|min:0',
				'house_rent' => 'required|numeric|min:0',
				'medical_allowance' => 'required|numeric|min:0',
				'transport_allowance' => 'required|numeric|min:0',
				'insurance' => 'required|numeric|min:0',
				'commission' => 'required|numeric|min:0',
				'extra' => 'required|numeric|min:0',
				'overtime' => 'required|numeric|min:0',
				'father_name' => 'required',
				'mother_name' => 'required',
				'spouse_name' => 'required_if:marital_status,married',
				'emergency_contact_name' => 'sometimes|nullable',
				'emergency_contact' => 'required_with:emergency_contact_name',
				'present_house' => 'required|string',
				'present_road' => 'required|string',
				'present_village' => 'required|string',
				'present_post' => 'required|string',
				'present_upozila' => 'required|string',
				'present_district' => 'required|string',
				'present_postcode' => 'required|string',
				'permanent_house' => 'required_without:same_as_present',
				'permanent_road' => 'required_without:same_as_present',
				'permanent_village' => 'required_without:same_as_present',
				'permanent_post' => 'required_without:same_as_present',
				'permanent_upozila' => 'required_without:same_as_present',
				'permanent_district' => 'required_without:same_as_present',
				'permanent_postcode' => 'required_without:same_as_present',

				'role' => 'required_with:login_enable|nullable|integer',
				'email' => 'required_with:login_enable|nullable|email|unique:users,email',
				'username' => 'required_with:login_enable|nullable|unique:users,username',
				'password' => 'required_with:login_enable|nullable|string|min:6',
			];
		} elseif ($this->method() === 'PATCH' or $this->method() === 'PUT') {
			if (Input::get('field') == 'upload_photo') {
				return [
					'photo' => 'required|mimes:jpeg,bmp,png,jpg',
				];
			} elseif (Input::get('field') == 'basic_info') {
				return [
					'name' => 'required|min:2|string',
					'date_of_birth' => 'required|date',
					'marital_status' => 'required',
					'anniversary_date' => 'required_if:marital_status,married|nullable|date',
					'gender' => 'required',
					'mobile_no' => 'required|unique:employees,mobile_no,' . $this->employee . ',uuid',
					'phone_no' => 'sometimes|nullable|size:11',
					'user_email' => 'required|unique:employees,email,' . $this->employee . ',uuid',
					'alternate_email' => 'sometimes|nullable|email',
					'nid_no' => 'required|string|between:10,18|unique:employees,nid_no,' . $this->employee . ',uuid',
					'birth_certificate_no' => 'sometimes|nullable|string|between:10,18|unique:employees,birth_certificate_no,' . $this->employee . ',uuid',
					'father_name' => 'required',
					'mother_name' => 'required',
					'spouse_name' => 'required_if:marital_status,married',
					'emergency_contact_name' => 'sometimes|nullable',
					'emergency_contact' => 'required_with:emergency_contact_name',
					'present_house' => 'required|string',
					'present_road' => 'required|string',
					'present_village' => 'required|string',
					'present_post' => 'required|string',
					'present_upozila' => 'required|string',
					'present_district' => 'required|string',
					'present_postcode' => 'required|string',
					'permanent_house' => 'required_without:same_as_present',
					'permanent_road' => 'required_without:same_as_present',
					'permanent_village' => 'required_without:same_as_present',
					'permanent_post' => 'required_without:same_as_present',
					'permanent_upozila' => 'required_without:same_as_present',
					'permanent_district' => 'required_without:same_as_present',
					'permanent_postcode' => 'required_without:same_as_present',
				];
			} else {
				return [];
			}
		}
	}

	/**
	 * Translate fields with user friendly name.
	 *
	 * @return array
	 */
	public function attributes() {
		return [
			'branch_id' => trans('employee.form.branch_label'),
			'code' => trans('employee.form.code_label'),
			'name' => trans('employee.form.name_label'),
			'date_of_birth' => trans('employee.form.date_of_birth_label'),
			'marital_status' => trans('employee.form.marital_status_label'),
			'joining_date' => trans('employee.form.joining_date_label'),
			'anniversary_date' => trans('employee.form.aniversary_date_label'),

			'basic_salary' => trans('employee.form.basic_salary_label'),
			'house_rent' => trans('employee.form.house_rent_label'),
			'medical_allowance' => trans('employee.form.medical_allowance_label'),
			'transport_allowance' => trans('employee.form.transport_allowance_label'),
			'insurance' => trans('employee.form.insurance_label'),
			'commission' => trans('employee.form.commission_label'),
			'extra' => trans('employee.form.extra_label'),
			'overtime' => trans('employee.form.overtime_label'),

			'gender' => trans('employee.form.gender_label'),
			'mobile_no' => trans('employee.form.mobile_no_label'),
			'phone_no' => trans('employee.form.phone_no_label'),
			'user_email' => trans('employee.form.user_email_label'),
			'alternate_email' => trans('employee.form.alternate_email_label'),
			'photo' => trans('employee.form.photo_label'),
			'nid_no' => trans('employee.form.nid_no_label'),
			'birth_certificate_no' => trans('employee.form.birth_certificate_no_label'),
			'father_name' => trans('employee.form.father_name_label'),
			'mother_name' => trans('employee.form.mother_name_label'),
			'spouse_name' => trans('employee.form.spouse_name_label'),
			'emergency_contact_name' => trans('employee.form.emergency_contact_name_label'),
			'emergency_contact' => trans('employee.form.emergency_contact_label'),
			'present_house' => trans('employee.form.present.house_label'),
			'present_road' => trans('employee.form.present.road_label'),
			'present_village' => trans('employee.form.present.village_label'),
			'present_post' => trans('employee.form.present.post_label'),
			'present_upozila' => trans('employee.form.present.upozila_label'),
			'present_district' => trans('employee.form.present.district_label'),
			'present_postcode' => trans('employee.form.present.postcode_label'),
			'same_as_present' => trans('employee.form.permanent.same'),
			'permanent_house' => trans('employee.form.permanent.house_label'),
			'permanent_road' => trans('employee.form.permanent.road_label'),
			'permanent_village' => trans('employee.form.permanent.village_label'),
			'permanent_post' => trans('employee.form.permanent.post_label'),
			'permanent_upozila' => trans('employee.form.permanent.upozila_label'),
			'permanent_district' => trans('employee.form.permanent.district_label'),
			'permanent_postcode' => trans('employee.form.permanent.postcode_label'),
			'role' => trans('employee.form.role_label'),
			'email' => trans('employee.form.email_label'),
			'username' => trans('employee.form.username_label'),
			'password' => trans('employee.form.password_label'),
			'password_confirmation' => trans('employee.form.password_confirmation_label'),
			'basic_salary' => trans('employee.form.basic_salary_label'),
			'house_rent' => trans('employee.form.house_rent_label'),
			'medical_allowance' => trans('employee.form.medical_allowance_label'),
			'transport_allowance' => trans('employee.form.transport_allowance_label'),
			'insurance' => trans('employee.form.insurance_label'),
			'commission' => trans('employee.form.commission_label'),
			'extra' => trans('employee.form.extra_label'),
			'overtime' => trans('employee.form.overtime_label'),
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
