<?php

/* 
CURRENT_DOMAIN
DB_NAME
DB_USERNAME
DB_PASSWORD
Write A Random ID : index:23,24
Kavenegar API : Home:389,400 | Auth:91,126
RewriteRule : .htaccess line 5
*/

use Auth\Auth;
use database\DataBase;

session_start();

//config
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain() . '/' . 'project');
define('DISPLAY_ERROR', true);
define('DB_HOST', 'localhost');
define('DB_NAME', 'project');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');


// Cookie ID
define('userCookieID', 'writeArandomID');
define('doctorCookieID', 'writeArandomID');


// database
require_once 'database/DataBase.php';

// Get data from cookie
if (!isset($_SESSION['number'])) {
    $db = new DataBase();
    if (isset($_COOKIE[userCookieID])) {
        $user = $db->select('SELECT * FROM users WHERE id = ?', [$_COOKIE[userCookieID]])->fetch();
        if ($user) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['number'] = $user['number'];
            $_SESSION['user_id'] = $user['id'];
        }
    } elseif (isset($_COOKIE[doctorCookieID])) {
        $doctor = $db->select('SELECT * FROM doctors WHERE id = ?', [$_COOKIE[doctorCookieID]])->fetch();
        if ($doctor) {
            $_SESSION['username'] = $doctor['name'];
            $_SESSION['number'] = $doctor['number'];
            $_SESSION['user_id'] = $doctor['id'];
        }
    }
}


// Kavehnegar API
require_once 'activities/kavehnegarLookup/kavehnegar.php';

// Cookie management 
require_once 'activities/cookieManager/cookieManage.php';

// lib
require_once 'lib/Parsidev/Jalali/jDate.php';

//Home
require_once 'activities/App/Home.php';

//auth
require_once 'activities/Auth/Auth.php';

// Admin
require_once 'activities/Admin/Admin.php';
require_once 'activities/Admin/Reserved.php';
require_once 'activities/Admin/Reserve.php';
require_once 'activities/Admin/Dashboard.php';
require_once 'activities/Admin/Category.php';
require_once 'activities/Admin/Post.php';
require_once 'activities/Admin/Banner.php';
require_once 'activities/Admin/User.php';
require_once 'activities/Admin/Doctor.php';
require_once 'activities/Admin/Comment.php';
require_once 'activities/Admin/Menu.php';
require_once 'activities/Admin/faq.php';
require_once 'activities/Admin/Websetting.php';


// Plans:
/* 
    A : Full
    B : Without Blog
    C : Without Blog, Multi Clinic
    D : Without Blog, Multi Clinic, SMS Systtem
    E : Without Blog, Multi Clinic, SMS Systtem, Reserve Description
*/
define('CURRENT_PLAN', 'A');


// Helper
spl_autoload_register(function ($className) {
    $path = BASE_PATH . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    include $path . $className . '.php';
});

function jalaliData($date)
{
    return \Parsidev\Jalali\jdate::forge($date)->format('date');
}

function jalaliTime($date)
{
    return \Parsidev\Jalali\jdate::forge($date)->format('time2');
}

function jalaliDataTime($date)
{
    return \Parsidev\Jalali\jdate::forge($date)->format('DateTime');
}

function jalaliYear($date)
{
    return \Parsidev\Jalali\jdate::forge($date)->format('year');
}


/* function setCustomCookie($name, $id, bool $Secure = true, bool $HttpOnly = true, $expireTime = null)
{
    if ($expireTime === null) {
        $expireTime = time() + (86400 * 30);
    }
    setcookie($name, $id, $expireTime, "/", "", $Secure, $HttpOnly);
}


function unsetCustomCookie($name, $value = '', $expireTime = null, bool $Secure = true, bool $HttpOnly = true)
{
    if ($expireTime === null) {
        $expireTime = time() - 3600;
    }
    setcookie($name, $value, $expireTime, "/", "", $Secure, $HttpOnly);
} */


function getPersianMonthName($date)
{
    $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $months = [
        1 => 'فروردین',
        2 => 'اردیبهشت',
        3 => 'خرداد',
        4 => 'تیر',
        5 => 'مرداد',
        6 => 'شهریور',
        7 => 'مهر',
        8 => 'آبان',
        9 => 'آذر',
        10 => 'دی',
        11 => 'بهمن',
        12 => 'اسفند'
    ];
    $dateEnglish = str_replace($persianNumbers, $englishNumbers, $date);
    $parts = explode('-', $dateEnglish);
    $monthNumber = (int) $parts[1];
    return $months[$monthNumber] ?? 'ماه نامعتبر';
}

