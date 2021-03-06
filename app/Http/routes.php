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
Route::post('/api/proposalRecap', 'HomeController@apiProposalRecap')->middleware(['auth','menu']);
Route::post('/api/inventoryRecap', 'HomeController@apiInventoryRecap')->middleware(['auth','menu']);
Route::post('/api/agendaRecap', 'HomeController@apiAgendaRecap')->middleware(['auth','menu']);
Route::post('/api/contactRecap', 'HomeController@apiContactRecap')->middleware(['auth','menu']);
Route::post('/api/statisticsDetail', 'HomeController@apiStatisticsDetail')->middleware(['auth','menu']);

Route::get('/test', 'Test@index');
Route::get('/vue', 'Test@vue');
Route::get('/handsontable', 'Test@handsontable');
Route::get('/import_data/{table}', 'Test@import_data');

Route::get('/download/file/{id}', 'DownloadController@downloadFile');
Route::get('/api/loadNotification', 'NotificationController@loadNotification');
Route::get('/api/loadAllNotification', 'NotificationController@loadAllNotification');
Route::post('/api/sendNotification', 'NotificationController@sendNotification');
Route::post('/api/readNotification', 'NotificationController@readNotification');
Route::post('/api/deleteNotification', 'NotificationController@deleteNotification');
Route::get('/notification/all', 'NotificationController@viewAll');

Route::auth();

Route::post('/apiTest', 'AgendaController@apiTest')->middleware(['auth:api']);


Route::get('/home', 'HomeController@index')->middleware(['auth','menu']);

