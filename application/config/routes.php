<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['category'] = 'Master/category';
$route['categoryadd'] = 'Master/categoryadd';
$route['states'] = 'Master/states';
$route['statesadd'] = 'Master/stateadd';
$route['cities'] = 'Master/city';
$route['citiesadd'] = 'Master/cityadd';
$route['area'] = 'Master/area';
$route['areaadd'] = 'Master/areaadd';
$route['pincodes'] = 'Master/pincodes';
$route['police'] = 'Master/police';
$route['policeadd'] = 'Master/policeadd';
$route['celebrities'] = 'Master/celebrities';
$route['celebritiesadd'] = 'Master/celebritiesadd';
$route['art'] = 'Master/art';
$route['arttypeadd'] = 'Master/arttypeadd';
$route['psychiatrist'] = 'Master/psychiatrist';
$route['psychiatristadd'] = 'Master/psychiatristadd';
$route['pincodeadd'] = 'Master/pincodeadd';
$route['v1/register'] = 'v1/App/register';
$route['v1/verifyOtp'] = 'v1/App/verifyOtp';
$route['v1/interestlist'] = 'v1/App/interestlist';
$route['v1/updateprofile'] = 'v1/App/updateprofile';
$route['v1/updateinterest'] = 'v1/App/updateInterest';
$route['v1/profile'] = 'v1/App/profile';
$route['v1/creategroup'] = 'v1/App/creategroup';
$route['v1/mygroup'] = 'v1/App/mygroup';
$route['v1/groupcategory'] = 'v1/App/groupcategory';
$route['v1/psychiatristlist'] = 'v1/App/psychiatristlist';
$route['v1/groups'] = 'v1/App/groups';
$route['v1/addmembers'] = 'v1/App/addmembers';
$route['v1/peoples'] = 'v1/App/peoples';
$route['v1/postmsg'] = 'v1/App/postmsg';
$route['v1/postgroupmsg'] = 'v1/App/postgroupmsg';
$route['v1/groupinfo'] = 'v1/App/groupinfo';
$route['v1/chat'] = 'v1/App/chat';
$route['v1/token'] = 'v1/App/token';
$route['v1/groupchat'] = 'v1/App/groupchat';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
