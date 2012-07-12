<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['orders'] = 'orders/code/order';
$route['orders/form'] = 'orders/code/order/form';
$route['orders/form/(:num)'] = 'orders/code/order/form/$1';
$route['orders/view/(:num)'] = 'orders/code/order/view/$1';
$route['orders/delete/(:num)'] = 'orders/code/order/delete/$1';
$route['orders/index'] = 'orders/code/order/index';
$route['orders/index/(:num)'] = 'orders/code/order/index/$1';
$route['orders/complete'] = 'orders/code/order/complete';
$route['orders/order'] = 'orders/code/order';
$route['orders/order/add'] = 'orders/code/order/add';
$route['orders/order/edit/(:num)'] = 'orders/code/order/edit/$1';
$route['orders/order/view/(:num)'] = 'orders/code/order/view/$1';
$route['orders/order/delete'] = 'orders/code/order/delete';
$route['orders/order/delete/(:num)'] = 'orders/code/order/delete/$1';
$route['orders/order/search'] = 'orders/code/order/search';
$route['orders/get_sales'] = 'orders/code/order/get_sales';