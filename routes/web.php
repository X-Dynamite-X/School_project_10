<?php

use App\Events\NewMessage;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Auth\RegisterController;
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
// Route::get(
//     '/test',
//     function () {
//         return view('test');
//     }
// );
Auth::routes(['verify' => true]);


Route::prefix('')->middleware(["guest"])->group(function () {
    Route::get(
        '/waiting',
        function () {
            return view('auth.isNotActiv');
        }
    )->middleware("guest");
    Route::get('/check-email', function () {
        return view('auth.check-email');
    })->name('check.email');
    Route::post('/resend-verification', [RegisterController::class, 'resendVerification'])->name('resend.verification');
    Route::get('/test', [AuthController::class, 'usersStatusCheck'])->name('getUsers');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('verify.email');
});


Route::prefix('')->middleware(["auth", "verified", "permission:isActev"])->group(function () {

    Route::get('/getUserStatus', [AuthController::class, 'getUserStatus'])->name('getUserStatus');
    Route::post('/setUserStatus', [AuthController::class, 'setUserStatus'])->name('setUserStatus');
    // Rout Users
    Route::get('/home', [SubjectContreollerUser::class, 'index'])->name('home');
    Route::get('/user/profile', [UserControllerUser::class, 'index'])->name('profile_index');
    //! message
    Route::get('/search', [ConversationController::class, "searchUser"])->name("search");
    Route::get('/getConversations', [ConversationController::class, 'getConversations'])->name('getConversations');

    Route::get('/message', [MesageController::class, 'index'])->name('message_index');
    Route::post('/ConversationController/{user1_id}/{user2_id}', [ConversationController::class, 'create'])->name('create_ConversationController');
    //###################3
    Route::prefix('')->middleware(["cheackSenedrMessage"])->group(function () {


    Route::get('/getMessage/{messages_id}', [MesageController::class, 'getMessage'])->name('getMessage_index');
    Route::put("/message/{conversation_id}/broadcast/messages/update/{messages_id}", [MesageController::class, 'update'])->name('update_ConversationController');
    Route::delete("/message/{conversation_id}/broadcast/messages/delete/{messages_id}", [MesageController::class, 'destroy'])->name('destroy_ConversationController');
});

    Route::prefix('')->middleware(["cheackConversation"])->group(function () {
        Route::get("/message/{conversation_id}", [MesageController::class, 'show'])->name('show_ConversationController');
        Route::post("/message/{conversation_id}/broadcast/messages", [MesageController::class, 'store'])->name('store_ConversationController');
        Route::post("/message/{conversation_id}/receive/messages", [MesageController::class, 'receiveMessages'])->name('receive_ConversationController');


    });
});

Route::prefix('admin')->middleware(["role:admin", "verified", "auth",])->group(function () {
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