function uri($reservedUrl, $class, $method, $requestMethod = 'GET')
{

    //current url array
    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
    $currentUrl = trim($currentUrl, '/');
    $currentUrlArray = explode('/', $currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    //reserved Url array
    $reservedUrl = trim($reservedUrl, '/');
    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    if (sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requestMethod) {
        return false;
    }

    $parameters = [];
    for ($key = 0; $key < sizeof($currentUrlArray); $key++) {
        if ($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) - 1] == "}") {
            array_push($parameters, $currentUrlArray[$key]);
        } elseif ($currentUrlArray[$key] !== $reservedUrlArray[$key]) {
            return false;
        }
    }

    if (methodField() == 'POST') {
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;
    call_user_func_array(array($object, $method), $parameters);
    exit();
}

//helpers
function protocol()
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
}

function currentDomain()
{
    return protocol() . $_SERVER['HTTP_HOST'];
}

function asset($src)
{
    $domain = trim(CURRENT_DOMAIN, '/ ');
    $src = $domain . '/' . trim($src, '/');
    return $src;
}

function url($url)
{
    $domain = trim(CURRENT_DOMAIN, '/ ');
    $url = $domain . '/' . trim($url, '/');
    return $url;
}

function currentUrl()
{
    return currentDomain() . $_SERVER['REQUEST_URI'];
}

function methodField()
{
    return $_SERVER['REQUEST_METHOD'];
}

function displayError($displayError)
{

    if ($displayError) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }

}

displayError(DISPLAY_ERROR);


global $flashMessage;
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}


function flash($name, $value = null)
{
    if ($value === null) {
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
        return $message;
    } else {
        $_SESSION['flash_message'][$name] = $value;
    }

}


function dd($var)
{
    echo '<pre>';
    var_dump($var);
    exit;
}

//dashboard
uri('admin', 'Admin\Dashboard', 'index');


// change default price value
uri('admin/reserve/change/price', 'Admin\Reserve', 'changePrice', 'POST');


// reserved 
uri('admin/reserved', 'Admin\Reserved', 'index');
uri('admin/reserved/edit/{id}', 'Admin\Reserved', 'edit');
uri('admin/reserved/update/{id}', 'Admin\Reserved', 'update', 'POST');
uri('admin/reserved/create', 'Admin\Reserved', 'create');
uri('admin/reserved/store', 'Admin\Reserved', 'store', 'POST');
uri('admin/reserved/delete/{id}', 'Admin\Reserved', 'delete');


// reserve 
uri('admin/reserve', 'Admin\Reserve', 'index');
uri('admin/reserve/store', 'Admin\Reserve', 'store', 'POST');
uri('admin/reserve/create', 'Admin\Reserve', 'create');
uri('admin/reserve/edit/{id}', 'Admin\Reserve', 'edit');
uri('admin/reserve/update/{id}', 'Admin\Reserve', 'update', 'POST');
uri('admin/reserve/delete/{id}', 'Admin\Reserve', 'delete');


// category
if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])):
    uri('admin/category', 'Admin\Category', 'index');
    uri('admin/category/create', 'Admin\Category', 'create');
    uri('admin/category/store', 'Admin\Category', 'store', 'POST');
    uri('admin/category/edit/{id}', 'Admin\Category', 'edit');
    uri('admin/category/update/{id}', 'Admin\Category', 'update', 'POST');
    uri('admin/category/delete/{id}', 'Admin\Category', 'delete');
endif;


// posts
if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])):
    uri('admin/post', 'Admin\Post', 'index');
    uri('admin/post/create/', 'Admin\Post', 'create');
    uri('admin/post/store/', 'Admin\Post', 'store', 'POST');
    uri('admin/post/edit/{id}', 'Admin\Post', 'edit');
    uri('admin/post/update/{id}', 'Admin\Post', 'update', 'POST');
    uri('admin/post/delete/{id}', 'Admin\Post', 'delete');
    uri('admin/post/selected/{id}', 'Admin\Post', 'selected');
    uri('admin/post/breaking-news/{id}', 'Admin\Post', 'breakingNews');
endif;


// banners
if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])):
    uri('admin/banner', 'Admin\Banner', 'index');
    uri('admin/banner/create', 'Admin\Banner', 'create');
    uri('admin/banner/store', 'Admin\Banner', 'store', 'POST');
    uri('admin/banner/edit/{id}', 'Admin\Banner', 'edit');
    uri('admin/banner/update/{id}', 'Admin\Banner', 'update', 'POST');
    uri('admin/banner/delete/{id}', 'Admin\Banner', 'delete');
