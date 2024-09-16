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
|	https://codeigniter.com/user_guide/general/routing.html
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

$route['default_controller'] = 'admin';
$route['(:any)'] = 'admin/$1';   

$route['continent-details/(:any)/(:any)'] = 'admin/continent_details/$1/$2';  
$route['country-details/(:any)/(:any)'] = 'admin/country_details/$1/$2';   
$route['state-details/(:any)/(:any)'] = 'admin/state_details/$1/$2';  
$route['city-details/(:any)/(:any)'] = 'admin/city_details/$1/$2';  
$route['location-details/(:any)/(:any)'] = 'admin/location_details/$1/$2';  
$route['category-details/(:any)/(:any)'] = 'admin/category_details/$1/$2';  
$route['sub-category-details/(:any)/(:any)'] = 'admin/sub_category_details/$1/$2';  
$route['category-type-details/(:any)/(:any)'] = 'admin/category_type_details/$1/$2';  
$route['inventory-details/(:any)/(:any)'] = 'admin/inventory_details/$1/$2';  
$route['price-details/(:any)/(:any)'] = 'admin/price_details/$1/$2'; 
$route['inventory-price-details/(:any)/(:any)'] = 'admin/inventory_price_details/$1/$2'; 
$route['user-details/(:any)/(:any)'] = 'admin/user_details/$1/$2';  
$route['user-details/(:any)'] = 'admin/user_details/$1'; 
$route['partners-details/(:any)/(:any)'] = 'admin/partners_details/$1/$2';  
$route['partner-view/(:any)'] = 'admin/partner_view/$1';
$route['chatUserDetails/(:any)'] = 'admin/chatUserDetails/$1';  
$route['getMessages/(:any)'] = 'admin/getMessage/$1';  
$route['chat_action/(:any)'] = 'admin/chat_action/$1';
$route['notifications/(:any)'] = 'admin/notifications/$1';
$route['add-notifications/(:any)'] = 'admin/add_notifications/$1';  
$route['notification-details/(:any)/(:any)'] = 'admin/notification_details/$1/$2';  
$route['library-view/(:any)'] = 'admin/library_view/$1';
$route['inventoryAll/(:any)'] = 'admin/inventoryAll/$1';
$route['banner-details/(:any)'] = 'admin/banner_details/$1';
$route['banner-details/(:any)/(:any)'] = 'admin/banner_details/$1/$2';  















$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
