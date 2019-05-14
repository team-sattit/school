<?php
return [
	'branch' => [
		'title' => 'Branch Setup',
		'create' => 'New Branch',
		'update' => 'Update Branch',
		'table' => [
			'id' => '#',
			'name' => 'Name',
			'contact' => 'Contact',
			'info' => 'Info',
			'description' => 'Description',
			'status' => 'Status',
			'action' => 'Action',
		],
		'form' => [
			'branch_no_label' => 'Branch No',
			'branch_no' => 'Enter Branch No',
			'name_label' => 'Branch Name',
			'name' => 'Enter Branch Name',
			'mobile_no_label' => 'Mobile No',
			'mobile_no' => 'Enter Mobile No',
			'phone_no_label' => 'Phone No',
			'phone_no' => 'Enter Phone No',
			'logo_label' => 'Logo',
			'logo' => 'Enter Logo',
			'favicon_label' => 'Favicon',
			'favicon' => 'Enter Favicon',
			'email_label' => 'Email',
			'email' => 'Enter Email',
			'username_label' => 'UserName',
			'username' => 'Enter UserName',
			'password_label' => 'Password',
			'password' => 'Enter Password',
			'password_confirmation_label' => 'Confirm Password',
			'password_confirmation' => 'Enter Confirm Password',
			'address_label' => 'Address',
			'address' => 'Enter Address',
			'description_label' => 'Description',
			'description' => 'Enter Description',
		],
		'added' => 'Branch Added Successfully',
		'updated' => 'Branch Updated Successfully',
		'deleted' => 'Branch Deleted Successfully',
		'status_change' => 'Branch Status Changed Successfully',
		'not_find' => 'Branch Could Not Find',
	],
	'employee' => [
		'general' => [
			'title' => 'General Setup',
			'create' => 'General Setup',
			'form' => [
				'prefix_label' => 'Employee Code Prefix',
				'prefix' => 'Enter Employee Code Prefix',
				'code_digit_label' => 'Digits in Employee Code',
				'code_digit' => 'Enter Digits in Employee Code ',
			],
			'added' => 'Department Added Successfully',
		],
		'department' => [
			'title' => 'Department Setup',
			'create' => 'New Department',
			'update' => 'Update Department',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'students' => 'Students',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'DepartMent Name',
				'name' => 'Enter DepartMent Name',
				'code_label' => 'Department Code',
				'code' => 'Enter Department Code',
				'description_label' => 'Description',
				'description' => 'Enter Department Description',
			],
			'added' => 'Department Added Successfully',
			'updated' => 'Department Updated Successfully',
			'deleted' => 'Department Deleted Successfully',
			'status_change' => 'Department Status Changed Successfully',
			'not_find' => 'Department Could Not Find',
			'associated_with_term' => 'Department is associated with employee term.',
		],
		'designation' => [
			'title' => 'Designation Setup',
			'create' => 'New Designation',
			'update' => 'Update Designation',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'category' => 'Category',
				'top_designation' => 'Top Designation',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Designation Name',
				'name' => 'Enter Designation Name',
				'top_designation_label' => 'Top Designation',
				'top_designation' => 'Enter Top Designation',
				'category_label' => 'Category',
				'category' => 'Enter Category',
				'is_teaching_employee' => 'Is Teaching Employee?',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Designation Added Successfully',
			'updated' => 'Designation Updated Successfully',
			'deleted' => 'Designation Deleted Successfully',
			'status_change' => 'Designation Status Changed Successfully',
			'associated_with_subordinates' => 'Designation Associated With Subordinates',
			'associated_with_term' => 'Designation Associated With Terms',
			'not_found' => 'Designation Could Not Found',
			'cannot_become_child' => 'Top Designation Could Not Become Child Designation',
		],
		'category' => [
			'title' => 'Employee Category Setup',
			'create' => 'New Employee Category',
			'update' => 'Update Employee Category',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'designation' => 'Designation',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Category Name',
				'name' => 'Enter Category Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Employee Category Added Successfully',
			'updated' => 'Employee Category Updated Successfully',
			'deleted' => 'Employee Category Deleted Successfully',
			'status_change' => 'Employee Category Status Changed Successfully',
			'not_find' => 'Employee Category Could Not Find',
			'associated_with_designation' => 'Employee Category Is Associated With Designation.',
			'default_employee_category' => 'Default Employee Category Could Not Modified.',
		],
		'employee_document_type' => [
			'title' => 'Document Type Setup',
			'create' => 'New Document Type',
			'update' => 'Update Document Type',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'employees' => 'Employees',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Document Type',
				'name' => 'Enter Document Type',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Document Type Added Successfully',
			'updated' => 'Document Type Updated Successfully',
			'deleted' => 'Document Type Deleted Successfully',
			'status_change' => 'Document Type Status Changed Successfully',
			'associated_with_document' => 'Document Type Associated With Document',
			'not_find' => 'Document Type Not Found',
		],
		'group' => [
			'title' => 'Employee Group Setup',
			'create' => 'New Employee Group',
			'update' => 'Update Employee Group',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Group Name',
				'name' => 'Enter Group Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Employee Group Added Successfully',
			'updated' => 'Employee Group Updated Successfully',
			'deleted' => 'Employee Group Deleted Successfully',
			'status_change' => 'Employee Group Status Changed Successfully',
			'not_find' => 'Employee Group Could Not Find',
			'associated_with_designation' => 'Employee Group Is Associated With Designation.',
			'default_employee_category' => 'Default Employee Group Could Not Modified.',
		],
		'leave_type' => [
			'title' => 'Employee Leave Type Setup',
			'create' => 'New Leave Type',
			'update' => 'Update Leave Type',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'alias' => 'Alias',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Leave Type',
				'name' => 'Enter Leave Type',
				'alias_label' => 'Alias',
				'alias' => 'Enter Alias',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Employee Leave Type Added Successfully',
			'updated' => 'Employee Leave Type Updated Successfully',
			'deleted' => 'Employee Leave Type Deleted Successfully',
			'status_change' => 'Employee Leave Type Status Changed Successfully',
			'not_find' => 'Employee Leave Type Could Not Find',
		],
		'attendance_type' => [
			'title' => 'Employee Attendacne Type Setup',
			'create' => 'New Attendacne Type',
			'update' => 'Update Attendacne Type',
			'table' => [
				'id' => '#',
				'type' => 'Type',
				'name' => 'Name',
				'alias' => 'Alias',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'type_label' => 'Attendacne Type',
				'type' => 'Enter Attendacne Type',
				'name_label' => 'Attendacne Name',
				'name' => 'Enter Attendacne Name',
				'alias_label' => 'Alias',
				'alias' => 'Enter Alias',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'type' => [
				'palceholder' => 'Select Attendacne Type',
				'present' => 'Present',
				'holiday' => 'Holiday',
				'absent' => 'On Leave without Pay (Absent)',
				'half_day' => 'Present with Half Day Pay',
			],
			'added' => 'Employee Attendacne Type Added Successfully',
			'updated' => 'Employee Attendacne Type Updated Successfully',
			'deleted' => 'Employee Attendacne Type Deleted Successfully',
			'status_change' => 'Employee Attendacne Type Status Changed Successfully',
			'not_find' => 'Employee Attendacne Type Could Not Find',
			'associated_with_attendance' => 'Attendacne Type Associated With Attendacne',
		],
		'pay_head' => [
			'title' => 'Pay Head Type Setup',
			'create' => 'New Pay Head Type',
			'update' => 'Update Pay Head Type',
			'table' => [
				'id' => '#',
				'type' => 'Type',
				'name' => 'Name',
				'alias' => 'Alias',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'type_label' => 'Pay Head Type',
				'type' => 'Enter Pay Head Type',
				'name_label' => 'Pay Head Name',
				'name' => 'Enter Pay Head Name',
				'alias_label' => 'Alias',
				'alias' => 'Enter Alias',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'type' => [
				'palceholder' => 'Select PayHead Type',
				'earning' => 'Earning',
				'deduction' => 'Deduction',
			],
			'added' => 'Employee Pay Head Added Successfully',
			'updated' => 'Employee Pay Head Updated Successfully',
			'deleted' => 'Employee Pay Head Deleted Successfully',
			'status_change' => 'Employee Pay Head Status Changed Successfully',
			'not_find' => 'Employee Pay Head Could Not Find',
		],
	],
	'misc' => [
		'nationality' => [
			'title' => 'Nationality Setup',
			'create' => 'New Nationality',
			'update' => 'Update Nationality',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Nationality Name',
				'name' => 'Enter Nationality Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Nationality Added Successfully',
			'updated' => 'Nationality Updated Successfully',
			'deleted' => 'Nationality Deleted Successfully',
			'status_change' => 'Nationality Status Changed Successfully',
			'not_find' => 'Nationality Could Not Find',
		],
		'religion' => [
			'title' => 'Religion Setup',
			'create' => 'New Religion',
			'update' => 'Update Religion',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Religion Name',
				'name' => 'Enter Religion Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Religion Added Successfully',
			'updated' => 'Religion Updated Successfully',
			'deleted' => 'Religion Deleted Successfully',
			'status_change' => 'Religion Status Changed Successfully',
			'not_find' => 'Religion Could Not Find',
		],
		'caste' => [
			'title' => 'Caste Setup',
			'create' => 'New Caste',
			'update' => 'Update Caste',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Caste Name',
				'name' => 'Enter Caste Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Caste Added Successfully',
			'updated' => 'Caste Updated Successfully',
			'deleted' => 'Caste Deleted Successfully',
			'status_change' => 'Caste Status Changed Successfully',
			'not_find' => 'Caste Could Not Find',
		],
		'category' => [
			'title' => 'Category Setup',
			'create' => 'New Category',
			'update' => 'Update Category',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Category Name',
				'name' => 'Enter Category Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Category Added Successfully',
			'updated' => 'Category Updated Successfully',
			'deleted' => 'Category Deleted Successfully',
			'status_change' => 'Category Status Changed Successfully',
			'not_find' => 'Category Could Not Find',
		],
		'blood_group' => [
			'title' => 'Blood Group Setup',
			'create' => 'New Blood Group',
			'update' => 'Update Blood Group',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Blood Group Name',
				'name' => 'Enter Blood Group Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Blood Group Added Successfully',
			'updated' => 'Blood Group Updated Successfully',
			'deleted' => 'Blood Group Deleted Successfully',
			'status_change' => 'Blood Group Status Changed Successfully',
			'not_find' => 'Blood Group Could Not Find',
		],
	],
	'finance' => [
		'bank' => [
			'title' => 'Bank Setup',
			'create' => 'New Bank',
			'update' => 'Update Bank',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Bank Name',
				'name' => 'Enter Bank Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Bank Added Successfully',
			'updated' => 'Bank Updated Successfully',
			'deleted' => 'Bank Deleted Successfully',
			'status_change' => 'Bank Status Changed Successfully',
			'not_find' => 'Bank Could Not Find',
		],
	],

		'student' => [
		'academic_session' => [
			'title' => 'Academic Session Setup',
			'create' => 'New Academic Session',
			'update' => 'Update Academic Session',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				'start_date'=>'Start Date',
				'end_date'=>'End Date',

				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Academic Session Name',
				'name' => 'Enter Academic Session Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
				'start_date_label' => 'Start Date',
				'start_date' => 'Enter Start Date',
				'end_date_label' => 'End Date',
				'end_date' => 'Enter End Date',
			],
			'added' => 'Academic Session Added Successfully',
			'updated' => 'Academic Session Updated Successfully',
			'deleted' => 'Academic Session Deleted Successfully',
			'status_change' => 'Academic Session Status Changed Successfully',
			'not_find' => 'Academic Session Could Not Find',
		],

			'class' => [
			'title' => 'Class Setup',
			'create' => 'New Class',
			'update' => 'Update Class',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				

				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Class Name',
				'name' => 'Enter Class Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Class Added Successfully',
			'updated' => 'Class Updated Successfully',
			'deleted' => 'Class Deleted Successfully',
			'status_change' => 'Class Status Changed Successfully',
			'not_find' => 'Class Could Not Find',
		],


			'subject' => [
			'title' => 'Subject Setup',
			'create' => 'New Subject',
			'update' => 'Update Subject',
			'table' => [
				'id' => '#',
				'name' => 'Name',
				

				'description' => 'Description',
				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'name_label' => 'Subject Name',
				'name' => 'Enter Subject Name',
				'description_label' => 'Description',
				'description' => 'Enter Description',
			],
			'added' => 'Subject Added Successfully',
			'updated' => 'Subject Updated Successfully',
			'deleted' => 'Subject Deleted Successfully',
			'status_change' => 'Subject Status Changed Successfully',
			'not_find' => 'Subject Could Not Find',
		],

			'subject_assaign' => [
			'title' => 'Subject Assaign Setup',
			'create' => 'Assaign Subject',
			'update' => 'Update Assaign Subject',
			'table' => [
				'id' => '#',
				'classname' => 'Class Name',
				'subjectname' => 'Subject Name',
				'subjectcategory' => 'Subject category',

				'status' => 'Status',
				'action' => 'Action',
			],
			'form' => [
				'class_label' => 'Class',
				'class' => 'Select Class Name',
				'subject_label' => 'Subject',
				'subject' => 'Select Subject Name',
				'category_label' => 'Category',
				'category' => 'Subject Category',
			],
			'added' => 'Subject Assiagn to Class Successfully',
			'updated' => 'Subject Assiagn to Class Successfully',
			'deleted' => 'Subject Assiagn to Class Successfully',
			'status_change' => 'Subject Assiagn to Class Changed Successfully',
			'not_find' => 'Subject Assiagn to Class Could Not Find',
		],
	],
];