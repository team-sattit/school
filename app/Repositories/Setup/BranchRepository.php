<?php
namespace App\Repositories\Setup;
use App\Model\Setup\Branch;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class BranchRepository {
	protected $branch;
	/**
	 * Instantiate a new instance.
	 *
	 * @return void
	 */
	public function __construct(
		Branch $branch
	) {
		$this->branch = $branch;
	}
	public function model() {
		return Branch::class;
	}
	private function route() {
		return 'setup.branch.';
	}
	private function permission() {
		return '-branch';
	}
	public function datatable() {
		$models = $this->getAll();
		return Datatables::of($models)
			->addIndexColumn()->addColumn('name', function ($model) {
			return '<strong>' . $model->name . '</strong> (' . $model->branch_no . ')';
		})->addColumn('contact', function ($model) {
			$contact = '';
			$contact .= 'Address: ' . $model->address . '<br>';
			$contact .= 'Email: ' . $model->email . '<br>';
			$contact .= 'Mobile: ' . $model->mobile_no . '<br>';
			if ($model->phone) {
				$contact .= 'Mobile: ' . $model->phone_no . '<br>';
			}
			return $contact;
		})->editColumn('description', function ($model) {
			return $model->description;
		})->editColumn('info', function ($model) {
			$info = '';
			$info .= 'Teacher: <span class="badge badge-success">20</span> <br>';
			$info .= 'Student: <span class="badge badge-success">30</span>';
			return $info;
		})->addColumn('status', function ($model) {
			return view('admin.setup.status', compact('model'));
		})->addColumn('action', function ($model) {
			$route = $this->route();
			$permission = $this->permission();
			return view('admin.setup.action', compact('model', 'route', 'permission'));
		})->removeColumn('created_at')->removeColumn('updated_at')
			->rawColumns(['action', 'status', 'name', 'description', 'contact', 'info'])->make(true);
	}
	/**
	 * Get branch query
	 *
	 * @return Branch query
	 */
	public function getQuery() {
		return $this->branch;
	}
	/**
	 * Count branch
	 *
	 * @return integer
	 */
	public function count() {
		return $this->branch->count();
	}
	/**
	 * List all branch by name & id
	 *
	 * @return array
	 */
	public function listAll() {
		return $this->branch->all()->pluck('name', 'id')->prepend(trans('select.branch'), '');
	}
	/**
	 * List all branch by name & id for select option
	 *
	 * @return array
	 */
	public function selectAll() {
		return $this->branch->all(['name', 'id']);
	}
	/**
	 * List all branch by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->branch->all()->pluck('id')->all();
	}
	/**
	 * Get all branch
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->branch->all();
	}
	/**
	 * Find branch with given id.
	 *
	 * @param integer $id
	 * @return Branch
	 */
	public function find($id) {
		return $this->branch->find($id);
	}
	/**
	 * Find branch with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Branch
	 */
	public function findOrFail($id, $field = 'message') {
		$branch = $this->branch->find($id);
		if (!$branch) {
			throw ValidationException::withMessages([$field => trans('setup.branch.not_find')]);
		}
		return $branch;
	}
	/**
	 * Get all filtered data
	 *
	 * @param array $params
	 * @return Branch
	 */
	public function getData($params) {
		$sort_by = gv($params, 'sort_by', 'name');
		$order = gv($params, 'order', 'asc');
		return $this->branch->orderBy($sort_by, $order);
	}
	/**
	 * Paginate all branch using given params.
	 *
	 * @param array $params
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function paginate($params) {
		$page_length = gv($params, 'page_length', config('config.page_length'));
		return $this->getData($params)->paginate($page_length);
	}
	/**
	 * Get all filtered data for printing
	 *
	 * @param array $params
	 * @return Branch
	 */
	public function print($params) {
		return $this->getData($params)->get();
	}
	/**
	 * Create a new branch.
	 *
	 * @param array $params
	 * @return Branch
	 */
	public function create($params) {
		return $this->branch->forceCreate($this->formatParams($params));
	}
	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $branch_id
	 * @return array
	 */
	private function formatParams($params, $branch_id = null) {
		$name = gv($params, 'name');
		$branch_no = gv($params, 'branch_no');
		$logo_name = $name . '-' . $branch_no;
		$logo = gv($params, 'logo');
		$fav = gv($params, 'favicon');
		$logo_action = gv($params, 'logo_action');
		$fav_action = gv($params, 'fav_action');
		if ($branch_id) {
			$branch = $this->findOrFail($branch_id);
			if ($logo_action) {
				if ($logo_action == 'remove_logo') {
					remove_image($branch->logo);
					$upload_logo = Null;
				} elseif ($logo_action == 'update_logo') {
					remove_image($branch->logo);
					$upload_logo = upload_image($logo, $logo_name, 'branch');
				} elseif ($logo_action == 'upload_logo') {
					if ($logo) {
						$upload_logo = upload_image($logo, $logo_name, 'branch');
					} else {
						$upload_logo = $branch->logo;
					}
				}
			} else {
				$upload_logo = $branch->logo;
			}
			if ($fav_action) {
				if ($fav_action == 'remove_fav') {
					remove_image($branch->favicon);
					$upload_fav = Null;
				} elseif ($fav_action == 'update_fav') {
					remove_image($branch->logo);
					$upload_fav = upload_image($logo, $logo_name . '-fav', 'branch');
				} elseif ($fav_action == 'upload_fav') {
					if ($fav) {
						$upload_fav = upload_image($fav, $logo_name . '-fav', 'branch');
					} else {
						$upload_fav = $branch->favicon;
					}
				}
			} else {
				$upload_fav = $branch->favicon;
			}
		} else {
			$upload_fav = upload_image($fav, $logo_name . '-fav', 'branch');
			$upload_logo = upload_image($logo, $logo_name, 'branch');
		}
		$formatted = [
			'uuid' => Str::uuid(),
			'name' => $name,
			'branch_no' => $branch_no,
			'address' => gv($params, 'address'),
			'mobile_no' => gv($params, 'mobile_no'),
			'phone_no' => gv($params, 'phone_no'),
			'email' => gv($params, 'email'),
			'username' => gv($params, 'username'),
			'logo' => $upload_logo,
			'favicon' => $upload_fav,
			'status' => gbv($params, 'status'),
			'description' => gv($params, 'description'),
		];
		$formatted['options'] = [];
		return $formatted;
	}
	/**
	 * Update given branch.
	 *
	 * @param Branch $branch
	 * @param array $params
	 *
	 * @return Branch
	 */
	public function update(Branch $branch, $params) {
		return $branch->forceFill($this->formatParams($params, $branch->id))->save();
	}
	/**
	 * Find branch & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Branch
	 */
	public function deletable($id) {
		$branch = $this->findOrFail($id);
		// if ($branch->employeeDesignations()->count()) {
		// 	throw ValidationException::withMessages(['message' => trans('setup.branch.associated')]);
		// }
		return $branch;
	}
	/**
	 * Delete branch.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Branch $branch) {
		return $branch->delete();
	}
	/**
	 * Delete multiple branch.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		return $this->branch->whereIn('id', $ids)->delete();
	}
	public function updateStatus($id) {
		$model = $this->findOrFail($id);
		if ($model->status == 1) {
			$status = 0;
		} else {
			$status = 1;
		}
		return $model->update(['status' => $status]);
	}
}