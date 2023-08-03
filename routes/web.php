<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProccessController;

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

Route::get('/index', function () {
    return view('index');
});
// Route::post('logout', LogoutController::class);
Route::post('/logout', [LogoutController::class, 'perform'])->name('logout');

// Route::post('/logout', 'LogoutController@perform')->name('logout');


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /**
     * Home Routes
     */
   
    // Route::get('/day', 'DayController@index')->name('day.index');

    // Route::group(['middleware' => ['guest']], function () {
    /**
     * Register Routes
     */
    Route::get('/register', 'RegisterController@show')->name('register.show');
    Route::post('/register', 'RegisterController@register')->name('register.perform');

    /**
     * Login Routes
     */
    Route::post('/login',  'LoginController@login')->name('login.perform');
    Route::get('/login',  'LoginController@show')->name('login.show');
    // });
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/test', 'TestController@index')->name('test.index');
        Route::get('/', 'HomeController@index')->name('home.index');
        /**
         * Logout Routes
         */
        // Route::post('/logout', 'LogoutController@perform')->name('logout');

        // Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('/day/datatable', 'DayController@datas')->name('day.datatable');
        Route::get('/day', 'DayController@index')->name('day.index');
        Route::get('/day/add', 'DayController@add')->name('day.add');
        Route::post('/day/store', 'DayController@store')->name('day.store');
        Route::post('/day/update', 'DayController@update');
        Route::get('/day/edit/{id}', 'DayController@edit')->name('day.edit');
        Route::delete('/day/hapus/{id}', 'DayController@hapus')->name('day.hapus');

        Route::get('/hour/datatable', 'HourController@datas')->name('hour.datatable');
        Route::get('/hour', 'HourController@index')->name('hour.index');
        Route::get('/hour/add', 'HourController@add')->name('hour.add');
        Route::post('/hour/store', 'HourController@store')->name('hour.store');
        Route::post('/hour/update', 'HourController@update');
        Route::get('/hour/edit/{id}', 'HourController@edit')->name('hour.edit');
        Route::delete('/hour/hapus/{id}', 'HourController@hapus')->name('hour.hapus');

        Route::get('/kelas/datatable', 'KelasController@datas')->name('kelas.datatable');
        Route::get('/kelas', 'KelasController@index')->name('kelas.index');
        Route::get('/kelas/add', 'KelasController@add')->name('kelas.add');
        Route::post('/kelas/store', 'KelasController@store')->name('kelas.store');
        Route::post('/kelas/update', 'KelasController@update');
        Route::get('/kelas/edit/{id}', 'KelasController@edit')->name('kelas.edit');
        Route::delete('/kelas/hapus/{id}', 'KelasController@hapus')->name('kelas.hapus');

        Route::get('/year/datatable', 'YearController@datas')->name('year.datatable');
        Route::get('/year', 'YearController@index')->name('year.index');
        Route::get('/year/add', 'YearController@add')->name('year.add');
        Route::post('/year/store', 'YearController@store')->name('year.store');
        Route::post('/year/update', 'YearController@update');
        Route::get('/year/edit/{id}', 'YearController@edit')->name('year.edit');
        Route::delete('/year/hapus/{id}', 'YearController@hapus')->name('year.hapus');

        Route::get('/lecture/datatable', 'LectureController@datas')->name('lecture.datatable');
        Route::get('/lecture', 'LectureController@index')->name('lecture.index');
        Route::get('/lecture/add', 'LectureController@add')->name('lecture.add');
        Route::post('/lecture/store', 'LectureController@store')->name('lecture.store');
        Route::post('/lecture/update', 'LectureController@update');
        Route::get('/lecture/edit/{id}', 'LectureController@edit')->name('lecture.edit');
        Route::delete('/lecture/hapus/{id}', 'LectureController@hapus')->name('lecture.hapus');

        Route::get('/course/datatable', 'CourseController@datas')->name('course.datatable');
        Route::get('/course', 'CourseController@index')->name('course.index');
        Route::get('/course/add', 'CourseController@add')->name('course.add');
        Route::post('/course/store', 'CourseController@store')->name('course.store');
        Route::post('/course/update', 'CourseController@update');
        Route::get('/course/edit/{id}', 'CourseController@edit')->name('course.edit');
        Route::delete('/course/hapus/{id}', 'CourseController@hapus')->name('course.hapus');

        // Route::get('/bisnis', 'BisnisController@inisialisasi')->name('bisnis.index');
        // Route::get('/bisnis/cekfitness', 'BisnisController@hitungfitness')->name('bisnis.cekfitness');
        // Route::get('/bisnis/ambildata', 'BisnisController@ambildata')->name('bisnis.ambildata');
        // Route::get('/bisnis/hitung', 'BisnisController@hitungfitness')->name('bisnis.hitungfitness');
        // Route::get('/bisnis/crossover', 'BisnisController@startcrossover')->name('bisnis.startcrossover');

        Route::get('/proccess', 'ProccessController@penjadwalan')->name('proccess.penjadwalan');

        Route::get('/room/datatable', 'RoomController@datas')->name('room.datatable');
        Route::get('/room', 'RoomController@index')->name('room.index');
        Route::get('/room/add', 'RoomController@add')->name('room.add');
        Route::post('/room/store', 'RoomController@store')->name('room.store');
        Route::post('/room/update', 'RoomController@update');
        Route::get('/room/edit/{id}', 'RoomController@edit')->name('room.edit');
        Route::delete('/room/hapus/{id}', 'RoomController@hapus')->name('room.hapus');

        Route::get('/getMatkul', 'SupportController@getMataKuliahBySemester')->name('getMataKuliahBySemester');

        Route::get('/support/datatable', 'SupportController@datas')->name('support.datatable');
        Route::get('/support', 'SupportController@index')->name('support.index');
        
        Route::get('/support/add', 'SupportController@add')->name('support.add');
        Route::post('/support/store', 'SupportController@store')->name('support.store');
        Route::post('/support/update', 'SupportController@update');
        Route::get('/support/edit/{id}', 'SupportController@edit')->name('support.edit');
        Route::delete('/support/hapus/{id}', 'SupportController@hapus')->name('support.hapus');

        Route::get('/schedule/export', 'ScheduleController@export')->name('schedule.export');
        Route::get('/schedule', 'ProccessController@masuk')->name('schedule.index');
        Route::post('/schedule/test', 'ProccessController@index')->name('schedule.test');

        Route::get('/surat', 'SuratPemberitahuanCOntroller@index')->name('suratPemberitahuan.index');

        Route::get('/genetika_search', 'GenetikaSearchController@index')->name('genetika.index');
        Route::get('/genetika_search/search', 'GenetikaSearchController@search')->name('genetika.search');
        Route::get('/genetika_search/mesh', 'GenetikaSearchController@meshbaru')->name('genetika.search');



       
        Route::get('/schedule/add', 'ScheduleController@add')->name('schedule.add');
        Route::post('/schedule/store', 'ScheduleController@store')->name('schedule.store');
        Route::post('/schedule/update', 'ScheduleController@update');
        Route::get('/schedule/edit/{id}', 'ScheduleController@edit');
        Route::get('/schedule/hapus/{id}', 'ScheduleController@hapus');

        Route::get('/wtb/datatable', 'WbController@datas')->name('wtb.datatable');
        Route::get('/wtb', 'WtbController@index')->name('wtb.index');
        Route::get('/wtb/add', 'WtbController@add')->name('wtb.add');
        Route::post('/wtb/store', 'WtbController@store')->name('wtb.store');
        Route::post('/wtb/update', 'WtbController@update');
        Route::get('/wtb/edit/{id}', 'WtbController@edit')->name('wtb.edit');
        Route::delete('/wtb/hapus/{id}', 'WtbController@hapus')->name('wtb.hapus');
        Route::post('/wtb/wtbdata', 'WtbController@wtbdata')->name('wtb.wtbdata');
        
        Route::get('/wb', 'WbController@index')->name('wb.index');
        Route::get('/wb/add', 'WbController@add')->name('wb.add');
        Route::post('/wb/store', 'WbController@store')->name('wb.store');
        Route::post('/wb/update', 'WbController@update');
        Route::get('/wb/edit/{id}', 'WbController@edit');
        Route::get('/wb/hapus/{id}', 'WbController@hapus');
        Route::get('/wb/datatable', 'WbController@datas')->name('wb.datatable');


        
        Route::get('/akademik', 'AkademikController@index')->name('akademik.index');

        Route::get('/support/getmatakuliah', 'SupportController@getMatakuliah')->name('support.getmatakuliah');
        Route::get('/wb/getpengampu', 'WbController@getPengampu')->name('wb.getpengampu');

        Route::get('/schedule/getprodi', 'ProccessController@getProdi')->name('schedule.getprodi');
        Route::post('/schedule/update-kode-jam', [ProccessController::class, 'updateKodeJam'])->name('schedule.updateKodeJam');
        Route::post('/updateKodeJam', 'ProccessController@updateKodeJam')->name('schedule.updateKodeJam');
        Route::post('/updateKodeHari', 'ProccessController@updateKodeHari')->name('schedule.updateKodeHari');
        Route::get('/wb/datatables', 'WbController@datas')->name('schedule.getprodi');
        Route::post('/algoritma', 'AlgoritmaGenetikaController@build')->name('algoritma.build');
        Route::get('/getProdi', 'ProccessController@getProdi')->name('schedule.getprodi');
        Route::get('/proccess/bentrok', 'ProccessController@bentrok')->name('proccess.bentrok');

        Route::post('/import', 'CourseController@import')->name('import');
       
        Route::get('/schedule/exportdetail', 'ScheduleController@exportdetail')->name('schedule.exportdetail');
    });
});
