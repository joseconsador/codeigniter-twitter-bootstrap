<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['bbc'] = 'bulletin_board/cv/post';
$route['bbc/index'] = 'bulletin_board/cv/post/index';
$route['bbc/index/(:num)'] = 'bulletin_board/cv/post/index/$1';
$route['bbc/post'] = 'bulletin_board/cv/post';
$route['bbc/post/add'] = 'bulletin_board/cv/post/add';
$route['bbc/post/edit/(:num)'] = 'bulletin_board/cv/post/edit/$1';
$route['bbc/post/view/(:num)'] = 'bulletin_board/cv/post/view/$1';
$route['bbc/post/delete'] = 'bulletin_board/cv/post/delete';
$route['bbc/post/delete/(:num)'] = 'bulletin_board/cv/post/delete/$1';
$route['bbc/post/search'] = 'bulletin_board/cv/post/search';