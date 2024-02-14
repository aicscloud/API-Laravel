<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//liste des route pour la gestion des post
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);


//liste des route pour la gestion des utilisateur
Route::get('users', [UserController::class, 'index']);
Route::post('/login', [UserController::class, 'login']);
Route::get('users/{user}', []);
Route::post('/register', [UserController::class, 'register']);
Route::delete('/delete/{user}', []);
Route::put('/update/{user}', []);


Route::middleware('auth:sanctum')->group(function(){
    //creer un poste
    Route::post('posts/create', [PostController::class, 'store']);
    //suprimmer un post
    Route::delete('posts/delete/{post}', [PostController::class, 'destroy']);
    //modifier un post
    Route::put('posts/update/{post}', [PostController::class, 'update']);
    //retourne utilisateur connecté
    Route::get('/user', function(Request $resquest){
        return $resquest->user();
    });
});
