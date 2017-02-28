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
Route::get('/api/loadPlan', 'HomeController@apiPlan')->middleware(['auth','menu']);
Route::get('/api/loadUpcomingPlan/{mode}/{day}', 'HomeController@apiUpcomingPlan')->middleware(['auth','menu']);

Route::get('/test', 'Test@index');
Route::get('/import_data/{table}', 'Test@import_data');

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
    Route::post('user/apiSearch', 'UserController@apiSearch');
    Route::get('change-password', 'UserController@changePassword');
    Route::post('change-password', 'UserController@postChangePassword');
    Route::get('profile', 'UserController@viewProfile');
    Route::resource('user', 'UserController');
    Route::post('editProfile', 'UserController@postEditProfile');
    Route::post('uploadAvatar', 'UserController@postUploadAvatar');
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

        //Activity Type
        Route::post('activitytype/apiList', 'ActivityTypeController@apiList');
        Route::post('activitytype/apiDelete', 'ActivityTypeController@apiDelete');
        Route::resource('activitytype', 'ActivityTypeController');

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
        Route::post('brand/apiSearch', 'BrandController@apiSearch');

        //Client
        Route::post('client/apiList', 'ClientController@apiList');
        Route::post('client/apiDelete', 'ClientController@apiDelete');
        Route::get('client/apiSearch/{query}', 'ClientController@apiSearch');
        Route::post('client/apiSearch', 'ClientController@apiSearchPost');
        Route::resource('client', 'ClientController');

        //Client Contact
        Route::post('clientcontact/apiSave', 'ClientContactController@apiSave');
        Route::post('clientcontact/apiDelete', 'ClientContactController@apiDelete');
        Route::post('clientcontact/apiList', 'ClientContactController@apiList');
        Route::post('clientcontact/apiEdit', 'ClientContactController@apiEdit');
        Route::get('clientcontact/apiSearch/{query}', 'ClientContactController@apiSearch');
        Route::post('clientcontact/apiSearchPerClient', 'ClientContactController@apiSearchPerClient');

        //Client Type
        Route::post('clienttype/apiList', 'ClientTypeController@apiList');
        Route::post('clienttype/apiDelete', 'ClientTypeController@apiDelete');
        Route::resource('clienttype', 'ClientTypeController');

        //Creative Format
        Route::post('creativeformat/apiList', 'CreativeFormatController@apiList');
        Route::post('creativeformat/apiDelete', 'CreativeFormatController@apiDelete');
        Route::resource('creativeformat', 'CreativeFormatController');

        //Event Type / Program Type
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

        //Location
        Route::post('location/apiList', 'LocationController@apiList');
        Route::post('location/apiDelete', 'LocationController@apiDelete');
        Route::resource('location', 'LocationController');

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
        Route::post('mediagroup/apiGetOption', 'MediaGroupController@apiGetOption');
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

        //Price Type
        Route::post('pricetype/apiList', 'PriceTypeController@apiList');
        Route::post('pricetype/apiDelete', 'PriceTypeController@apiDelete');
        Route::resource('pricetype', 'PriceTypeController');

        //Project Task Type
        Route::post('projecttasktype/apiList', 'ProjectTaskTypeController@apiList');
        Route::post('projecttasktype/apiDelete', 'ProjectTaskTypeController@apiDelete');
        Route::resource('projecttasktype', 'ProjectTaskTypeController');

        //Proposal Type
        Route::post('proposaltype/apiList', 'ProposalTypeController@apiList');
        Route::post('proposaltype/apiDelete', 'ProposalTypeController@apiDelete');
        Route::resource('proposaltype', 'ProposalTypeController');

        //Publisher
        Route::post('publisher/apiList', 'PublisherController@apiList');
        Route::post('publisher/apiDelete', 'PublisherController@apiDelete');
        Route::resource('publisher', 'PublisherController');

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
        Route::post('actionplan/apigetmediapermediagroup', 'ActionPlanController@apiGetMediaPerMediaGroup');
        Route::post('actionplan/apiSearch', 'ActionPlanController@apiSearch');

        //Creative Plan
        Route::post('creativeplan/apiList/{listtype}', 'CreativeController@apiList');
        Route::post('creativeplan/apiDelete', 'CreativeController@apiDelete');
        Route::resource('creativeplan', 'CreativeController');
        Route::get('creativeplan/approve/{flow_no}/{id}', 'CreativeController@approve');
        Route::post('creativeplan/approve/{flow_no}/{id}', 'CreativeController@postApprove');

        //Event Plan / Program Plan
        Route::post('eventplan/apiList/{listtype}', 'EventPlanController@apiList');
        Route::post('eventplan/apiDelete', 'EventPlanController@apiDelete');
        Route::resource('eventplan', 'EventPlanController');
        Route::get('eventplan/approve/{flow_no}/{id}', 'EventPlanController@approve');
        Route::post('eventplan/approve/{flow_no}/{id}', 'EventPlanController@postApprove');
        Route::post('eventplan/apiSearch', 'EventPlanController@apiSearch');
    });

    Route::group(['prefix' => 'agenda'], function() {
        //Activity
        Route::post('activity/apiList', 'ActivityController@apiList');
        Route::post('activity/apiDelete', 'ActivityController@apiDelete');
        Route::resource('activity', 'ActivityController');

        //Agenda Plan
        Route::post('plan/apiList', 'AgendaController@apiList');
        Route::post('plan/apiDelete', 'AgendaController@apiDelete');
        Route::resource('plan', 'AgendaController');
    });

    Route::group(['prefix' => 'inventory'], function() {
        //Inventory Planner
        Route::post('inventoryplanner/apiList/{listtype}', 'InventoryPlannerController@apiList');
        Route::post('inventoryplanner/apiDelete', 'InventoryPlannerController@apiDelete');
        Route::resource('inventoryplanner', 'InventoryPlannerController');
        Route::get('inventoryplanner/approve/{flow_no}/{id}', 'InventoryPlannerController@approve');
        Route::post('inventoryplanner/approve/{flow_no}/{id}', 'InventoryPlannerController@postApprove');
        Route::post('inventoryplanner/api/getMedias', 'InventoryPlannerController@apiGetMedias');
        Route::post('inventoryplanner/api/getRates', 'InventoryPlannerController@apiGetRates');
        Route::post('inventoryplanner/api/getBasicRate', 'InventoryPlannerController@apiGetBasicRate');
        Route::post('inventoryplanner/api/storePrintPrices', 'InventoryPlannerController@apiStorePrintPrices');
        Route::post('inventoryplanner/api/deletePrintPrices', 'InventoryPlannerController@apiDeletePrintPrices');
        Route::get('inventoryplanner/api/loadPrintPrices', 'InventoryPlannerController@apiLoadPrintPrices');
        Route::post('inventoryplanner/api/storeDigitalPrices', 'InventoryPlannerController@apiStoreDigitalPrices');
        Route::post('inventoryplanner/api/deleteDigitalPrices', 'InventoryPlannerController@apiDeleteDigitalPrices');
        Route::get('inventoryplanner/api/loadDigitalPrices', 'InventoryPlannerController@apiLoadDigitalPrices');
        Route::post('inventoryplanner/api/storeEventPrices', 'InventoryPlannerController@apiStoreEventPrices');
        Route::post('inventoryplanner/api/deleteEventPrices', 'InventoryPlannerController@apiDeleteEventPrices');
        Route::get('inventoryplanner/api/loadEventPrices', 'InventoryPlannerController@apiLoadEventPrices');
        Route::post('inventoryplanner/api/storeCreativePrices', 'InventoryPlannerController@apiStoreCreativePrices');
        Route::post('inventoryplanner/api/deleteCreativePrices', 'InventoryPlannerController@apiDeleteCreativePrices');
        Route::get('inventoryplanner/api/loadCreativePrices', 'InventoryPlannerController@apiLoadCreativePrices');
        Route::post('inventoryplanner/api/storeOtherPrices', 'InventoryPlannerController@apiStoreOtherPrices');
        Route::post('inventoryplanner/api/deleteOtherPrices', 'InventoryPlannerController@apiDeleteOtherPrices');
        Route::get('inventoryplanner/api/loadOtherPrices', 'InventoryPlannerController@apiLoadOtherPrices');
        Route::post('inventoryplanner/apiSearch', 'InventoryPlannerController@apiSearch');
    });

    Route::group(['prefix' => 'workorder'], function() {
        Route::post('proposal/apiList/{listtype}', 'ProposalController@apiList');
        Route::post('proposal/apiDelete', 'ProposalController@apiDelete');
        Route::resource('proposal', 'ProposalController');
        Route::get('proposal/approve/{flow_no}/{id}', 'ProposalController@approve');
        Route::post('proposal/approve/{flow_no}/{id}', 'ProposalController@postApprove');
        Route::post('proposal/api/getMedias', 'ProposalController@apiGetMedias');
        Route::post('proposal/api/generateDeadline', 'ProposalController@apiGenerateDeadline');
        Route::post('proposal/api/getRates', 'ProposalController@apiGetRates');
        Route::post('proposal/api/getBasicRate', 'ProposalController@apiGetBasicRate');
        Route::post('proposal/api/storePrintPrices', 'ProposalController@apiStorePrintPrices');
        Route::post('proposal/api/deletePrintPrices', 'ProposalController@apiDeletePrintPrices');
        Route::get('proposal/api/loadPrintPrices', 'ProposalController@apiLoadPrintPrices');
        Route::post('proposal/api/storeDigitalPrices', 'ProposalController@apiStoreDigitalPrices');
        Route::post('proposal/api/deleteDigitalPrices', 'ProposalController@apiDeleteDigitalPrices');
        Route::get('proposal/api/loadDigitalPrices', 'ProposalController@apiLoadDigitalPrices');
        Route::post('proposal/api/storeEventPrices', 'ProposalController@apiStoreEventPrices');
        Route::post('proposal/api/deleteEventPrices', 'ProposalController@apiDeleteEventPrices');
        Route::get('proposal/api/loadEventPrices', 'ProposalController@apiLoadEventPrices');
        Route::post('proposal/api/storeCreativePrices', 'ProposalController@apiStoreCreativePrices');
        Route::post('proposal/api/deleteCreativePrices', 'ProposalController@apiDeleteCreativePrices');
        Route::get('proposal/api/loadCreativePrices', 'ProposalController@apiLoadCreativePrices');
        Route::post('proposal/api/storeOtherPrices', 'ProposalController@apiStoreOtherPrices');
        Route::post('proposal/api/deleteOtherPrices', 'ProposalController@apiDeleteOtherPrices');
        Route::get('proposal/api/loadOtherPrices', 'ProposalController@apiLoadOtherPrices');
        Route::post('proposal/apiSearch', 'ProposalController@apiSearch');
    });

    Route::group(['prefix' => 'grid'], function() {
        //Project
        Route::post('project/apiList/{listtype}', 'ProjectController@apiList');
        Route::post('project/apiDelete', 'ProjectController@apiDelete');
        Route::post('project/apiSearch', 'ProjectController@apiSearch');
        Route::resource('project', 'ProjectController');
        Route::get('project/approve/{flow_no}/{id}', 'ProjectController@approve');
        Route::post('project/approve/{flow_no}/{id}', 'ProjectController@postApprove');

        //Project Task
        Route::post('projecttask/apiList/{listtype}', 'ProjectTaskController@apiList');
        Route::post('projecttask/apiDelete', 'ProjectTaskController@apiDelete');
        Route::get('projecttask/api/loadTasks/{pics}/{authors}/{types}/{projects}', 'ProjectTaskController@apiLoadTaskDeadline');
        Route::resource('projecttask', 'ProjectTaskController');
        Route::get('projecttask/approve/{flow_no}/{id}', 'ProjectTaskController@approve');
        Route::post('projecttask/approve/{flow_no}/{id}', 'ProjectTaskController@postApprove');

        //Proposal
        Route::post('proposal/apiList/{listtype}', 'GridProposalController@apiList');
        Route::post('proposal/apiDelete', 'GridProposalController@apiDelete');
        Route::resource('proposal', 'GridProposalController');
        Route::get('proposal/approve/{flow_no}/{id}', 'GridProposalController@approve');
        Route::post('proposal/approve/{flow_no}/{id}', 'GridProposalController@postApprove');

        //Project Report
        Route::get('report', 'ReportGridController@index');
        Route::post('report/api/generateReport', 'ReportGridController@apiGenerateReport');

        //Proposal Report
        Route::get('report-proposal', 'ReportGridController@proposal');
        Route::post('report-proposal/api/generateReport', 'ReportGridController@apiGenerateReportProposal');
        Route::get('report-proposal/api/getTotalProposalPerMonth', 'ReportGridController@apiGetTotalProposalPerMonth');
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
        Route::post('setting/clearCache', 'SettingController@apiClearCache');

        //User Log
        Route::post('log/apiList', 'LogController@apiList');
        Route::resource('log', 'LogController');
    });
});
