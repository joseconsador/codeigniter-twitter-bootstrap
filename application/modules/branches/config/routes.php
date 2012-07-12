<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['branches'] = 'branches/code/branch';
$route['branches/form'] = 'branches/code/branch/form';
$route['branches/form/(:num)'] = 'branches/code/branch/form/$1';
$route['branches/index'] = 'branches/code/branch/index';
$route['branches/index/(:num)'] = 'branches/code/branch/index/$1';
$route['branches/branch'] = 'branches/code/branch';
$route['branches/branch/add'] = 'branches/code/branch/add';
$route['branches/branch/edit/(:num)'] = 'branches/code/branch/edit/$1';
$route['branches/branch/view/(:num)'] = 'branches/code/branch/view/$1';
$route['branches/branch/delete'] = 'branches/code/branch/delete';
$route['branches/branch/delete/(:num)'] = 'branches/code/branch/delete/$1';
$route['branches/branch/search'] = 'branches/code/branch/search';
