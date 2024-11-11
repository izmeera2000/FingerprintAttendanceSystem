<?php
session_start();

require('route.php');


function index2()
{
	require_once('views/index2.php');
}
function index()
{
	check_session($site_url);
	require_once('views/index.php');
}


function server()
{

	require_once('admin/server.php');
}

function register()
{

	require_once('views/register.php');
}


function admin_register()
{

	require_once('views/register2.php');
}
function login()
{
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

	require_once('views/attendance/timeline.php');

}

function attendance_view2()
{
	check_session($site_url, 1);

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

	require_once('views/attendance/pdf2.php');

}


function class_create()
{
	check_session($site_url, 1);

	require_once('views/class/createclass.php');

}

function class_enrollment()
{
	check_session($site_url, 1);

	require_once('views/class/enrollment.php');

}


function fp_create()
{
	check_session($site_url, 1);

	require_once('views/fp/createfp.php');
}

function subjek_create()
{
	check_session($site_url, 1);

	require_once('views/subjek/createsubjek.php');
}

function sem_create()
{
	check_session($site_url, 1);

	require_once('views/sem/createsem.php');
}


function holiday_create()
{
	check_session($site_url, 1);

	require_once('views/holiday/createholiday.php');
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

// debug_to_console2($current_url);

//If url is http://localhost/route/home or user is at the maion page(http://localhost/route/)
switch (true) {
	case ($request == '' || $request == '/'):
		// echo $request;
		index2();
		break;
	case ($request == 'dashboard'):
		// echo $request;
		index();
		break;

	case ($request == 'register'):
		register();
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
	case (str_contains($request, 'fetchresource')):
	case (str_contains($request, 'fetchevent')):
	case (str_contains($request, 'fetchevent2')):
	case (str_contains($request, 'arduino')):
	case (str_contains($request, 'slot_checktime')):
	case (str_contains($request, 'class_findall')):
	case (str_contains($request, 'fp_findall')):
	case (str_contains($request, 'subjek_findall')):
	case (str_contains($request, 'sem_findall')):
	case (str_contains($request, 'holiday_findall')):
		// case (str_contains($request, 'class_createf')):


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

	case (str_contains($request, 'pdf2')):
		attendance_pdf2();
		break;
	case (str_contains($request, 'pdf')):
		attendance_pdf();
		break;

	case ($request == 'class/create'):
		class_create();
		break;
	case ($request == 'class/enrollment'):
		class_enrollment();
		break;

	case ($request == 'fp/create'):
		fp_create();
		break;

	case ($request == 'subjek/create'):
		subjek_create();
		break;

	case ($request == 'sem/create'):
		sem_create();
		break;

	case ($request == 'cuti/create'):
		holiday_create();
		break;



	default:
		// echo $request;
		// http_response_code(404);
		// page404();
		break;
}



