<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Test page
$routes->get('test', 'Home::test');



$routes->group('session', static function($routes){


});


/*  Admin Routes */


$routes->group('admin', static function ($routes){

    $routes->get('test', 'Admin::test');

    $routes->get('login', 'Admin::getLogin');
    $routes->post('login', 'Admin::login');
    $routes->get('logout', 'Admin::logout');

    $routes->get('otp-verification', 'Admin::getOtpVerification');
    $routes->post('otp-verification', 'Admin::OtpVerification');
    $routes->get('forget-password', 'Admin::getForgetPassword');
    $routes->post('forget-password', 'Admin::forgetPassword');
    $routes->get('reset-password/(:segment)', 'Admin::getResetPassword/$1');
    $routes->post('reset-password', 'Admin::resetPassword');


    $routes->get('dashboard', 'Admin::index');
    $routes->get('edit/(:segment)', 'Admin::cmsPages');
    $routes->get('edit/(:segment)/(:segment)', 'Admin::cmsPages');
    $routes->post('edit-content', 'Admin::cmsUpdate');
    $routes->get('user', 'Admin::getUser');
    $routes->get('user/search', 'Admin::getUser');
    $routes->get('user/filter', 'Admin::getUser');
    $routes->get('user/(:segment)', 'Admin::getUserDetail/$1');
    $routes->get('quick-user/(:segment)', 'Admin::getQuickUserDetail/$1');
    $routes->get('single-user', 'Admin::userDetail');


    $routes->get('inbox', 'Admin::inbox');
    $routes->get('inbox/search', 'Admin::inbox');
    $routes->get('inbox/filter', 'Admin::inbox');
    $routes->post('inbox/delete', 'Admin::inboxDelete');

    $routes->get('inbox-details/(:segment)', 'Admin::inboxDetails/$1');

    $routes->get('products', 'AdminProducts::getProducts');
    $routes->get('products/filter', 'AdminProducts::getProducts');
    $routes->get('product/search', 'AdminProducts::getProducts');
    $routes->get('product-category', 'AdminProducts::getProductCategory');
    $routes->get('product-category-faq', 'AdminProducts::getProductCategoryFaq');
    $routes->get('get-attribute/(:segment)', 'AdminProducts::getAttribute/$1');
    $routes->get('products/(:segment)', 'AdminProducts::getProductDetail/$1');
    $routes->get('helpMeChoose/(:segment)', 'AdminProducts::getHelpMeChoose/$1');
    $routes->get('edit-product/(:segment)', 'AdminProducts::editProduct/$1');
    $routes->post('edit-product', 'AdminProducts::updateFullProduct');
    


    $routes->get('add-product', 'AdminProducts::addProduct');
    $routes->post('add-product', 'AdminProducts::saveProduct');

    
    $routes->get('categories', 'AdminProducts::getCategories');
    $routes->get('category/(:segment)', 'AdminProducts::getcategory/$1');
    $routes->get('categories/search', 'AdminProducts::getCategories');


    $routes->get('attributes-categories', 'AdminProducts::getAttributesCategories');
    $routes->get('attributes-categories/search', 'AdminProducts::getAttributesCategories');
    $routes->get('attributes-category/(:segment)', 'AdminProducts::getAttributesCategory/$1');

    $routes->get('attributes', 'AdminProducts::getAttributes');
    
    $routes->get('attributes/search', 'AdminProducts::getAttributes');
    $routes->get('attributes/filter', 'AdminProducts::getAttributes');
    $routes->get('attributes/(:segment)', 'AdminProducts::getAttributesDetails/$1');


    $routes->get('product-reviews', 'AdminProducts::getReviews');
    $routes->get('product-reviews/search', 'AdminProducts::getReviews');
    $routes->get('coupons', 'AdminProducts::getCoupons');
    $routes->get('coupons/search', 'AdminProducts::getCoupons');
    $routes->get('coupon/(:segment)', 'AdminProducts::getCoupon/$1');




    $routes->get('orders', 'AdminOrders::getOrders');
    $routes->get('order/(:segment)', 'AdminOrders::getOrder/$1');
    $routes->get('orders/filter', 'AdminOrders::getOrders');
    $routes->get('orders/search', 'AdminOrders::getOrders');
    $routes->get('order-detail/(:segment)', 'AdminOrders::getOrderDetails/$1');

    $routes->get('invoice/(:segment)', 'AdminOrders::invoice/$1');
   
    $routes->get('colors', 'AdminProducts::getColors');
    $routes->get('colors/filter', 'AdminProducts::getColors');
    $routes->get('colors/search', 'AdminProducts::getColors');
    $routes->get('color/(:segment)', 'AdminProducts::getColor/$1');

    $routes->get('hair-styles', 'AdminProducts::getHairStyles');
    $routes->get('hair-styles/filter', 'AdminProducts::getHairStyles');
    $routes->get('hair-styles/search', 'AdminProducts::getHairStyles');
    $routes->get('hair-style/(:segment)', 'AdminProducts::getHairStyle/$1');

    $routes->get('faq', 'AdminProducts::getFaqs');
    $routes->get('faq/filter', 'AdminProducts::getFaqs');
    $routes->get('faq/search', 'AdminProducts::getFaqs');
    $routes->get('faq/(:segment)', 'AdminProducts::getFaq/$1');

    $routes->get('edit-footer', 'Admin::getFooter');
    $routes->post('update-footer', 'Admin::updateFooter');

    
    $routes->get('edit-header/(:segment)', 'Admin::getHeader/$1');
    $routes->post('update-header', 'Admin::updateHeader');
    $routes->post('update-header-bulk', 'Admin::updateHeaderBulk');
    $routes->post('update-header-product-list', 'Admin::updateHeaderProduct');

    $routes->get('edit-search-quick', 'Admin::getSearchQuick');
    $routes->post('update-search-quick-connect', 'Admin::updateSearchQuick');


    $routes->get('add-blog', 'Admin::addBlog');
    $routes->post('add-blog', 'Admin::saveBlog');
    $routes->get('blogs', 'Admin::getBlogs');
    $routes->get('blogs/filter', 'Admin::getBlogs');
    $routes->get('blogs/search', 'Admin::getBlogs');
    $routes->get('blog/(:segment)', 'Admin::getBlogDetail/$1');
    $routes->get('edit-blog/(:segment)', 'Admin::editBlog/$1');
    $routes->post('edit-blog', 'Admin::updateFullBlog');

    $routes->get('blog-categories', 'Admin::getBlogCategories');
    $routes->get('blog-category/(:segment)', 'Admin::getBlogSingleCategory/$1');
    $routes->get('blog-categories/search', 'Admin::getBlogCategories');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
