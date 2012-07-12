<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['staff'] = 'staff/code/user';
$route['staff/form'] = 'staff/code/user/form';
$route['staff/form/(:num)'] = 'staff/code/user/form/$1';
$route['staff/index'] = 'staff/code/user/index';
$route['staff/index/(:num)'] = 'staff/code/user/index/$1';
$route['staff'] = 'staff/code/user';
$route['staff/add'] = 'staff/code/user/add';
$route['staff/edit/(:num)'] = 'staff/code/user/edit/$1';
$route['staff/view/(:num)'] = 'staff/code/user/view/$1';
$route['staff/delete'] = 'staff/code/user/delete';
$route['staff/delete/(:num)'] = 'staff/code/user/delete/$1';
$route['staff/search'] = 'staff/code/user/search';