endif;


// users
uri('admin/user', 'Admin\User', 'index');
uri('admin/user/edit/{id}', 'Admin\User', 'edit');
uri('admin/user/update/{id}', 'Admin\User', 'update', 'POST');
uri('admin/user/delete/{id}', 'Admin\User', 'delete');
uri('admin/user/changeActiveMode/{id}', 'Admin\User', 'changeActive');
uri('admin/user/changePermission/{id}', 'Admin\User', 'changePermission');


// doctors
$db = new DataBase();
$doctorCount = $db->select("SELECT COUNT(id) FROM `doctors`;")->fetch();
uri('admin/doctor', 'Admin\Doctor', 'index');
if ($doctorCount > 1) {
    if (!in_array(CURRENT_PLAN, ["C", "D", "E"])):
        uri('admin/doctor/create', 'Admin\Doctor', 'create');
    endif;
}
uri('admin/doctor/store', 'Admin\doctor', 'store', 'POST');
uri('admin/doctor/edit/{id}', 'Admin\Doctor', 'edit');
uri('admin/doctor/update/{id}', 'Admin\Doctor', 'update', 'POST');
uri('admin/doctor/delete/{id}', 'Admin\Doctor', 'delete');


//comments
if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])):
    uri('admin/comment', 'Admin\Comment', 'index');
    uri('admin/comment/change-status/{id}', 'Admin\Comment', 'changeStatus');
    uri('admin/comment/pin-comment/{id}', 'Admin\Comment', 'pinComment');
    uri('admin/comment/delete-comment/{id}', 'Admin\Comment', 'commentDelete');
endif;


// menu
uri('admin/menu', 'Admin\Menu', 'index');
uri('admin/menu/create', 'Admin\Menu', 'create');
uri('admin/menu/store', 'Admin\Menu', 'store', 'POST');
uri('admin/menu/edit/{id}', 'Admin\Menu', 'edit');
uri('admin/menu/update/{id}', 'Admin\Menu', 'update', 'POST');
uri('admin/menu/delete/{id}', 'Admin\Menu', 'delete');


// FAQ
uri('admin/faq', 'Admin\FAQ', 'index');
uri('admin/faq/edit/{id}', 'Admin\FAQ', 'edit');
uri('admin/faq/update/{id}', 'Admin\FAQ', 'update', 'POST');
uri('admin/faq/delete/{id}', 'Admin\FAQ', 'delete');


//websetting
uri('admin/websetting', 'Admin\Websetting', 'index');
uri('admin/websetting/edit', 'Admin\Websetting', 'edit');
uri('admin/websetting/update', 'Admin\Websetting', 'update', 'POST');


//Auth 
uri('register/store', 'Auth\Auth', 'registerStore', 'POST');
uri('login', 'Auth\Auth', 'login');
uri('check-login', 'Auth\Auth', 'checkLogin');
uri('auth-page', 'Auth\Auth', 'auth');
uri('auth', 'Auth\Auth', 'sendAuthNumber', 'POST');
uri('auth/number', 'Auth\Auth', 'authNumber', 'POST');
uri('auth/abort', 'Auth\Auth', 'authAbort', 'POST');
uri('logout', 'Auth\Auth', 'logout');
uri('auth/resend', 'Auth\Auth', 'resendCode', 'POST');


// blog
if (!in_array(CURRENT_PLAN, ["B", "C", "D", "E"])):
    uri('/blog', 'App\Home', 'blog');
    uri('/home/all-posts', 'App\Home', 'allPosts');
    uri('/show-post/{id}', 'App\Home', 'show');
    uri('/show-category/{id}', 'App\Home', 'category');
    uri('/comment-store/{post_id}', 'App\Home', 'commentStore', 'POST');
    uri('/reply/{post_id}/{comment_id}', 'App\Home', 'replyStore', 'POST');
    uri('get-posts', 'App\Home', 'getPosts', 'POST');
    uri('save-rate', 'App\Home', 'saveRate', 'POST');
endif;


// reserve
uri('send', 'App\Home', 'send', 'POST');
uri('get-time', 'App\Home', 'getTime');
uri('get-dates', 'App\Home', 'getDates', 'POST');
uri('reserve', 'App\Home', 'reserve', 'POST');


//app
uri('/', 'App\Home', 'index');
uri('/home', 'App\Home', 'index');
uri('/contact-us', 'App\Home', 'contactUs');

require_once 'template\app\notFoundPage.php';