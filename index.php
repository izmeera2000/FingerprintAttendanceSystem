<?php
session_start();

require('route.php');

// require __DIR__ . '/admin/vendor/autoload.php';

// echo __DIR__ . '/../';
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
// $dotenv->load();
// $site_url = $_ENV['site1'];


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
	check_session($site_url);

	require_once('views/attendance/timeline.php');

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
if ($request == '' or $request == '/')
	// echo $request;
	index();
else if ($request == 'register')
	register();
else if (str_contains($request, 'login'))
	login();
else if (str_contains($request, 'logout'))
	logout();
else if (str_contains($request, 'attendance/view'))
	attendance_view();
	else if (str_contains($request, 'fetchresource'))
	server();
	else if (str_contains($request, 'fetchevent'))
	server();
else {
	// echo $request;

	// http_response_code(404);
	// page404();
}


