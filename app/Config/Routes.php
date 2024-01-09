<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index', ['as' => 'index']);
$routes->get('/(:num)', 'HomeController::rememberReferrerId/$1');

//$routes->get('task/(:num)', 'Task::getTaskById/$1');
//$routes->post('task/create', 'Task::createTask');
//$routes->get('task/complete/(:num)', 'Task::completeTask/$1');
$routes->get('task/showQuery', 'Task::showQuery');

// Will display a custom view
//$routes->set404Override(function()
//{
//    echo view('errors/html/error_404');
//});

/**
 * Myth:Auth routes file.
 */
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes)
{
    $routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes)
    {
        // API
        $routes->match(['get', 'post'], 'user/(:any)', 'UserController::$1');
        $routes->match(['get', 'post'], 'task/(:any)', 'TaskController::$1');
        $routes->match(['get', 'post'], 'referral-source/(:segment)', 'ReferralSourceController::$1');
        $routes->match(['get', 'post'], 'task-category/(:segment)', 'TaskCategoryController::$1');
        $routes->match(['get', 'post'], 'task-type/(:segment)', 'TaskTypeController::$1');
        $routes->match(['get', 'post'], 'task-comment/(:any)', 'TaskCommentController::$1');
        $routes->match(['get', 'post'], 'account/(:segment)', 'AccountController::$1');
        $routes->match(['get', 'post'], 'article/(:any)', 'ArticleController::$1');
        $routes->match(['get', 'post'], 'activity/(:any)', 'ActivityController::$1');
        $routes->match(['get', 'post'], 'dashboard/(:any)', 'DashboardController::$1');
        $routes->match(['get', 'post'], 'news/(:any)', 'NewsController::$1');


    });

    // Login/out
    $routes->get('auth/signin', 'AuthController::login', ['as' => 'login']);
    $routes->post('auth/signin', 'AuthController::attemptLogin', ['as' => 'login']);
    $routes->get('auth/logout', 'AuthController::logout', ['as' => 'logout']);

    // Registration
    $routes->get('auth/signup', 'AuthController::register', ['as' => 'register']);
    $routes->post('auth/signup', 'AuthController::attemptRegister', ['as' => 'register']);

    // Activation
    $routes->get('auth/activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('auth/resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('auth/forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('auth/forgot', 'AuthController::attemptForgot', ['as' => 'forgot']);
    $routes->get('auth/reset-password', 'AuthController::resetPassword', ['as' => 'reset-password']);
    $routes->post('auth/reset-password', 'AuthController::attemptReset', ['as' => 'reset-password']);

    // Google Login
    $routes->get('auth/googleLogin', 'AuthController::googleLogin', ['as' => 'googleLogin']);
    $routes->get('auth/redirectGoogleAuthUrl', 'AuthController::redirectGoogleAuthUrl', ['as' => 'redirectGoogleAuthUrl']);

    $routes->get('auth/vkLogin', 'AuthController::vkLogin', ['as' => 'vkLogin']);

    $routes->match(['get', 'post'], '(:any)', 'VueController::index', ['filter' => 'login']);
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}