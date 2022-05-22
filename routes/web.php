<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Controller::class, 'index']);
Route::get('/form', [Controller::class, 'showform']);
Route::post('/form/post', [Controller::class, 'store'])->name('form.post');
Route::get('/userdata', [Controller::class, 'getdata'])->name('getuserdata');
Route::delete('/deletedata', [Controller::class, 'deletedata'])->name('deletedata');
