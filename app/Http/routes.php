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
Route::get('dropzone', 'DropzoneController@index');
Route::post('dropzone/uploadFiles', 'DropzoneController@uploadFiles');
Route::post('dropzone/removeFile', 'DropzoneController@removeFile');
Route::get('dropzone/getPreviousUploaded', 'DropzoneController@getPreviousUploaded');

Route::get('/', 'HomeController@index')->middleware(['auth','menu']);

Route::get('/test', 'Test@index');

Route::get('/download/file/{id}', 'DownloadController@downloadFile');
Route::get('/api/loadNotification', 'NotificationController@loadNotification');
Route::post('/api/sendNotification', 'NotificationController@sendNotification');
Route::post('/api/readNotification', 'NotificationController@readNotification');

Route::auth();

Route::get('/home', 'HomeController@index')->middleware(['auth','menu']);

//User
Route::group(['middleware' => ['auth', 'menu']], function(){
    Route::post('user/apiList', 'UserController@apiList');
    Route::post('user/apiDelete', 'UserController@apiDelete');
    Route::get('change-password', 'UserController@changePassword');
    Route::post('change-password', 'UserController@postChangePassword');
    Route::get('profile', 'UserController@viewProfile');
    Route::resource('user', 'UserController');
});

Route::group(['middleware' => ['auth', 'menu']], function() {
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

        //Agenda Type
        Route::post('agendatype/apiList', 'AgendaTypeController@apiList');
        Route::post('agendatype/apiDelete', 'AgendaTypeController@apiDelete');
        Route::resource('agendatype', 'AgendaTypeController');

        //Brand
        Route::post('brand/apiList', 'BrandController@apiList');
        Route::post('brand/apiDelete', 'BrandController@apiDelete');
        Route::resource('brand', 'BrandController');

        //Client
        Route::post('client/apiList', 'ClientController@apiList');
        Route::post('client/apiDelete', 'ClientController@apiDelete');
        Route::get('client/apiSearch/{query}', 'ClientController@apiSearch');
        Route::resource('client', 'ClientController');

        //Client Contact
        Route::post('clientcontact/apiSave', 'ClientContactController@apiSave');
        Route::post('clientcontact/apiDelete', 'ClientContactController@apiDelete');
        Route::post('clientcontact/apiList', 'ClientContactController@apiList');
        Route::post('clientcontact/apiEdit', 'ClientContactController@apiEdit');
        Route::get('clientcontact/apiSearch/{query}', 'ClientContactController@apiSearch');

        //Client Type
        Route::post('clienttype/apiList', 'ClientTypeController@apiList');
        Route::post('clienttype/apiDelete', 'ClientTypeController@apiDelete');
        Route::resource('clienttype', 'ClientTypeController');

        //Creative Format
        Route::post('creativeformat/apiList', 'CreativeFormatController@apiList');
        Route::post('creativeformat/apiDelete', 'CreativeFormatController@apiDelete');
        Route::resource('creativeformat', 'CreativeFormatController');

        //Event Type
        Route::post('eventtype/apiList', 'EventTypeController@apiList');
        Route::post('eventtype/apiDelete', 'EventTypeController@apiDelete');
        Route::resource('eventtype', 'EventTypeController');

        //Flow
        Route::post('flow/apiList', 'FlowController@apiList');
        Route::post('flow/apiDelete', 'FlowController@apiDelete');
        Route::post('flow/apiCountFlow', 'FlowController@apiCountFlow');
        Route::resource('flow', 'FlowController');

        //Flow Group
        Route::post('flowgroup/apiList', 'FlowGroupController@apiList');
        Route::post('flowgroup/apiDelete', 'FlowGroupController@apiDelete');
        Route::resource('flowgroup', 'FlowGroupController');

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

        //Notification Type
        Route::post('notificationtype/apiList', 'NotificationTypeController@apiList');
        Route::post('notificationtype/apiDelete', 'NotificationTypeController@apiDelete');
        Route::resource('notificationtype', 'NotificationTypeController');

        //Paper Type
        Route::post('paper/apiList', 'PaperController@apiList');
        Route::post('paper/apiDelete', 'PaperController@apiDelete');
        Route::resource('paper', 'PaperController');

        //Proposal Type
        Route::post('proposaltype/apiList', 'ProposalTypeController@apiList');
        Route::post('proposaltype/apiDelete', 'ProposalTypeController@apiDelete');
        Route::resource('proposaltype', 'ProposalTypeController');

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

    Route::group(['prefix' => 'plan'], function() {
        //Action Plan
        Route::post('actionplan/apiList/{listtype}', 'ActionPlanController@apiList');
        Route::post('actionplan/apiDelete', 'ActionPlanController@apiDelete');
        Route::resource('actionplan', 'ActionPlanController');
        Route::get('actionplan/approve/{flow_no}/{id}', 'ActionPlanController@approve');
        Route::post('actionplan/approve/{flow_no}/{id}', 'ActionPlanController@postApprove');

        //Creative Plan
        Route::post('creativeplan/apiList/{listtype}', 'CreativeController@apiList');
        Route::post('creativeplan/apiDelete', 'CreativeController@apiDelete');
        Route::resource('creativeplan', 'CreativeController');
        Route::get('creativeplan/approve/{flow_no}/{id}', 'CreativeController@approve');
        Route::post('creativeplan/approve/{flow_no}/{id}', 'CreativeController@postApprove');

        //Event Plan
        Route::post('eventplan/apiList/{listtype}', 'EventPlanController@apiList');
        Route::post('eventplan/apiDelete', 'EventPlanController@apiDelete');
        Route::resource('eventplan', 'EventPlanController');
        Route::get('eventplan/approve/{flow_no}/{id}', 'EventPlanController@approve');
        Route::post('eventplan/approve/{flow_no}/{id}', 'EventPlanController@postApprove');
    });

    Route::group(['prefix' => 'agenda'], function() {
        //Agenda Plan
        Route::post('plan/apiList', 'AgendaController@apiList');
        Route::post('plan/apiDelete', 'AgendaController@apiDelete');
        Route::resource('plan', 'AgendaController');
    });

    Route::group(['prefix' => 'config'], function() {
        //Announcement Management
        Route::post('announcement/apiList', 'AnnouncementController@apiList');
        Route::post('announcement/apiDelete', 'AnnouncementController@apiDelete');
        Route::resource('announcement', 'AnnouncementController');

        //Application Setting
        Route::post('setting/apiList', 'SettingController@apiList');
        Route::post('setting/apiDelete', 'SettingController@apiDelete');
        Route::resource('setting', 'SettingController');
    });
});
