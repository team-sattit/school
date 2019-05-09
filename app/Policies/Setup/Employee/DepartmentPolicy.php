<?php

namespace App\Policies\Setup\Employee;

use App\Model\Setup\Department;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy {
	use HandlesAuthorization;
	protected $trt = '-employee_department';
	/**
	 * Determine whether the user can view the department.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Department  $department
	 * @return mixed
	 */
	public function view(User $user) {
		return $user->can('view' . $this->trt) || $user->can('create' . $this->trt);
	}

	/**
	 * Determine whether the user can create departments.
	 *
	 * @param  \App\User  $user
	 * @return mixed
	 */
	public function create(User $user) {
		return $user->can('create' . $this->trt);
	}

	/**
	 * Determine whether the user can update the department.
	 *
	 * @param  \App\User  $user
	 * @param  \App\Department  $department
	 * @return mixed
	 */
	public function update(User $user) {
		return $user->can('update' . $this->trt);
	}

	public function delete(User $user) {
		return $user->can('delete' . $this->trt);
	}

	public function status(User $user) {
		return $user->can('change-status' . $this->trt);
	}

}
