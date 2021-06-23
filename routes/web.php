<?php

use Illuminate\Support\Facades\Route;
// Pour utiliser mon nouveau controller index :
use App\Http\Controllers\IndexController;
// Route article Controller
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;


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

// Route test :
Route::get('/index', function() {
    return view('index') . request('nom'); //host/about/Alison
});


// Route page accueil :
Route::get('/', [IndexController::class, 'showIndex']);

// Page d'inscription :
Route::get('/registration', function() {
    return view('registration');
});
// Route::post('/registration', function() {
//     request()->validate([
//         'email' => ['required', 'email'],
//         'password' => ['required', 'confirmed', 'min:8'],
//         'password_confirmation' => ['required']
//     ], [
//         'password.min' => 'Pour des raisons de sécurité, votre mot de passe doit faire au moins :min caractères.'
//     ]);
// });

// Route créée par Laravel:auth
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); 

// regroupement dans le middleware pour n'avoir accès aux pages que si l'on est connecté :
// Route::middleware('auth')->group(function() {
    
    // Routes pour les annonces : view ARTICLE(index)
    Route::get('/article', [ArticleController::class, 'index']);
    Route::get('/show', [ArticleController::class, 'show']);

    // Route form CREATE qui ramène à la view et qui est traité par STORE :
    Route::get('/create', [ArticleController::class, 'create']);
    Route::post('/create', [ArticleController::class, 'store']);
    // Route pour le traitement/insertion des données :
    Route::post('/store', [ArticleController::class, 'store']);
    // Route pour modification de données
    Route::get('/edit/{id}', [ArticleController::class, 'show']);
    Route::post('/edit', [ArticleController::class, 'update']);

    Route::get('/search', [ArticleController::class, 'search']);

    Route::delete('/destroy{id}', [ArticleController::class, 'destroy']);


