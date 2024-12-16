<?php
session_start();

require('route.php');


function index()
{
	require_once('views/index.php');
}
function dashboard()
{
	check_session($site_url);

	$pagetitle = "Dashboard";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Dashboard', 'url' => $site_url . '/dashboard', 'active' => true],
	];

	if ($_SESSION['user_details']['role'] != 4) {


		require_once('views/dashboard_admin.php');
	} else {
		require_once('views/dashboard_user.php');

	}

}


function server()
{

	require_once('admin/server.php');
}

function register()
{
	check_session2($site_url);

	require_once('views/register.php');
}

function profile()
{
	check_session($site_url);
	$pagetitle = "User Profile";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'User Profile', 'url' => $site_url . '/profile', 'active' => true],
	];
	require_once('views/profile.php');
}

function admin_register()
{

	require_once('views/register2.php');
}
function login()
{
	check_session2($site_url);

	require_once('views/login.php');
}
function logout()
{
	require_once('admin/server.php');

	session_destroy();
	unset($_SESSION['user_details']);
	header("location: " . $site_url . "");
}





//custom pages
function page404()
{
	require_once('views/404.php');

	// die('Page not found. Please try some different url.');
}


function attendance_view()
{
	check_session($site_url, 1);
	$pagetitle = "Log View";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Log View', 'url' => $site_url . '/view', 'active' => true],
	];
	require_once('views/attendance/timeline.php');

}

function attendance_view2()
{
	check_session($site_url, 1);
	$pagetitle = "Slot View";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Slot View', 'url' => $site_url . '/slotview', 'active' => true],
	];
	require_once('views/attendance/timeline2.php');

}

function emasuk()
{
	check_session($site_url, 1);

	require_once('views/attendance/eventmasuk.php');

}

function ekeluar()
{
	check_session($site_url, 1);

	require_once('views/attendance/eventkeluar.php');

}

function echecktime()
{
	check_session($site_url, 1);

	require_once('views/attendance/eventchecktime.php');

}


function attendance_pdf()
{
	check_session($site_url, 1);

	require_once('views/attendance/pdf.php');

}
function attendance_pdf2()
{
	check_session($site_url, 1);
	$pagetitle = "Attendance";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Attendance', 'url' => $site_url . '', 'active' => true],
		['label' => 'Generate', 'url' => $site_url . 'attendance/pdf2', 'active' => true],
	];
	require_once('views/attendance/pdf2.php');

}

function attendance_pdf3()
{
	check_session($site_url, 1);

	require_once('views/attendance/pdf3.php');

}
function attendance_pdf4()
{
	check_session($site_url, 1);

	require_once('views/attendance/pdf4.php');

}


function class_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Class";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Class', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/class/create', 'active' => true],
	];
	require_once('views/class/createclass.php');

}

function class_fingerprint()
{
	check_session($site_url, 1);
	$pagetitle = "Fingerprint ";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Class', 'url' => $site_url . '', 'active' => true],
		['label' => 'Fingerprint', 'url' => $site_url . '/class/fingeprrint', 'active' => true],
	];
	require_once('views/class/fingerprint.php');

}
function student_enrollment()
{
	check_session($site_url, 1);
	$pagetitle = "Enroll Student";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Student', 'url' => $site_url . '', 'active' => true],
		['label' => 'Enrollment', 'url' => $site_url . '/student/enrollment', 'active' => true],
	];
	require_once('views/class/org.php');

}

function fp_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Fingerprint Device";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Fingerprint', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/fp/create', 'active' => true],
	];
	require_once('views/fp/createfp.php');
}
function fp_settings()
{
	check_session($site_url, 1);
	$pagetitle = "Fingerprint Device Settings";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Fingerprint', 'url' => $site_url . '', 'active' => true],
		['label' => 'Settings', 'url' => $site_url . '/fp/settings', 'active' => true],
	];
	require_once('views/fp/fpsetting.php');
}
function subjek_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Subjek";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Subjek', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/subjek/create', 'active' => true],
	];
	require_once('views/subjek/createsubjek.php');
}

function subjek_assignlist()
{
	check_session($site_url, 1);
	$pagetitle = "Subjek Assign List";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Subjek', 'url' => $site_url . '', 'active' => true],
		['label' => 'Assign List', 'url' => $site_url . '/subjek/assignlist', 'active' => true],
	];
	require_once('views/subjek/assignlist.php');
}

function sem_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Semester";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Semester', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/sem/create', 'active' => true],
	];
	require_once('views/sem/createsem.php');
}


function holiday_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Holiday";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Holiday', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/holiday/create', 'active' => true],
	];
	require_once('views/holiday/createholiday.php');
}

function course_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Course";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Course', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/course/create', 'active' => true],
	];
	require_once('views/course/createcourse.php');
}

function program_create()
{
	check_session($site_url, 1);
	$pagetitle = "Create Program";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Program', 'url' => $site_url . '', 'active' => true],
		['label' => 'Create', 'url' => $site_url . '/program/create', 'active' => true],
	];
	require_once('views/program/createprogram.php');
}
function program_attendance($request)
{
	check_session($site_url, 1);
	$program_id = basename($request);
	$pagetitle = "Attendance";

	$breadcrumbs = [
		['label' => 'Home', 'url' => &$site_url, 'active' => false],
		['label' => 'Program', 'url' => $site_url . '', 'active' => true],
		['label' => $program_id, 'url' => $site_url . '/program/attendance', 'active' => true],
	];
	require_once('views/program/program_attendance.php');
}

