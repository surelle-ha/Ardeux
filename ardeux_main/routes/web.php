<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    if(!Auth::user()){
        return view('login');
    }else{
        return redirect('/');
    }
    
})->name('login');

Route::post('/v1/api/user/login', [AuthController::class, 'login']);

Route::get('/v1/api/user/logout', [AuthController::class, 'logout']);

Route::get('/', function () { return redirect('home'); });
Route::get('/index', function () { return redirect('home'); });

Route::get('/home', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/mint', function () {
    $web3 = new Web3(new HttpProvider(new HttpRequestManager('https://api.devnet.solana.com')));
    $accounts = $web3->web3_clientVersion(); 
    dd($accounts);
});

