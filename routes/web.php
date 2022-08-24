<?php

use App\Http\Controllers\TeamMemberController;
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


Route::get('/',[TeamMemberController::class, 'index'])->name('team-member');
Route::get('/get-team-member-by-id/{id}',[TeamMemberController::class, 'edit']);
Route::post('/update-team-member',[TeamMemberController::class, 'updateTeamMember'])->name('update-team-member');
 Route::post('/get', [TeamMemberController::class, 'store'])->name('create-team-member');
Route::post('/', [TeamMemberController::class, 'getMonthlyStats'])->name('get-monthly-stats');