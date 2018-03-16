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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('import-data','HomeController@import_data');

Route::group(['prefix'=>'sosmed'],function(){
    Route::get('rangking','HomeController@sosmed_rangking');
    Route::get('group','HomeController@sosmed_group');
    Route::get('businness-unit','HomeController@sosmed_unit');
    Route::get('sosial-media','HomeController@sosmed_media');
    Route::get('program','HomeController@sosmed_program');
    Route::get('program/{id}/summary','HomeController@sosmed_summary_program');
    Route::get('business-unit/{id}/summary','HomeController@sosmed_summary_bu');
    Route::get('input-report-harian','HomeController@sosmed_input_report_harian');
    Route::get('add-new-report-harian','HomeController@add_new_report_harian');

    Route::get('daily-report','HomeController@sosmed_daily_report');
    Route::get('ranking-soc-med','HomeController@sosmed_ranking_soc_med');

    Route::get('role','HomeController@role');
    Route::get('role/{id}/permission','HomeController@permission');
    Route::get('user','HomeController@user');
    Route::get('user/{id}/role','HomeController@user_role');

    Route::group(['prefix'=>'data'],function(){
        Route::get('official-and-program-account-all-tv','HomeController@official_and_program');

        Route::resource('users','User\UserController');
        Route::resource('roles','User\RoleController');
        Route::resource('permissions','User\PermissionController');
        Route::get('list-role-with-permission/{id}','User\RoleController@list_role_with_permission');
        Route::get('list-role-user','User\UserController@list_role');
        Route::post('save-role-user','User\UserController@save_role_user');
        Route::post('hapus-role-user','User\UserController@hapus_role_user');
    
        Route::resource('group-unit','Sosmed\GroupunitController');
        Route::get('list-group','Sosmed\GroupunitController@list_group');
        Route::resource('business-unit','Sosmed\BusinessunitController');
        Route::get('list-unit','Sosmed\BusinessunitController@list_unit');
        Route::resource('program-unit','Sosmed\ProgramunitController');
        Route::resource('sosmed','Sosmed\SosmedController');
        Route::get('list-sosmed','Sosmed\SosmedController@list_sosmed');
        Route::resource('unit-sosmed','Sosmed\UnitsosmedController');
        Route::resource('unit-sosmed-follower','Sosmed\UnitsosmedfollowerController');

        Route::get('target-sosmed-program/{id}','Sosmed\ProgramunitController@target');
        Route::get('alltarget-sosmed-program/{id}','Sosmed\ProgramunitController@all_target');
        Route::post('save-target-program','Sosmed\ProgramunitController@save_target_program');
        Route::get('list-target-by-unit-sosmed/{id}','Sosmed\ProgramunitController@list_target_by_unit_sosmed');
        Route::put('use-target-program/{id}','Sosmed\ProgramunitController@use_target_program');
        Route::get('list-program-by-unit/{id}','Sosmed\ProgramunitController@list_program_by_unit');
        Route::get('list-sosmed-by-program','Sosmed\ProgramunitController@list_sosmed_by_id');
        Route::get('list-sosmed-by-unit/{id}','Sosmed\ProgramunitController@list_sosmed_by_unit');
        Route::get('list-sosmed-by-program/{id}','Sosmed\ProgramunitController@list_sosmed_by_program');
        Route::post('save-daily-report','Sosmed\ProgramunitController@save_daily_report');
        Route::post('cek-save-daily-report','Sosmed\ProgramunitController@cek_daily_report');

        Route::get('daily-report','Sosmed\ProgramunitController@daily_report');
        Route::get('daily-report/{id}','Sosmed\ProgramunitController@daily_report_by_id');
        Route::put('daily-report/{id}','Sosmed\ProgramunitController@daily_report_update');
        Route::delete('daily-report/{id}','Sosmed\ProgramunitController@daily_report_destroy');
        Route::post('import-daily-report','Sosmed\ProgramunitController@daily_report_import');
        Route::get('sample-daily-report','Sosmed\ProgramunitController@daily_report_sample');

        Route::get('backup-excel','Sosmed\ProgramunitController@import');

        Route::group(['prefix'=>'report'],function(){
            Route::get('target-vs-achievement','Sosmed\ReportController@target_vs_achievement');
            Route::get('official-account-all-tv','Sosmed\ReportController@official_account_all_tv');
            Route::get('sosmed-official-and-program','Sosmed\ReportController@sosmed_official_and_program');
            Route::get('official-and-program','Sosmed\ReportController@official_and_program');

            Route::get('rank-of-official-account-all-group','Sosmed\ReportController@rank_of_official_account_all_group');
            Route::get('rank-of-official-account-all-tv','Sosmed\ReportController@rank_of_official_account_all_tv');
            Route::get('rank-growth-from-yesterday-official-account-all-tv','Sosmed\ReportController@rank_growth_from_yesterday_all_tv');
            Route::get('rank-growth-from-yesterday-official-group','Sosmed\ReportController@rank_growth_from_yesterday_group');
            Route::get('rank-overall-account-all-tv-by-total-followers','Sosmed\ReportController@rank_overall_account_all_tv_by_total_followers');
            Route::get('rank-of-overall-all-group-by-followers','Sosmed\ReportController@rank_of_overall_all_group_by_follower');
            Route::get('rank-of-official-account-among-4tv','Sosmed\ReportController@rank_of_official_account_among_4tv');

            Route::get('summary-program-by-id/{id}','Sosmed\ReportController@summary_program_by_id');

            Route::get('pdf-rank-for-sosical-media-all-tv','Sosmed\ReportController@pdf_rank_for_social_media_all_tv');
            Route::get('pdf-sosmed-daily-report','Sosmed\ReportController@pdf_sosmed_daily_report');
        });
    });
});