Route::group(['prefix'=>'public-api','middleware'=>'auth:api'], function(){
 
   Route::get('/test','Test@apiTest');
 
});

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

        Route::post('advertiseposition/api/all', 'AdvertisePositionController@apiGetAll');

        //Advertise Rate
        Route::post('advertiserate/apiList', 'AdvertiseRateController@apiList');
        Route::post('advertiserate/apiDelete', 'AdvertiseRateController@apiDelete');
        Route::resource('advertiserate', 'AdvertiseRateController');

        //Advertise Rate Type
        Route::post('advertiseratetype/apiList', 'AdvertiseRateTypeController@apiList');
        Route::post('advertiseratetype/apiDelete', 'AdvertiseRateTypeController@apiDelete');
        Route::resource('advertiseratetype', 'AdvertiseRateTypeController');

        Route::post('advertiseratetype/api/getRequiredFields', 'AdvertiseRateTypeController@apiGetRequiredFields');

        //Advertise Size
        Route::post('advertisesize/apiList', 'AdvertiseSizeController@apiList');
        Route::post('advertisesize/apiDelete', 'AdvertiseSizeController@apiDelete');
        Route::resource('advertisesize', 'AdvertiseSizeController');

        //Agenda Type
        Route::post('agendatype/apiList', 'AgendaTypeController@apiList');
        Route::post('agendatype/apiDelete', 'AgendaTypeController@apiDelete');
        Route::resource('agendatype', 'AgendaTypeController');

        //Brand
        Route::get('brand/recode/{from}/{limit}', 'BrandController@recode');
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
        Route::post('clientcontact/apiSearchPerMultipleClients', 'ClientContactController@apiSearchPerMultipleClients');

        //Client Type
        Route::post('clienttype/apiList', 'ClientTypeController@apiList');
        Route::post('clienttype/apiDelete', 'ClientTypeController@apiDelete');
        Route::resource('clienttype', 'ClientTypeController');

        //Color
        Route::post('color/apiList', 'ColorController@apiList');
        Route::post('color/apiDelete', 'ColorController@apiDelete');
        Route::resource('color', 'ColorController');

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
        Route::post('flow/apiGetFlow', 'FlowController@apiGetFlow');
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

        //Inventory Category
        Route::post('inventorycategory/apiList', 'InventoryCategoryController@apiList');
        Route::post('inventorycategory/apiDelete', 'InventoryCategoryController@apiDelete');
        Route::resource('inventorycategory', 'InventoryCategoryController');

        //Inventory Source
        Route::post('inventorysource/apiList', 'InventorySourceController@apiList');
        Route::post('inventorysource/apiDelete', 'InventorySourceController@apiDelete');
        Route::resource('inventorysource', 'InventorySourceController');

        //Inventory Type
        Route::post('inventorytype/apiList', 'InventoryTypeController@apiList');
        Route::post('inventorytype/apiDelete', 'InventoryTypeController@apiDelete');
        Route::resource('inventorytype', 'InventoryTypeController');

        //LetterType
        Route::post('lettertype/apiList', 'LetterTypeController@apiList');
        Route::post('lettertype/apiDelete', 'LetterTypeController@apiDelete');
        Route::resource('lettertype', 'LetterTypeController');

        //Location
        Route::post('location/apiList', 'LocationController@apiList');
        Route::post('location/apiDelete', 'LocationController@apiDelete');
        Route::resource('location', 'LocationController');

        //Media
        Route::post('media/apiList', 'MediaController@apiList');
        Route::post('media/apiDelete', 'MediaController@apiDelete');
        Route::resource('media', 'MediaController');
        Route::get('media/posisi_iklan/{media_id}', 'MediaController@posisi_iklan');
        Route::post('media/api/all', 'MediaController@apiAll');

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

        //Omzet Type
        Route::resource('omzettype', 'OmzetTypeController');
        Route::post('omzettype/api/all', 'OmzetTypeController@apiGetAll');

        //Organization
        Route::post('organization/apiList', 'OrganizationController@apiList');
        Route::post('organization/apiDelete', 'OrganizationController@apiDelete');
        Route::resource('organization', 'OrganizationController');

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

        //Rate
        Route::post('rate/apiList', 'RateController@apiList');
        Route::post('rate/apiDelete', 'RateController@apiDelete');
        Route::post('rate/apiSearch', 'RateController@apiSearchPost');
        Route::post('rate/apiSearchPerID', 'RateController@apiSearchPerID');
        Route::resource('rate', 'RateController');

        Route::post('rate/api/all', 'RateController@apiGetAll');
        Route::post('rate/api/name', 'RateController@apiGetByName');

        //Religion
        Route::post('religion/apiList', 'ReligionController@apiList');
        Route::post('religion/apiEdit', 'ReligionController@apiEdit');
        Route::resource('religion', 'ReligionController');

        //Role
        Route::post('role/apiList', 'RoleController@apiList');
        Route::post('role/apiEdit', 'RoleController@apiEdit');
        Route::resource('role', 'RoleController');

        //Spot Type
        Route::post('spottype/apiList', 'SpotTypeController@apiList');
        Route::post('spottype/apiDelete', 'SpotTypeController@apiDelete');
        Route::resource('spottype', 'SpotTypeController');

        //Studio
        Route::post('studio/apiList', 'StudioController@apiList');
        Route::post('studio/apiDelete', 'StudioController@apiDelete');
        Route::resource('studio', 'StudioController');

        //Sub Industry
        Route::post('subindustry/apiList', 'SubIndustryController@apiList');
        Route::post('subindustry/apiDelete', 'SubIndustryController@apiDelete');
        Route::post('subindustry/apiGetOption', 'SubIndustryController@apiGetOption');
        Route::resource('subindustry', 'SubIndustryController');

        //Target
        Route::post('target/apiList', 'TargetController@apiList');
        Route::post('target/apiDelete', 'TargetController@apiDelete');
        Route::post('target/api/generateCode', 'TargetController@apiGenerateCode');
        Route::resource('target', 'TargetController');

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
        Route::get('plan/do_report/{id}', 'AgendaController@doReport');
        Route::post('plan/do_report/{id}', 'AgendaController@postDoReport');
        Route::resource('plan', 'AgendaController');
        Route::get('plan/api/loadMyAgenda/{user_ids}/{client_id}', 'AgendaController@apiLoadMyAgenda');
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
        Route::get('inventoryplanner/renew/{id}', 'InventoryPlannerController@renew');
        Route::post('inventoryplanner/renew/{id}', 'InventoryPlannerController@postRenew');
        Route::get('inventoryplanner/api/apiLoadLastUpdated/{limit}', 'InventoryPlannerController@apiLoadLastUpdated');
    });

    Route::group(['prefix' => 'workorder'], function() {
        Route::post('proposal/apiList/{listtype}', 'ProposalController@apiList');
        Route::post('proposal/apiDelete', 'ProposalController@apiDelete');
        Route::resource('proposal', 'ProposalController');
        Route::get('proposal/action/{flow_no}/{id}', 'ProposalController@action');
        Route::post('proposal/action/{flow_no}/{id}', 'ProposalController@postAction');
        Route::get('proposal/approval/{flow_no}/{id}', 'ProposalController@approve');
        Route::post('proposal/approval/{flow_no}/{id}', 'ProposalController@postApprove');
        Route::get('proposal/approvalpic/{flow_no}/{id}', 'ProposalController@approvepic');
        Route::post('proposal/approvalpic/{flow_no}/{id}', 'ProposalController@postApprovepic');
        Route::get('proposal/formsubmit/{flow_no}/{id}', 'ProposalController@formsubmit');
        Route::post('proposal/formsubmit/{flow_no}/{id}', 'ProposalController@postFormsubmit');

        Route::get('proposal/create_direct/{inventory_planner_id}', 'ProposalController@createDirect');
        Route::post('proposal/create_direct/{inventory_planner_id}', 'ProposalController@postCreateDirect');

        Route::get('proposal/update_status/{id}', 'ProposalController@updateStatus');
        Route::post('proposal/update_status/{id}', 'ProposalController@postUpdateStatus');

        Route::get('proposal/summary/{id}', 'ProposalController@summary');

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

        //Summary
        Route::get('summary/create/{contract_id}', 'SummaryController@create');
        Route::post('summary/apiList/{listtype}', 'SummaryController@apiList');
        Route::resource('summary', 'SummaryController');
        Route::post('summary/api/saveDetails', 'SummaryController@apiSaveDetails');
        Route::get('summary/api/loadDetails', 'SummaryController@apiLoadDetails');
        Route::post('summary/api/getDetails', 'SummaryController@apiGetDetails');
        Route::get('summary/api/exportXls/{id}', 'SummaryController@apiExportXls');
        Route::get('summary/action/{flow_no}/{id}', 'SummaryController@action');
        Route::post('summary/action/{flow_no}/{id}', 'SummaryController@postAction');
        Route::get('summary/approval/{flow_no}/{id}', 'SummaryController@approve');
        Route::post('summary/approval/{flow_no}/{id}', 'SummaryController@postApprove');
        Route::get('summary/renew/{id}', 'SummaryController@renew');
        Route::post('summary/renew/{id}', 'SummaryController@postRenew');
        Route::post('summary/api/generatePosisiIklan', 'SummaryController@apiGeneratePosisiIklan');
        Route::get('tbc_item_list', 'SummaryController@toBeConfirmedItemList');
        Route::post('summary/api/tbc_item_list', 'SummaryController@apiToBeConfirmedItemList');

        /*Route::post('posisi_iklan/apiList', 'PosisiIklanController@apiList');
        Route::post('posisi_iklan/apiDelete', 'PosisiIklanController@apiDelete');
        Route::post('posisi_iklan/apiCheckCode', 'PosisiIklanController@apiCheckCode');
        Route::resource('posisi_iklan', 'PosisiIklanController');*/

        //Contract
        Route::post('contract/apiList/{listtype}', 'ContractController@apiList');
        Route::post('contract/apiDelete', 'ContractController@apiDelete');
        Route::get('contract/create/{proposal_id}', 'ContractController@create');
        Route::resource('contract', 'ContractController');
        Route::get('contract/action/{flow_no}/{id}', 'ContractController@action');
        Route::post('contract/action/{flow_no}/{id}', 'ContractController@postAction');
        Route::get('contract/approval/{flow_no}/{id}', 'ContractController@approve');
        Route::post('contract/approval/{flow_no}/{id}', 'ContractController@postApprove');
        Route::post('contract/apiSearch', 'ContractController@apiSearch');

        //Summary Delivered
        Route::post('summariesdelivered/apiList', 'SummariesDeliveredController@apiList');
        Route::get('summariesdelivered/assigned/{id}', 'SummariesDeliveredController@assigned');
        Route::post('summariesdelivered/assigned/{id}', 'SummariesDeliveredController@assignedPost');
        Route::resource('summariesdelivered', 'SummariesDeliveredController');

        //Summary Assigned
        Route::post('summariesassigned/apiList', 'SummariesAssignedController@apiList');
        Route::get('summariesassigned/update_posisi_iklan/{id}', 'SummariesAssignedController@updatePosisiIklan');
        Route::post('summariesassigned/update_posisi_iklan/{id}', 'SummariesAssignedController@postUpdatePosisiIklan');
        Route::resource('summariesassigned', 'SummariesAssignedController');
    });

    Route::group(['prefix' => 'posisi-iklan'], function() {
        //Checking Position
        Route::get('checking', 'CheckingPositionController@index');
        Route::post('checking/api/locking', 'CheckingPositionController@apiLocking');

        //Direct Order
        Route::post('direct-order/apiList', 'SummaryItemDirectController@apiList');
        Route::post('direct-order/apiDelete', 'SummaryItemDirectController@apiDelete');
        Route::resource('direct-order', 'SummaryItemDirectController');

        //Item Task
        Route::post('item_task/apiList/{listtype}', 'PosisiIklanItemTaskController@apiList');
        Route::get('item_task/take/{id}', 'PosisiIklanItemTaskController@take');
        Route::post('item_task/take/{id}', 'PosisiIklanItemTaskController@takePost');
        Route::get('item_task/update_task/{id}', 'PosisiIklanItemTaskController@updateTask');
        Route::post('item_task/update_task/{id}', 'PosisiIklanItemTaskController@updateTaskPost');
        Route::resource('item_task', 'PosisiIklanItemTaskController');
    });

    Route::group(['prefix' => 'secretarial'], function() {
        //Direct Letter
        Route::post('directletter/apiList', 'DirectLetterController@apiList');
        Route::post('directletter/apiDelete', 'DirectLetterController@apiDelete');
        Route::resource('directletter', 'DirectLetterController');

        //Order Letter
        Route::post('orderletter/apiList/{listtype}', 'LetterController@apiList');
        Route::post('orderletter/apiDelete', 'LetterController@apiDelete');
        Route::get('orderletter/create/{proposal_id}', 'LetterController@create');
        Route::resource('orderletter', 'LetterController');
        Route::get('orderletter/action/{flow_no}/{id}', 'LetterController@action');
        Route::post('orderletter/action/{flow_no}/{id}', 'LetterController@postAction');
        Route::get('orderletter/approval/{flow_no}/{id}', 'LetterController@approve');
        Route::post('orderletter/approval/{flow_no}/{id}', 'LetterController@postApprove');

        //View All Letter
        Route::post('allletter/apiList', 'AllLetterController@apiList');
        Route::resource('allletter', 'AllLetterController');
    });

    Route::group(['prefix' => 'report'], function() {
        //Report Inventory
        Route::get('inventory', 'ReportController@inventory');
        Route::post('api/generateInventoryReport', 'ReportController@apiGenerateInventoryReport');

        //Report Proposal
        Route::get('planner', 'ReportController@planner');
        Route::post('api/generatePlannerReport', 'ReportController@apiGeneratePlannerReport');
        
        //Report Proposal
        Route::get('proposal', 'ReportController@proposal');
        Route::post('api/generateProposalReport', 'ReportController@apiGenerateProposalReport');

        //Report Agenda
        Route::get('agenda', 'ReportController@agenda');
        Route::post('api/generateAgendaReport', 'ReportController@apiGenerateAgendaReport');
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
        Route::get('proposal/api/loadProposalDeadline/{authors}', 'GridProposalController@apiLoadProposalDeadline');
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

        //Cache Management
        Route::get('cache-management', 'CacheManagementController@index');
        Route::post('cache-management/apiClearAll', 'CacheManagementController@apiClearAll');

        //Mutation Management
        Route::post('mutation/apiList', 'MutationController@apiList');
        Route::post('mutation/api/loadTasks', 'MutationController@apiLoadTasks');
        Route::resource('mutation', 'MutationController');
        //Route::get('mutation/create', 'MutationController@create');

        //User Log
        Route::post('log/apiList', 'LogController@apiList');
        Route::resource('log', 'LogController');
    });
});
