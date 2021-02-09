<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'landing/Landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login.html'] = 'login/login';
$route['act/login.json'] = 'login/login_post';

$route['dashboard.html'] = 'dashboard/Dashboard';
$route['report-action.json'] = 'dashboard/Dashboard/excel_report';


$route['users.html'] = 'users/Users';
$route['act/call-users.json'] = 'users/Users/call_user';
$route['act/create-users.json'] = 'users/Users/create_user';
$route['act/delete-users.json'] = 'users/Users/delete_user';

$route['video-thumb.html'] = 'video/Video';
$route['act/call-video.json'] = 'video/Video/call_video';
$route['act/update-video.json'] = 'video/Video/update_video';

$route['contact.html'] = 'contact/Contact';
$route['act/delete-contact.json'] = 'contact/Contact/delete_contact';

$route['send-email.html'] = 'sendmail/Sendmail';
$route['act/sendmail.json'] = 'sendmail/Sendmail/sendmail_post';

$route['logout.html'] = 'logout/Logout';

$route['landing.html'] = 'landing/Landing';