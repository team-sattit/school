<?php

function document_name($doc, $splite = '/') {
	$document_array = explode($splite, $doc);
	$length = count($document_array);
	return $document_array[$length - 1];
}

function document_icon($doc, $splite = '.') {
	$icon = '<i class="icon-move-down mr-2"></i>';
	$document_array = explode($splite, $doc);
	$length = count($document_array);
	$doc = $document_array[$length - 1];
	if ($doc == 'pdf') {
		$icon = '<i class="icon-file-pdf mr-2"></i>';
	} elseif ($doc == 'doc' || $doc == 'docx') {
		$icon = '<i class="icon-file-word mr-2"></i>';
	} elseif ($doc == 'xls' || $doc == 'xlsx' || $doc == 'csv') {
		$icon = '<i class="icon-file-excel mr-2"></i>';
	} elseif ($doc == 'jpg' || $doc == 'jpeg' || $doc == 'png' || $doc == 'gif') {
		$icon = '<i class="icon-images2 mr-2"></i>';
	}

	return $icon;

}

function format_number($number, $para = 2) {
	return number_format($number, $para);
}

function gv($params, $key, $default = null) {
	return (isset($params[$key]) && $params[$key]) ? $params[$key] : $default;
}
function isInteger($input) {
	return (ctype_digit(strval($input)));
}

function upload_image($image, $name = '', $folder = '') {
	if ($image) {
		$extension = $image->getClientOriginalExtension();
		$name = str_slug($name);
		$current_date_time = \Carbon\Carbon::now()->toDateString();
		$imagename = $name . '-' . $current_date_time . '-' . uniqid() . '.' . $extension;
		$path = $folder . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
		$fullpath = $path . $imagename;

		if (!Storage::disk('public')->exists($path)) {
			Storage::disk('public')->makeDirectory($path);
		}
		$file = Image::make($image)->save();
		Storage::disk('public')->put($fullpath, $file);
		return $fullpath;
	} else {
		return Null;
	}
}
function upload_file($file, $name = '', $folder = '') {
	if ($file) {
		$extension = $file->getClientOriginalExtension();
		$name = str_slug($name);
		$current_date_time = \Carbon\Carbon::now()->toDateString();
		$filename = $name . '-' . $current_date_time . '-' . uniqid() . '.' . $extension;
		$path = $folder . DIRECTORY_SEPARATOR . date('FY') . DIRECTORY_SEPARATOR;
		$fullpath = $path . $filename;

		if (!Storage::disk('public')->exists($path)) {
			Storage::disk('public')->makeDirectory($path);
		}
		$file->storeAs($path, $filename);
		return $fullpath;
	} else {
		return;
	}
}
function remove_image($image) {
	Storage::disk('public')->delete($image);
	return;
}

if (!function_exists('optional')) {
	/**
	 * Provide access to optional objects.
	 *
	 * @param  mixed  $value
	 * @param  callable|null  $callback
	 * @return mixed
	 */
	function optional($value = null, callable $callback = null) {
		if (is_null($callback)) {
			return new Optional($value);
		} elseif (!is_null($value)) {
			return $callback($value);
		}
	}
}

function gbv($params, $key) {
	return (isset($params[$key]) && $params[$key]) ? 1 : 0;
}

function getRemoteIPAddress() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : null;
}

function getClientIp() {
	$ips = getRemoteIPAddress();
	$ips = explode(',', $ips);
	return !empty($ips[0]) ? $ips[0] : \Request::getClientIp();
}

function generateSelectOption($data) {
	$options = array();
	foreach ($data as $key => $value) {
		$options[] = ['name' => $value, 'id' => $key];
	}
	return $options;
}

function getEmployeeDesignation($employee, $date = null) {
	$date = ($date) ?: date('Y-m-d');

	if (!$employee) {
		return null;
	}

	if (!$employee->relationLoaded('employeeDesignations')) {
		$employee->load('employeeDesignations');
	}

	return $employee->employeeDesignations->sortByDesc('date_effective')->firstWhere('date_effective', '<=', $date);
}

function getEmployeeDesignationId($employee, $date = null) {
	$designation = getEmployeeDesignation($employee, $date);

	return $designation ? $designation->designation_id : null;
}

function getEmployeeDesignationName($employee, $date = null) {
	$designation = getEmployeeDesignation($employee, $date);

	return $designation ? $designation->Designation->name . ' (' . $designation->Designation->EmployeeCategory->name . ')' : null;
}

function getChilds($array, $currentParent = 1, $level = 1, $child = array(), $currLevel = 0, $prevLevel = -1) {
	foreach ($array as $categoryId => $category) {
		if ($currentParent === $category['parent_id']) {
			if ($currLevel > $prevLevel) {
			}
			if ($currLevel === $prevLevel) {
			}
			$child[] = $categoryId;
			if ($currLevel > $prevLevel) {
				$prevLevel = $currLevel;
			}
			$currLevel++;
			if ($level) {
				$child = getChilds($array, $categoryId, $level, $child, $currLevel, $prevLevel);
			}
			$currLevel--;
		}
	}
	if ($currLevel === $prevLevel) {
	}
	return $child;
}

function getVar($list) {
	$file = resource_path('var/' . $list . '.json');
	return (\File::exists($file)) ? json_decode(file_get_contents($file), true) : [];
}

function generateTranslatedSelectOption($data) {
	$options = array();
	foreach ($data as $key => $value) {
		$options[$value] = trans('list.' . $value);
	}
	return $options;
}

function trt_sprintf($num, $digit = 3) {
	return sprintf('%0' . $digit . 'd', $num);
}

function getEmployeeTerm($employee, $date = null) {
	$date = ($date) ?: date('Y-m-d');

	return $employee->EmployeeTerms->sortByDesc('date_of_joining')->filter(function ($term) use ($date) {
		return ($term->date_of_joining <= $date && (!$term->date_of_leaving || $term->date_of_leaving >= $date));
	})->first();
}

function isActiveEmployee($employee, $date = null) {
	return getEmployeeTerm($employee, $date) ? true : false;
}