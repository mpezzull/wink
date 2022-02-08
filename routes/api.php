<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api/v1" middleware group. Enjoy building your API!
|
*/

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('username', $request->username)->first();

    if (!$user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
    return $user->createToken($request->username)->plainTextToken;
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/posts/filter', 'Posts\PostController@filter');
    Route::get('/posts/all', 'Posts\PostController@all');
    Route::get('/posts/filter/{name}', 'Posts\PostController@getFilteredByHashtags');
    Route::resource('posts', 'Posts\PostController');

    Route::post('/hashtags/filter', 'Hashtags\HashtagController@filter');
    Route::get('/hashtags/all', 'Hashtags\HashtagController@all');
    Route::resource('hashtags', 'Hashtags\HashtagController');
});

//Route::apiResource('users', PhotoController::class);
