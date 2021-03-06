<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe'] = 'login/loginMe';
$route['dashboard'] = 'user';
$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['addNew'] = "user/addNew";

$route['addNewUser'] = "user/addNewUser";
$route['editOld'] = "user/editOld";
$route['editOld/(:num)'] = "user/editOld/$1";
$route['editUser'] = "user/editUser";
$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";
$route['pageNotFound'] = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";
$route['getteamlead'] = "user/getteamlead";


$route['forgotPassword'] = "login/forgotPassword";
$route['resetPasswordUser'] = "login/resetPasswordUser";
$route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser'] = "login/createPasswordUser";


$route['addNewTl'] = "user/addNewTl";
$route['addNewEmp'] = "user/addNewEmp";

$route['ajax/break'] = "ajax/break";
$route['logoff'] = "login/logoff";
$route['logoffemp'] = "login/logoff";
//Admin
$route['admin/projectlist'] = "admin/projectlist";
$route['admin/addproject'] = "admin/addproject";
$route['admin/editproject/(:num)'] = "admin/editproject/$1";
$route['admin/editproject'] = "admin/editproject";
$route['admin/team'] = "admin/team";

$route['admin/breaklist'] = "admin/breaklist";
$route['admin/addbreak'] = "admin/addbreak";
$route['admin/editbreak/(:num)'] = "admin/editbreak/$1";


$route['reports'] = "reports/index";
$route['reports/pdf'] = "reports/pdf";
$route['reports/excel'] = "reports/excel";
//$route['reports/bydays/(:any)'] = "reports/bydays/$1";
$route['reports/summary'] = "reports/summary";


$route['reports/excel'] = "reports/excel";


/* End of file routes.php */
/* Location: ./application/config/routes.php */