<?php
use App\Http\Controllers\Event\EventController as  Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/close-order', [Event::class, 'closeOrder']);
Route::post('/partial-payment', [Event::class, 'partialPayment']);
Route::post('/change-order-position', [Event::class, 'changeOrderPosition']);
Route::post('/set-discount', [Event::class, 'setDiscount']);
Route::post('/waiting-discount', [Event::class, 'waitingDiscount']);
Route::post('/discount-not-applied', [Event::class, 'discountNotApplied']);

