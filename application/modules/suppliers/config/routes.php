<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['suppliers'] = 'suppliers/code/suppliers';
$route['suppliers/form'] = 'suppliers/code/suppliers/form';
$route['suppliers/form/(:num)'] = 'suppliers/code/suppliers/form/$1';
$route['suppliers/index'] = 'suppliers/code/suppliers/index';
$route['suppliers/index/(:num)'] = 'suppliers/code/suppliers/index/$1';
$route['suppliers'] = 'suppliers/code/suppliers';
$route['suppliers/add'] = 'suppliers/code/suppliers/add';
$route['suppliers/edit/(:num)'] = 'suppliers/code/suppliers/edit/$1';
$route['suppliers/view/(:num)'] = 'suppliers/code/suppliers/view/$1';
$route['suppliers/delete'] = 'suppliers/code/suppliers/delete';
$route['suppliers/delete/(:num)'] = 'suppliers/code/suppliers/delete/$1';
$route['suppliers/search'] = 'suppliers/code/suppliers/search';
