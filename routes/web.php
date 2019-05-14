<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login')->name('proceed-login');

Route::get('/','IndexController@index')->name('index.index');

Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('/dashboard', 'LoginController@dashboard')->name('dashboard');

    //logout
    Route::get('logout', 'LoginController@logout')->name('logout');


    //user
    Route::get('/admin/user','UserController@index')->name('user.index');
    Route::get('/admin/user/create','UserController@create')->name('user.create');
    Route::get('/admin/user/source','UserController@source')->name('user.source');
    Route::get('/admin/user/{id}/edit','UserController@edit')->name('user.edit');
    Route::get('/admin/user/{id}/show','UserController@show')->name('user.show');
    Route::get('/admin/user/{id}/destroy','UserController@destroy')->name('user.destroy');
    Route::post('/admin/user/store','UserController@store')->name('user.store');
    Route::post('/admin/user/{id}/update','UserController@update')->name('user.update');
    Route::get('/admin/user/change','UserController@change')->name('user.change');
    Route::post('/admin/user/updatePassword','UserController@updatePassword')->name('user.updatePassword');

    //role
    Route::get('/admin/role','RoleController@index')->name('role.index');
    Route::get('/admin/role/create','RoleController@create')->name('role.create');
    Route::get('/admin/role/source','RoleController@source')->name('role.source');
    Route::get('/admin/role/{id}/edit','RoleController@edit')->name('role.edit');
    Route::get('/admin/role/{id}/show','RoleController@show')->name('role.show');
    Route::get('/admin/role/{id}/destroy','RoleController@destroy')->name('role.destroy');
    Route::post('/admin/role/store','RoleController@store')->name('role.store');
    Route::post('/admin/role/{id}/update','RoleController@update')->name('role.update');

    //article
    Route::get('/admin/article/{menu_id}','ArticleController@index')->name('article.index');
    Route::get('/admin/article/{menu_id}/create','ArticleController@create')->name('article.create');
    Route::get('/admin/article/{menu_id}/source','ArticleController@source')->name('article.source');
    Route::get('/admin/article/{id}/edit/{menu_id}','ArticleController@edit')->name('article.edit');
    Route::get('/admin/article/{id}/show/{menu_id}','ArticleController@show')->name('article.show');
    Route::get('/admin/article/{id}/destroy/{menu_id}','ArticleController@destroy')->name('article.destroy');
    Route::post('/admin/article/store','ArticleController@store')->name('article.store');
    Route::post('/admin/article/{id}/update','ArticleController@update')->name('article.update');
    Route::get('/admin/article/{id}/getImage','ArticleController@getImage')->name('article.getImage');
    Route::get('/admin/article/{id}/destroyImage','ArticleController@destroyImage')->name('article.destroyImage');

    //menuType
    Route::get('/admin/menuType','MenuTypeController@index')->name('menuType.index');
    Route::get('/admin/menuType/create','MenuTypeController@create')->name('menuType.create');
    Route::get('/admin/menuType/source','MenuTypeController@source')->name('menuType.source');
    Route::get('/admin/menuType/{id}/edit','MenuTypeController@edit')->name('menuType.edit');
    Route::get('/admin/menuType/{id}/show','MenuTypeController@show')->name('menuType.show');
    Route::get('/admin/menuType/{id}/destroy','MenuTypeController@destroy')->name('menuType.destroy');
    Route::post('/admin/menuType/store','MenuTypeController@store')->name('menuType.store');
    Route::post('/admin/menuType/{id}/update','MenuTypeController@update')->name('menuType.update');
    Route::get('/admin/menuType/{id}/orderUp','MenuTypeController@orderUp')->name('menuType.orderUp');
    Route::get('/admin/menuType/{id}/orderDown','MenuTypeController@orderDown')->name('menuType.orderDown');
    Route::get('/admin/menuType/{id}/destroyImage','MenuTypeController@destroyImage')->name('menuType.destroyImage');

    //menu
    Route::get('/admin/menu','MenuController@index')->name('menu.index');
    Route::get('/admin/menu/create','MenuController@create')->name('menu.create');
    Route::get('/admin/menu/source','MenuController@source')->name('menu.source');
    Route::get('/admin/menu/{id}/edit','MenuController@edit')->name('menu.edit');
    Route::get('/admin/menu/{id}/show','MenuController@show')->name('menu.show');
    Route::get('/admin/menu/{id}/destroy','MenuController@destroy')->name('menu.destroy');
    Route::post('/admin/menu/store','MenuController@store')->name('menu.store');
    Route::post('/admin/menu/{id}/update','MenuController@update')->name('menu.update');
    Route::get('/admin/menu/{id}/orderUp','MenuController@orderUp')->name('menu.orderUp');
    Route::get('/admin/menu/{id}/orderDown','MenuController@orderDown')->name('menu.orderDown');
    Route::get('/admin/menu/{id}/destroyImage','MenuController@destroyImage')->name('menu.destroyImage');

    //product
    Route::get('/admin/product/{menu_id}','ProductController@index')->name('product.index');
    Route::get('/admin/product/create/{menu_id}','ProductController@create')->name('product.create');
    Route::get('/admin/product/source/{menu_id}','ProductController@source')->name('product.source');
    Route::get('/admin/product/{id}/edit/{menu_id}','ProductController@edit')->name('product.edit');
    Route::get('/admin/product/{id}/show/{menu_id}','ProductController@show')->name('product.show');
    Route::get('/admin/product/{id}/destroy/{menu_id}','ProductController@destroy')->name('product.destroy');
    Route::post('/admin/product/store','ProductController@store')->name('product.store');
    Route::post('/admin/product/{id}/update','ProductController@update')->name('product.update');
    Route::get('/admin/product/{id}/getImage','ProductController@getImage')->name('product.getImage');
    Route::get('/admin/product/{id}/destroyImage','ProductController@destroyImage')->name('product.destroyImage');

    //pages
    Route::get('/admin/pages/{menu_id}','PagesController@index')->name('pages.index');
    Route::post('/admin/pages/{menu_id}/update','PagesController@update')->name('pages.update');

    //slideshow
    Route::get('/admin/slideshow','SlideshowController@index')->name('slideshow.index');
    Route::get('/admin/slideshow/create','SlideshowController@create')->name('slideshow.create');
    Route::get('/admin/slideshow/source','SlideshowController@source')->name('slideshow.source');
    Route::get('/admin/slideshow/{id}/edit','SlideshowController@edit')->name('slideshow.edit');
    Route::get('/admin/slideshow/{id}/show','SlideshowController@show')->name('slideshow.show');
    Route::get('/admin/slideshow/{id}/destroy','SlideshowController@destroy')->name('slideshow.destroy');
    Route::post('/admin/slideshow/store','SlideshowController@store')->name('slideshow.store');
    Route::post('/admin/slideshow/{id}/update','SlideshowController@update')->name('slideshow.update');

    //socmed
    Route::get('/admin/socmed','SocmedController@index')->name('socmed.index');
    Route::get('/admin/socmed/create','SocmedController@create')->name('socmed.create');
    Route::get('/admin/socmed/source','SocmedController@source')->name('socmed.source');
    Route::get('/admin/socmed/{id}/edit','SocmedController@edit')->name('socmed.edit');
    Route::get('/admin/socmed/{id}/show','SocmedController@show')->name('socmed.show');
    Route::get('/admin/socmed/{id}/destroy','SocmedController@destroy')->name('socmed.destroy');
    Route::post('/admin/socmed/store','SocmedController@store')->name('socmed.store');
    Route::post('/admin/socmed/{id}/update','SocmedController@update')->name('socmed.update');

    //category
    Route::get('/admin/category','CategoryController@index')->name('category.index');
    Route::get('/admin/category/create','CategoryController@create')->name('category.create');
    Route::get('/admin/category/source','CategoryController@source')->name('category.source');
    Route::get('/admin/category/{id}/edit','CategoryController@edit')->name('category.edit');
    Route::get('/admin/category/{id}/show','CategoryController@show')->name('category.show');
    Route::get('/admin/category/{id}/destroy','CategoryController@destroy')->name('category.destroy');
    Route::post('/admin/category/store','CategoryController@store')->name('category.store');
    Route::post('/admin/category/{id}/update','CategoryController@update')->name('category.update');

    //gallery
    Route::get('/admin/gallery/{menu_id}','GalleryController@index')->name('gallery.index');
    Route::get('/admin/gallery/create/{menu_id}','GalleryController@create')->name('gallery.create');
    Route::get('/admin/gallery/source/{menu_id}','GalleryController@source')->name('gallery.source');
    Route::get('/admin/gallery/{id}/edit/{menu_id}','GalleryController@edit')->name('gallery.edit');
    Route::get('/admin/gallery/{id}/show/{menu_id}','GalleryController@show')->name('gallery.show');
    Route::get('/admin/gallery/{id}/destroy/{menu_id}','GalleryController@destroy')->name('gallery.destroy');
    Route::post('/admin/gallery/store','GalleryController@store')->name('gallery.store');
    Route::post('/admin/gallery/{id}/update','GalleryController@update')->name('gallery.update');
    Route::get('/admin/gallery/{id}/getImage','GalleryController@getImage')->name('gallery.getImage');
    Route::get('/admin/gallery/{id}/destroyImage','GalleryController@destroyImage')->name('gallery.destroyImage');

    //video
    Route::get('/admin/video/{menu_id}','VideoController@index')->name('video.index');
    Route::get('/admin/video/create/{menu_id}','VideoController@create')->name('video.create');
    Route::get('/admin/video/source/{menu_id}','VideoController@source')->name('video.source');
    Route::get('/admin/video/{id}/edit/{menu_id}','VideoController@edit')->name('video.edit');
    Route::get('/admin/video/{id}/show/{menu_id}','VideoController@show')->name('video.show');
    Route::get('/admin/video/{id}/destroy/{menu_id}','VideoController@destroy')->name('video.destroy');
    Route::post('/admin/video/store','VideoController@store')->name('video.store');
    Route::post('/admin/video/{id}/update','VideoController@update')->name('video.update');

    //service
    Route::get('/admin/service/{menu_id}','ServiceController@index')->name('service.index');
    Route::get('/admin/service/create/{menu_id}','ServiceController@create')->name('service.create');
    Route::get('/admin/service/source/{menu_id}','ServiceController@source')->name('service.source');
    Route::get('/admin/service/{id}/edit/{menu_id}','ServiceController@edit')->name('service.edit');
    Route::get('/admin/service/{id}/show/{menu_id}','ServiceController@show')->name('service.show');
    Route::get('/admin/service/{id}/destroy/{menu_id}','ServiceController@destroy')->name('service.destroy');
    Route::post('/admin/service/store','ServiceController@store')->name('service.store');
    Route::post('/admin/service/{id}/update','ServiceController@update')->name('service.update');

    //promo
    Route::get('/admin/promo/{menu_id}','PromoController@index')->name('promo.index');
    Route::get('/admin/promo/create/{menu_id}','PromoController@create')->name('promo.create');
    Route::get('/admin/promo/source/{menu_id}','PromoController@source')->name('promo.source');
    Route::get('/admin/promo/{id}/edit/{menu_id}','PromoController@edit')->name('promo.edit');
    Route::get('/admin/promo/{id}/show/{menu_id}','PromoController@show')->name('promo.show');
    Route::get('/admin/promo/{id}/destroy/{menu_id}','PromoController@destroy')->name('promo.destroy');
    Route::post('/admin/promo/store','PromoController@store')->name('promo.store');
    Route::post('/admin/promo/{id}/update','PromoController@update')->name('promo.update');
    Route::get('/admin/promo/{id}/getImage','PromoController@getImage')->name('promo.getImage');

    //setting
    Route::get('/admin/setting','SettingController@index')->name('setting.index');
    Route::get('/admin/setting/create','SettingController@create')->name('setting.create');
    Route::get('/admin/setting/source','SettingController@source')->name('setting.source');
    Route::get('/admin/setting/{id}/edit','SettingController@edit')->name('setting.edit');
    Route::get('/admin/setting/{id}/show','SettingController@show')->name('setting.show');
    Route::get('/admin/setting/{id}/destroy','SettingController@destroy')->name('setting.destroy');
    Route::post('/admin/setting/store','SettingController@store')->name('setting.store');
    Route::post('/admin/setting/change','SettingController@change')->name('setting.change');
    Route::post('/admin/setting/{id}/update','SettingController@update')->name('setting.update');

    //portofolio
    Route::get('/admin/portofolio/{menu_id}','PortofolioController@index')->name('portofolio.index');
    Route::get('/admin/portofolio/create/{menu_id}','PortofolioController@create')->name('portofolio.create');
    Route::get('/admin/portofolio/source/{menu_id}','PortofolioController@source')->name('portofolio.source');
    Route::get('/admin/portofolio/{id}/edit/{menu_id}','PortofolioController@edit')->name('portofolio.edit');
    Route::get('/admin/portofolio/{id}/show/{menu_id}','PortofolioController@show')->name('portofolio.show');
    Route::get('/admin/portofolio/{id}/destroy/{menu_id}','PortofolioController@destroy')->name('portofolio.destroy');
    Route::post('/admin/portofolio/store','PortofolioController@store')->name('portofolio.store');
    Route::post('/admin/portofolio/{id}/update','PortofolioController@update')->name('portofolio.update');
    Route::get('/admin/portofolio/{id}/getImage','PortofolioController@getImage')->name('portofolio.getImage');

});

Route::get('/{slug_menu}/{slug_detail?}','IndexController@menu')->name('index.menu');
