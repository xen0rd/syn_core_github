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
$route['default_controller'] = 'client';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* ADMIN */
$route['admin'] = 'user';
$route['admin/users'] = 'user/users';
$route['admin/configuration/(:any)'] = 'user/configuration';
$route['admin/configuration/settings/(:any)'] = 'user/configuration';
$route['admin/pchange'] = 'user/changePassword';
$route['admin/profile_settings'] = 'user/profileSettings';
$route['admin/account_settings'] = 'user/accountSettings';
$route['admin/remove_pending_email'] = 'user/removePendingEmail';
$route['admin/change_skin'] = 'user/changeSkin';

/* CLIENT */
$route['admin/clients'] = 'client/clients';
$route['pchange'] = 'client/changePassword';
$route['profile_settings'] = 'client/profileSettings';
$route['account_settings'] = 'client/accountSettings';
$route['remove_pending_email'] = 'client/removePendingEmail';
$route['forgotpassword'] = 'client/forgotPassword';

/* AUTH */
$route['echange'] = 'auth/changeEmail';
$route['verify/(:any)'] = 'auth/verifyNewEmail';
$route['reset_password/(:any)'] = 'auth/resetPassword';
$route['security'] = 'auth/securityQuestion';

/* SUPPORT */
$route['create_ticket'] = 'support/createTicket';
$route['submitted_tickets'] = 'support/getSubmittedTickets';
$route['client/ticketDetails/(:num)/(:any)/(:num)/(:num)'] = 'support/ticketDetails';
$route['ticket_details/(:num)/(:num)'] = 'support/submittedTicketsDetails';
$route['support/tickets'] = 'support';
$route['support/priorities'] = 'support';
//$route['support/imap'] = 'support';
$route['support/reply'] = 'support/closeTicket';
$route['support/reopen'] = 'support/reOpenTicket';
$route['support/assign_ticket'] = 'support/assignTicket';

/* DEPARTMENT */
$route['admin/departments'] = 'department';
$route['department/imap'] = 'department/IMAPConfiguration';
$route['department/imap/(:num)'] = 'department/IMAPConfiguration';

/* PRODUCTS */
$route['admin/products'] = 'product';
$route['admin/orders'] = 'product/orders';
$route['admin/orders/order_details/(:any)'] = 'product/orderDetails';
$route['downloadable'] = 'client';
$route['virtual'] = 'client';
$route['view_product'] = 'product/viewProduct';
$route['admin/product/order_details/(:num)/(:any)/(:num)/(:any)'] = 'product/clientOrderDetails';
$route['admin/product/order_history/(:num)/(:any)'] = 'product/orderHistory';
$route['purchase_history'] = 'product/orderHistory';
$route['product/order_details/(:num)/(:any)'] = 'product/clientOrderDetails';
$route['purchased_products'] = 'product/purchasedProducts';
