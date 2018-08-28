<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code




/*
|-----------------------------------
|Database Environment Configuration
|-----------------------------------
| Server Configuration to use on Database->server_config table
| Value is either 'TEST' or 'PRODUCTION'
|
*/
define('_ENVIRONMENT', 'PRODUCTION', TRUE); 


/*
 |-----------------------------------
 |Modules
 |-----------------------------------
 | Module ID's
 |
 */
define('_AUTH', 'Auth');
define('_CLIENT', 'Client');
define('_DEPARTMENT', 'Department');
define('_SUPPORT', 'Support');
define('_UPDATER', 'Updater');
define('_USER', 'User');
define('_PRODUCT', 'Product');


/*
 |---------------------
 |Ports and Protocols
 |---------------------
 |Email settings
 */
define('_IMAP_PROTOCOL', 'ssl');
define('_IMAP_PORT', 993);
define('_SMTP_PROTOCOL', 'ssl');
define('_SMTP_PORT', 465);

/*
 |---------------------------
 |Paypal Standard
 |---------------------------
 */
define('_PAYPAL_PAYMENTS_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr'); // Sandbox
//define('_PAYPAL_PAYMENTS_URL', 'https://www.paypal.com/cgi-bin/webscr'); // Live
define('_PAYPAL_BUSINESS_EMAIL', 'dr0ne_r0z@yahoo.com');
//define('_PAYPAL_MERCHANT_ID', 'IDRE74SJJJ8RWQC');
define('_PDT_IDENTITY_TOKEN', 'zk6jQEQokzdsqJYDGZ_fvJV9mBbr3tGK4-WiDaxknMmx25E1ICl4mbKWtOW');


/*
 |---------------------------
 |Paypal Payments Pro
 |---------------------------
 */
define('_PAYPAL_PAYMENTS_PRO_URL', 'https://api-3t.sandbox.paypal.com/nvp'); // Sandbox
define('_PAYPAL_PAYMENTS_PRO_VERSION', 56);
define('_PAYPAL_PAYMENTS_PRO_METHOD_DIRECT_PAYMENT', "DoDirectPayment");
define('_PAYPAL_PAYMENTS_PRO_ACTION_SALE', "Sale");
define('_PAYPAL_PAYMENTS_PRO_USER', "zhekrougjx-facilitator_api1.gmail.com");
define('_PAYPAL_PAYMENTS_PRO_PWD', "1407408296");
define('_PAYPAL_PAYMENTS_PRO_SIGNATURE', "AoDcUrqZiJC2y3TqFmH7oMN1N1ViAgM8u77tu66Gj2qxWFuXjWz4v5Vz");


/*
|---------------------
|Synthia Core Version
|---------------------
|Current version
*/
define('_SYNTHIA_VERSION', '1.2');
define('_SYNTHIA_PRO', TRUE);

