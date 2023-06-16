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
//$routes->get('/', 'Home::index');

/*Site-----------------------------------------------*/

$routes->get('/', 'Home::index');
$routes->get('dashboard', 'User::index');
$routes->get('profile', 'User::index');
$routes->get('become-seller', 'User::become_seller');
$routes->get('verify-email/(:num)/(:any)', 'Home::verify_email/$1/$2');
$routes->get('verify-sms/(:num)/(:any)', 'Home::verify_sms/$1/$2');
$routes->get('reset-password/(:any)/(:any)', 'Home::reset_password/$1/$2');
$routes->get('verification-pending-screen', 'Home::verify_pending');
$routes->get('sms-verification','Home::verify_sms_pending');
$routes->get('sendVerificationMail/(:any)' , 'Home::sendEmail_veification');
$routes->get('sendFinalSignal/(:any)' , 'Home::finalsignal');
$routes->get('sendVerificationSMS/(:any)' , 'Home::sendSMS_veification');
 $routes->get('contactus' , 'Home::ContactUs');
 $routes->get('privacy' , 'Home::Privacy');
 $routes->get('terms' , 'Home::Terms');
 $routes->get('upgrade-plan' , 'User::Upgrade_plan');
 $routes->get('update-profile' , 'User::update_profile');
 $routes->get('update-password' , 'User::update_password');
 $routes->get('wishlist' , 'User::wishlist/post');
 $routes->get('wishlist/post' , 'User::wishlist/post');
 $routes->get('wishlist/coupon' , 'User::wishlist/coupon');
 $routes->get('wishlist/swap' , 'User::wishlist/swap');
 $routes->get('mypost' , 'User::my_post');
 $routes->get('post/(:any)' , 'Shop::post_detail/$1');
 $routes->get('reviews' , 'User::my_review');
 $routes->get('notification' , 'User::Notification');
 $routes->get('add_post' , 'Post::index');
 $routes->get('edit_post/(:any)' , 'Post::editPost/$1');
 $routes->get('shop' , 'Shop::index');
 $routes->get('shop/(:any)', 'Shop::index/$1');
 $routes->get('groups', 'Groups::index');
 $routes->get('my-joined-groups', 'Groups::my_joined_groups');
 $routes->get('my-created-groups', 'Groups::my_created_groups');

 $routes->get('my-coupons' , 'User::coupon_list');
 $routes->get('coupons' , 'Coupon::all_coupon_list');
 $routes->get('coupon-detail/(:any)' , 'Coupon::coupon_detail/$1');
 $routes->get('add-coupon' , 'Coupon::addcouponForm');
 $routes->get('edit-coupon/(:any)' , 'Coupon::editcouponForm/$1');


 $routes->get('my-swaps' , 'User::swap_list');
 $routes->get('swaps' , 'Swap::all_swap_list');
 $routes->get('swap-detail/(:any)' , 'Swap::swap_detail/$1');
 $routes->get('add-swap' , 'Swap::addswapForm');
 $routes->get('edit-swap/(:any)' , 'Swap::editswapForm/$1');
 $routes->get('vendor/(:any)' , 'Vendor::vendor_profile/$1');
/*admin-----------------------------------------------*/

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) 
{
    $routes->get('/', 'Admin::login');
    $routes->get('forgot', 'Admin::Forgot');
    $routes->get('do_forgot', 'Admin::do_forgot');

    /*Auth=====================*/
        $routes->get('profile', 'Profile::adminProfile');
        $routes->get('dashboard', 'Dashboard::index');
        $routes->get('logout', 'Dashboard::Logout');

        $routes->get('users', 'Users::index');
        // $routes->get('sellers', 'Users::sellersList');
        $routes->get('verified', 'Users::isVerified');
        $routes->get('incoming-seller', 'Users::incomingSellers');
        $routes->get('userview/(:any)', 'Users::userView/$1');
        // $routes->get('view-user/(:any)', 'Users::user_view/$1');
        $routes->get('edit-user/(:any)', 'Users::user_edit/$1');

        $routes->get('category', 'Category::index');
        $routes->get('sub-category', 'Category::sub_category_list');

        $routes->get('social', 'Content::social_list');
        
        $routes->get('testimonial', 'Testimonial::testimonial_list');

        $routes->get('contactus', 'Admin::contact_list');
        $routes->get('plan', 'Plan_Management::plan_list');
        $routes->get('plan-subscription', 'Plan_Management::plan_subsbription_list');
        $routes->get('post', 'Post::post_list'); 
        $routes->get('pending-post', 'Post::pending_post_list'); 

        // $routes->get('aucation', 'Post::aucation_list'); 
        // $routes->get('pending-aucation', 'Post::pending_aucation_list'); 
        $routes->get('auction', 'Post::post_list'); 

        $routes->get('post-subscription', 'Post::post_subscription'); 
        $routes->get('post-comments/(:any)', 'Post::post_comments/$1'); 
        $routes->get('post-view/(:any)', 'Post::postView/$1');
        $routes->get('menu', 'Menu::menu_list'); 
        $routes->get('home_banner', 'Admin::home_banner_list'); 
        $routes->get('group-list', 'Group_management::group_list'); 
        $routes->get('coupons' , 'Coupon::index');
        $routes->get('swaps' , 'Swap::index');

        
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