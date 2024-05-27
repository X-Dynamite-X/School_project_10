<?php

use Illuminate\Support\Facades\Route;

use App\Events\MessageUserEvent;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ChackIsActive;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Message\MesageController;
use App\Http\Controllers\Admin\SubjectUserController;
use App\Http\Controllers\Message\ConversationController;
use App\Http\Controllers\User\UserController as UserControllerUser;
use App\Http\Controllers\User\SubjectController as SubjectContreollerUser;

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);
Route::get(
    '/waiting',
    function () {
        return view('auth.isNotActiv');
    }
);


Auth::routes(['verify' => true]);

Route::prefix('')->middleware(["auth","verified", ChackIsActive::class])->group(function () {
    // Rout Users
    Route::get('/home', [SubjectContreollerUser::class, 'index'])->name('home');
    Route::get('/user/profile', [UserControllerUser::class, 'index'])->name('profile_index');
    Route::get('/message', [MesageController::class, 'index'])->name('message_index');
    //! message
    // Route::post('/{user1_id}/{user2_id}', [ConversationController::class, 'create'])->name('create_ConversationController')->middleware('CheckUser1');
    Route::get("/message/{conversation_id}", [MesageController::class, 'show'])->name('show_ConversationController');
    Route::post("/message/{conversation_id}/broadcast/messages", [MesageController::class, 'store'])->name('store_ConversationController');
    Route::post("/message/{conversation_id}/receive/messages", [MesageController::class, 'receiveMessages'])->name('receive_ConversationController');

    Route::get('/search', [ConversationController::class, "searchUser"])->name("search");

});

Route::prefix('admin')->middleware(["role:admin","verified", "auth",])->group(function () {
    // Rout Users
    Route::get('/user', [UserController::class, 'index'])->name('user_index');
    Route::get('/getUser', [UserController::class, 'getUser'])->name('getUser_index');
    Route::get('/getUserData/{id}', [UserController::class, 'getUserData'])->name("getUserData_ajax");

    Route::post('/user/store', [UserController::class, 'store'])->name('user_store');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name("user_update");
    Route::delete("/user/destroy/{id}", [UserController::class, "destroy"])->name("user_destroy");

    // Rout Subjects
    Route::get('/subject', [SubjectController::class, 'index'])->name('subject_index');
    Route::get('/getSubject', [SubjectController::class, 'getSubject'])->name('getSubject_index');
    Route::get('/getSubjectData/{id}', [SubjectController::class, 'getSubjectData'])->name("getSubjectData_ajax");

    Route::post('/subject/store', [SubjectController::class, 'store'])->name("subject_store");
    Route::put('/subject/update/{id}', [SubjectController::class, 'update'])->name("subject_update");
    Route::delete("/subject/destroy/{id}", [SubjectController::class, "destroy"])->name("subject_destroy");

    //subject User
    Route::get('/getSubjectUser/{id}', [SubjectUserController::class, 'getSubjectUser'])->name('getSubjectUser_index');
    Route::get('/getSubjectUserData/{id}', [SubjectUserController::class, 'getSubjectUserData'])->name("getSubjectUserData_ajax");
    Route::get('/getSubjectUserData/{subjectId}/{userId}', [SubjectUserController::class, 'getSubjectUserDataInSubject'])->name("getSubjectUserDataInSubject_ajax");



    Route::post('/subject/user/store/{subjectId}', [SubjectUserController::class, 'store'])->name("subjectUser_store");
    Route::put('/subject/user/update/{subjectId}/{subjectUserId}', [SubjectUserController::class, 'update'])->name("subjectUser_update");
    Route::delete("/subject/user/destroy/{subjectId}/{subjectUserId}", [SubjectUserController::class, "destroy"])->name("subjectUser_destroy");
});