function jtp2()
{
	check_session($site_url, 1);

	require_once('views/email/jtp2.php');
}


function amaran()
{
	check_session($site_url, 1);

	require_once('views/email/amaran.php');
}
function check_session(&$site_url, $admin = 0)
{
	if (!isset($_SESSION['user_details'])) {


		header("location: " . $site_url . "login");

		if ($admin) {
			// var_dump($_SESSION['user_details']['role']);

			if (($_SESSION['user_details']['role'] != 1)) {
				// header("location: " . $site_url . "login");
				// session_destroy();
				// unset($_SESSION['user_details']);
				header("location: " . $site_url . "logout");

			}


		}
	}

}
function check_session2(&$site_url)
{
	if (isset($_SESSION['user_details'])) {


		header("location: " . $site_url . "dashboard");


	}

}

// debug_to_console2($current_url);

//If url is http://localhost/route/home or user is at the maion page(http://localhost/route/)
switch (true) {
	case ($request == '' || $request == '/'):
		// echo $request;
		index();
		break;
	case ($request == 'dashboard'):
		// echo $request;
		dashboard();
		break;

	case ($request == 'register'):
		register();
		break;
	case ($request == 'profile'):
		profile();
		break;

	case ($request == 'admin/register'):
		admin_register();
		break;

	case ($request == 'login'):
		login();
		break;

	case (str_contains($request, 'logout')):
		logout();
		break;

	case ($request == 'attendance/view'):
		attendance_view();
		break;

	case ($request == 'attendance/slotview'):
		attendance_view2();
		break;

	// case (str_contains($request, 'eventcheck')):
	case (str_contains($request, 'fingerprintesp')):
	case (str_contains($request, 'fetchresource')):
	case (str_contains($request, 'fetchresource2')):
	case (str_contains($request, 'fetchevent')):
	case (str_contains($request, 'fetchevent2')):
	case (str_contains($request, 'arduino')):
	case (str_contains($request, 'slot_checktime')):
	case (str_contains($request, 'class_findall')):
	case (str_contains($request, 'fp_findall')):

	case (str_contains($request, 'fp_settingedit')):

	case (str_contains($request, 'subjek_findall')):
	case (str_contains($request, 'subjek2_findall')):
	case (str_contains($request, 'deleteassignslot')):
	case (str_contains($request, 'sem_findall')):
	case (str_contains($request, 'holiday_findall')):
	case (str_contains($request, 'course_findall')):
	case (str_contains($request, 'enroll_findall')):
	case (str_contains($request, 'kelas_findall')):
	case (str_contains($request, 'kelas_insertfp')):
	case (str_contains($request, 'kelas_deletefp')):
	case (str_contains($request, 'fetchslot')):
	case (str_contains($request, 'program_findall')):

	case (str_contains($request, 'program_createf')):
	case (str_contains($request, 'updateattprogram')):

	case (str_contains($request, 'updateslot')):

	case (str_contains($request, 'post_fp')):
	case (str_contains($request, 'login_fp')):
	// case (str_contains($request, 'class_createf')):
	case (str_contains($request, 'fp_mode')):
	case (str_contains($request, 'submitrating')):
	case (str_contains($request, 'check_slot_email')):
	case (str_contains($request, 'get_pdf')):


		server();
		break;

	case (str_contains($request, 'eventmasuk')):
		emasuk();
		break;

	case (str_contains($request, 'eventkeluar')):
		ekeluar();
		break;

	case (str_contains($request, 'eventchecktime')):
		echecktime();
		break;
	case ($request == 'attendance/pdf4'):
		attendance_pdf4();
		break;
	case ($request == 'attendance/pdf3'):
		attendance_pdf3();
		break;
	case ($request == 'attendance/generate_pdf'):
		attendance_pdf2();
		break;
	case ($request == 'attendance/pdf'):
		attendance_pdf();
		break;

	case ($request == 'class/create'):
		class_create();
		break;
	case ($request == 'class/fingerprint'):
		class_fingerprint();
		break;

	case ($request == 'student/enrollment'):
		student_enrollment();
		break;

	case ($request == 'fp/create'):
		fp_create();
		break;
	case ($request == 'fp/settings'):
		fp_settings();
		break;
	case ($request == 'subjek/create'):
		subjek_create();
		break;
	case ($request == 'subjek/assignlist'):
		subjek_assignlist();
		break;
	case ($request == 'sem/create'):
		sem_create();
		break;

	case ($request == 'cuti/create'):
		holiday_create();
		break;
	case ($request == 'course/create'):
		course_create();
		break;
	case ($request == 'program/create'):
		program_create();
		break;

	case (str_starts_with($request, 'program/')):
		program_attendance($request);
		break;
	case ($request == 'email/jtp2'):
		jtp2();
		break;
	case ($request == 'email/amaran'):
		amaran();
		break;

	default:
		// echo $request;
		// http_response_code(404);
		// page404();
		break;
}



