<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('home');
});*/

Route::get('/', 'HomeController@index');

Route::get('/test', 'Test@index');

Route::auth();

Route::get('/home', 'HomeController@index');

//Role
Route::post('user/apiList', 'UserController@apiList');
Route::post('user/apiDelete', 'UserController@apiDelete');
Route::resource('user', 'UserController');

Route::group(['middleware' => 'auth'], function() {
    //
    Route::group(['prefix' => 'master'], function() {

        //Action Control
        Route::post('action/apiList', 'ActionController@apiList');
        Route::post('action/apiDelete', 'ActionController@apiDelete');
        Route::resource('action', 'ActionController');

        //Action Type
        Route::post('actiontype/apiList', 'ActionTypeController@apiList');
        Route::post('actiontype/apiDelete', 'ActionTypeController@apiDelete');
        Route::resource('actiontype', 'ActionTypeController');

        //Advertise Position
        Route::post('advertiseposition/apiList', 'AdvertisePositionController@apiList');
        Route::post('advertiseposition/apiDelete', 'AdvertisePositionController@apiDelete');
        Route::resource('advertiseposition', 'AdvertisePositionController');

        //Advertise Rate
        Route::post('advertiserate/apiList', 'AdvertiseRateController@apiList');
        Route::post('advertiserate/apiDelete', 'AdvertiseRateController@apiDelete');
        Route::resource('advertiserate', 'AdvertiseRateController');

        //Advertise Size
        Route::post('advertisesize/apiList', 'AdvertiseSizeController@apiList');
        Route::post('advertisesize/apiDelete', 'AdvertiseSizeController@apiDelete');
        Route::resource('advertisesize', 'AdvertiseSizeController');

        //Brand
        Route::post('brand/apiList', 'BrandController@apiList');
        Route::post('brand/apiDelete', 'BrandController@apiDelete');
        Route::resource('brand', 'BrandController');

        //Client
        Route::post('client/apiList', 'ClientController@apiList');
        Route::post('client/apiDelete', 'ClientController@apiDelete');
        Route::resource('client', 'ClientController');

        //Client Type
        Route::post('clienttype/apiList', 'ClientTypeController@apiList');
        Route::post('clienttype/apiDelete', 'ClientTypeController@apiDelete');
        Route::resource('clienttype', 'ClientTypeController');

        //Group
        Route::post('group/apiList', 'GroupController@apiList');
        Route::post('group/apiDelete', 'GroupController@apiDelete');
        Route::resource('group', 'GroupController');

        //Holiday
        Route::post('holiday/apiList', 'HolidayController@apiList');
        Route::post('holiday/apiDelete', 'HolidayController@apiDelete');
        Route::resource('holiday', 'HolidayController');

        //Industry
        Route::post('industry/apiList', 'IndustryController@apiList');
        Route::post('industry/apiDelete', 'IndustryController@apiDelete');
        Route::resource('industry', 'IndustryController');

        //Inventory Type
        Route::post('inventorytype/apiList', 'InventoryTypeController@apiList');
        Route::post('inventorytype/apiDelete', 'InventoryTypeController@apiDelete');
        Route::resource('inventorytype', 'InventoryTypeController');

        //Media
        Route::post('media/apiList', 'MediaController@apiList');
        Route::post('media/apiDelete', 'MediaController@apiDelete');
        Route::resource('media', 'MediaController');

        //Media Category
        Route::post('mediacategory/apiList', 'MediaCategoryController@apiList');
        Route::post('mediacategory/apiDelete', 'MediaCategoryController@apiDelete');
        Route::resource('mediacategory', 'MediaCategoryController');

        //Media Edition
        Route::post('mediaedition/apiSave', 'MediaEditionController@apiSave');
        Route::post('mediaedition/apiDelete', 'MediaEditionController@apiDelete');
        Route::post('mediaedition/apiList', 'MediaEditionController@apiList');
        Route::post('mediaedition/apiEdit', 'MediaEditionController@apiEdit');

        //Media Group
        Route::post('mediagroup/apiList', 'MediaGroupController@apiList');
        Route::post('mediagroup/apiDelete', 'MediaGroupController@apiDelete');
        Route::resource('mediagroup', 'MediaGroupController');

        //Menu
        Route::post('menu/apiList', 'MenuController@apiList');
        Route::post('menu/apiDelete', 'MenuController@apiDelete');
        Route::post('menu/apiCountChild', 'MenuController@apiCountChild');
        Route::get('menu/generateMenu', 'MenuController@generateMenu');
        Route::resource('menu', 'MenuController');

        //Module
        Route::post('module/apiList', 'ModuleController@apiList');
        Route::post('module/apiDelete', 'ModuleController@apiDelete');
        Route::resource('module', 'ModuleController');

        //Paper Type
        Route::post('paper/apiList', 'PaperController@apiList');
        Route::post('paper/apiDelete', 'PaperController@apiDelete');
        Route::resource('paper', 'PaperController');

        //Religion
        Route::post('religion/apiList', 'ReligionController@apiList');
        Route::post('religion/apiEdit', 'ReligionController@apiEdit');
        Route::resource('religion', 'ReligionController');

        //Role
        Route::post('role/apiList', 'RoleController@apiList');
        Route::post('role/apiEdit', 'RoleController@apiEdit');
        Route::resource('role', 'RoleController');

        //Sub Industry
        Route::post('subindustry/apiList', 'SubIndustryController@apiList');
        Route::post('subindustry/apiDelete', 'SubIndustryController@apiDelete');
        Route::post('subindustry/apiGetOption', 'SubIndustryController@apiGetOption');
        Route::resource('subindustry', 'SubIndustryController');

        //Unit
        Route::post('unit/apiList', 'UnitController@apiList');
        Route::post('unit/apiDelete', 'UnitController@apiDelete');
        Route::resource('unit', 'UnitController');
    });
});