Route::group(['prefix'=>'cmv'],function(){
    Route::get('/','Dashboard\CmvController@index');
    Route::get('sector','Dashboard\CmvController@sector');
    Route::get('category','Dashboard\CmvController@category');
    Route::get('brand','Dashboard\CmvController@brand');
    Route::get('demography','Dashboard\CmvController@demography');
    Route::get('demography/{id}/sub','Dashboard\CmvController@sub_demography');
    Route::get('variabel','Dashboard\CmvController@variabel');

    Route::group(['prefix'=>'data'],function(){
        Route::resource('sector','Dashboard\Cmv\SectorController');
        Route::post('import-sector','Dashboard\Cmv\SectorController@import');
        Route::get('sample-sector','Dashboard\Cmv\SectorController@sample');
        Route::get('export-sector','Dashboard\Cmv\SectorController@export');
        Route::get('list-sector','Dashboard\Cmv\SectorController@list_sector');

        Route::resource('category','Dashboard\Cmv\CategoryController');
        Route::post('import-category','Dashboard\Cmv\CategoryController@import');
        Route::get('sample-category','Dashboard\Cmv\CategoryController@sample');
        Route::get('export-category','Dashboard\Cmv\CategoryController@export');
        Route::get('list-category','Dashboard\Cmv\CategoryController@list_category');

        Route::resource('brand','Dashboard\Cmv\BrandController');
        Route::post('filter-brand','Dashboard\Cmv\BrandController@filter_brand');
        Route::post('import-brand','Dashboard\Cmv\BrandController@import');
        Route::get('sample-brand','Dashboard\Cmv\BrandController@sample');
        Route::get('export-brand','Dashboard\Cmv\BrandController@export');
        Route::get('list-brand','Dashboard\Cmv\BrandController@list_brand');

        Route::resource('demography','Dashboard\Cmv\DemographyController');
        Route::post('import-demography','Dashboard\Cmv\DemographyController@import');
        Route::get('sample-demography','Dashboard\Cmv\DemographyController@sample');
        Route::get('export-demography','Dashboard\Cmv\DemographyController@export');

        Route::resource('sub-demography','Dashboard\Cmv\SubdemographyController');
        Route::post('import-sub-demography','Dashboard\Cmv\SubdemographyController@import');
        Route::get('sample-sub-demography','Dashboard\Cmv\SubdemographyController@sample');
        Route::get('export-sub-demography','Dashboard\Cmv\SubdemographyController@export');

        Route::resource('variabel','Dashboard\Cmv\VariabelController');
        Route::post('filter-variabel','Dashboard\Cmv\VariabelController@filter_variabel');
        Route::post('import-variabel','Dashboard\Cmv\VariabelController@import');
        Route::get('sample-variabel','Dashboard\Cmv\VariabelController@sample');
        Route::get('export-variabel','Dashboard\Cmv\VariabelController@export');

        Route::get('search','Dashboard\Cmv\VariabelController@search');
    });
});