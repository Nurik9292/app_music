<?php

use App\Http\Resources\Admin\AlbumResource;
use App\Http\Resources\Admin\ArtistResource;
use App\Http\Resources\Admin\GenreResource;
use App\Http\Resources\Admin\PlaylistResource;
use App\Http\Resources\Admin\TrackResource;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Track;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::middleware('auth:api', 'admin')->group(function () {
Route::prefix('users')->namespace('App\Http\Controllers\Admin\User\Api')->name('api.user.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::patch('/{user}', UpdateController::class)->name('update');
    Route::delete('/{user}', DestroyController::class)->name('destroy');
});

Route::prefix('genres')->namespace('App\Http\Controllers\Admin\Genre\Api')->name('api.genre.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::patch('/{genre}', UpdateController::class)->name('update');
    Route::delete('/{genre}', DestroyController::class)->name('destroy');
});

Route::prefix('overviews')->namespace('App\Http\Controllers\Admin\Block\Overview\Api')->name('api.overview.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::post('/', StoreController::class)->name('store');
    Route::get('/show/{block}', ShowController::class)->name('show');
    Route::patch('/{block}', UpdateController::class)->name('update');
    Route::put('sort', SortController::class)->name('sort');
    Route::delete('/{block}', DestroyController::class)->name('destroy');

    Route::get('/tracks', function () {
        $tracks = Track::orderBy('title')->get();
        return TrackResource::collection($tracks);
    })->name('track');

    Route::get('/genres', function () {
        $genres = Genre::orderBy('name_ru')->get();
        return GenreResource::collection($genres);
    })->name('genre');

    Route::get('/playlists', function () {
        $playlists = Playlist::orderByDesc('title_ru')->get();
        return new PlaylistResource($playlists);
    })->name('playlist');

    Route::get('/albums', function () {
        $albums = Album::orderBy('title')->get();
        return new AlbumResource($albums);
    })->name('album');
});


Route::prefix('tracks')->namespace('App\Http\Controllers\Admin\Track\Api')->name('api.track.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::post('/', StoreController::class)->name('store');
    Route::post('/scan', StoreScanController::class)->name('store.scan');
    Route::post('/albums/{album}', StoreAlbumController::class)->name('store.album');
    Route::post('/playlists/{playlist}', StorePlaylistController::class)->name('store.playlist');
    Route::get('/show/{track}', ShowController::class)->name('show');
    Route::post('/filter', FilterController::class)->name('filter');
    Route::patch('/{track}', UpdateController::class)->name('update');
    Route::delete('/{track}', DestroyController::class)->name('destroy');

    Route::get('/albums', function () {
        $albums = Album::orderBy('title')->get();
        return new AlbumResource($albums);
    })->name('album');

    Route::get('/artists', function () {
        $artists = Artist::orderBy('name')->get();
        return new ArtistResource($artists);
    })->name('artist');

    Route::get('/genres', function () {
        $genres = Genre::orderBy('name_ru')->get();
        return GenreResource::collection($genres);
    })->name('genre');

    Route::get('/playlists', function () {
        $playlists = Playlist::orderBy('title_ru')->get();
        return PlaylistResource::collection($playlists);
    })->name('playlist');
});
// });