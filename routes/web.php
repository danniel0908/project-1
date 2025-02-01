<?php
use App\Http\Controllers\LandingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DroppingController;
use App\Http\Controllers\PodaApplicationController;
use App\Http\Controllers\PPFapplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TODAapplicationController;
use App\Http\Controllers\TmuController;
use App\Http\Controllers\ScheduleOfServiceController;
use App\Http\Controllers\ServiceApplicationController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\todaRequirementsController;
use App\Http\Controllers\PodaRequirementsController;
use App\Http\Controllers\StickerRequirementsController;
use App\Http\Controllers\PodaDroppingRequirementsController;
use App\Http\Controllers\TodaDroppingRequirementsController;
use App\Http\Controllers\ServiceRequirementController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\podaCerfController;
use App\Http\Controllers\SendSMSController;
use App\Http\Controllers\TodaCerfController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\ViolatorController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\PredefinedMessageController;
use App\Http\Controllers\PDFGenerator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.phone');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');

//Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/about', [LandingController::class, 'about'])->name('landing.about');
Route::get('/staff', [LandingController::class, 'staff'])->name('landing.staff');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/applicant-type', [ProfileController::class, 'updateApplicantType'])->name('profile.update.applicant-type');

});
Route::middleware(['auth'])->group(function () {
    Route::get('/tickets', [SupportTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [SupportTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [SupportTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [SupportTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('tickets.reply');
});
    
       // Support Ticket Routes
Route::middleware(['auth'])->group(function () {
    
    Route::prefix('tickets')->group(function () {
        Route::get('/', [SupportTicketController::class, 'index'])->name('tickets.index');
        Route::get('/{ticket}', [SupportTicketController::class, 'show'])->name('tickets.show');
        Route::post('/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('tickets.reply');
    });
    // Admin Area Routes
    Route::prefix('admin')->middleware(['role:admin,tmu,superadmin'])->group(function () {
        Route::get('/tickets', [SupportTicketController::class, 'adminIndex'])->name('admin.tickets.index');
        Route::get('/tickets/{ticket}', [SupportTicketController::class, 'adminShow'])->name('admin.tickets.show');
        Route::post('/tickets/{ticket}/reply', [SupportTicketController::class, 'adminReply'])->name('admin.tickets.reply');
    });
});


//sending sms route//
Route::post('/send-sms', [SendSMSController::class, 'sendSMS'])->name('sendSMS');

Route::get('user/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:user'])
    ->name('dashboard');

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('user/services', [UserController::class, 'services'])->name('users.services');
    Route::get('user/profile', [UserController::class, 'profile'])->name('users.profile');

    Route::get('user/usertoda', [TODAapplicationController::class, 'showApplicationForm'])->name('toda.fillup');
    Route::get('user/userpoda', [PodaApplicationController::class, 'showApplicationForm'])->name('poda.fillup');
    Route::get('user/sticker', [PPFapplicationController::class, 'showApplicationForm'])->name('ppf.fillup');
    Route::get('user/toda/drop', [DroppingController::class, 'todadropApplicationForm'])->name('toda.drop.fillup');
    Route::get('user/poda/drop', [DroppingController::class, 'podadropApplicationForm'])->name('poda.drop.fillup');

    Route::get('service-applications/create', [ServiceApplicationController::class, 'showApplicationForm'])
     ->name('service-applications.create');

    Route::get('/schedule/{serviceApplicationId}', [ScheduleOfServiceController::class, 'showScheduleForm'])->name('schedule.create');
    Route::post('/schedule/store', [ScheduleOfServiceController::class, 'store'])->name('schedule.store');

    Route::post('/schedule/{id}', [ScheduleOfServiceController::class, 'update']);
    Route::get('toda/requirements', [todaRequirementsController::class, 'showUploadForm'])->name('upload.toda');
    Route::post('toda/requirements/{toda_application_id}', [todaRequirementsController::class, 'upload'])->name('toda.upload');

    Route::get('poda/requirements', [PodaRequirementsController::class, 'showUploadForm'])->name('upload.poda');
    Route::post('poda/requirements/{poda_application_id}', [PodaRequirementsController::class, 'upload'])->name('poda.upload');

    Route::get('sticker/requirements', [StickerRequirementsController::class, 'showUploadForm'])->name('upload.sticker');
    Route::post('sticker/requirements/{sticker_application_id}', [StickerRequirementsController::class, 'upload'])->name('sticker.upload');

    Route::get('poda/drop/requirements', [PodaDroppingRequirementsController::class, 'showUploadForm'])->name('upload.podaDrop');
    Route::post('poda/drop/requirements/{poda_dropping_id}', [PodaDroppingRequirementsController::class, 'upload'])->name('podaDrop.upload');

    Route::get('toda/drop/requirements', [TodaDroppingRequirementsController::class, 'showUploadForm'])->name('upload.todaDrop');
    Route::post('toda/drop/requirements/{toda_dropping_id}', [TodaDroppingRequirementsController::class, 'upload'])->name('todaDrop.upload');

    Route::get('service/requirements', [ServiceRequirementController::class, 'showUploadForm'])->name('upload.service');
    Route::post('service/requirements/{service_application_id}', [ServiceRequirementController::class, 'upload'])->name('service.upload');


    //edit
    Route::get('user/usertoda-edit/{id}', [TODAapplicationController::class, 'editApplication'])->name('toda.edit');
    Route::get('toda/requirements/{id}', [todaRequirementsController::class, 'showuploads'])->name('show.upload.toda');

    Route::get('user/userpoda-edit/{id}', [PodaApplicationController::class, 'editApplication'])->name('poda.edit');
    Route::get('poda/requirements/{id}', [PodaRequirementsController::class, 'showuploads'])->name('show.upload.poda');

    Route::get('user/usersticker-edit/{id}', [PPFapplicationController::class, 'editApplication'])->name('sticker.edit');
    Route::get('sticker/requirements/{id}', [StickerRequirementsController::class, 'showuploads'])->name('show.upload.sticker');

    Route::get('user/privateservice-edit/{id}', [ServiceApplicationController::class, 'editApplication'])->name('service.edit');
    Route::get('service/requirements/{id}', [ServiceRequirementController::class, 'showuploads'])->name('show.upload.service');

    Route::get('user/usertodadrop-edit/{id}', [DroppingController::class, 'editTODAdrop'])->name('todadrop.edit');
    Route::get('todadrop/requirements/{id}', [TodaDroppingRequirementsController::class, 'showuploads'])->name('show.upload.todadrop');

    Route::get('user/userpodadrop-edit/{id}', [DroppingController::class, 'editPODAdrop'])->name('podadrop.edit');
    Route::get('podadrop/requirements/{id}', [PodaDroppingRequirementsController::class, 'showuploads'])->name('show.upload.podadrop');

    //update/delete requirement
    Route::put('/toda/update-file/{file_id}', [todaRequirementsController::class, 'updateFile'])->name('toda.update.file');
    Route::put('/poda/update-file/{file_id}', [PodaRequirementsController::class, 'updateFile'])->name('poda.update.file');
    Route::put('/sticker/update-file/{file_id}', [StickerRequirementsController::class, 'updateFile'])->name('sticker.update.file');
    Route::put('/service/update-file/{file_id}', [ServiceRequirementController::class, 'updateFile'])->name('service.update.file');
    Route::put('/todadrop/update-file/{file_id}', [TodaDroppingRequirementsController::class, 'updateFile'])->name('todadrop.update.file');
    Route::put('/podadrop/update-file/{file_id}', [PodaDroppingRequirementsController::class, 'updateFile'])->name('podadrop.update.file');

    // Route (in web.php)
    Route::get('/toda/payment/{id}', [todaRequirementsController::class, 'showpayment'])->name('toda.payment');
    Route::get('/poda/payment/{id}', [PodaRequirementsController::class, 'showpayment'])->name('poda.payment');
    Route::get('/sticker/payment/{id}', [StickerRequirementsController::class, 'showpayment'])->name('sticker.payment');
    Route::get('/service/payment/{id}', [ServiceRequirementController::class, 'showpayment'])->name('service.payment');
    Route::get('/todadrop/payment/{id}', [TodaDroppingRequirementsController::class, 'showpayment'])->name('todadrop.payment');
    Route::get('/podadrop/payment/{id}', [PodaDroppingRequirementsController::class, 'showpayment'])->name('podadrop.payment');
});

Route::get('/generate-pagpapatunay/toda/{id}', [PDFGenerator::class, 'generateTodaPagpapatunay'])
    ->name('generate.pagpapatunay.toda');
Route::get('/generate-pagpapatunay/poda/{id}', [PDFGenerator::class, 'generatePodaPagpapatunay'])
    ->name('generate.pagpapatunay.poda');
Route::get('/generate-pagpapatunay/sticker/{id}', [PDFGenerator::class, 'generateStickerpagpapatunay'])
    ->name('generate.pagpapatunay.sticker');
Route::get('/generate-pagpapatunay/service/{id}', [PDFGenerator::class, 'generateServicepagpapatunay'])
    ->name('generate.pagpapatunay.service');
Route::get('/generate-pagpapatunay/todadrop/{id}', [PDFGenerator::class, 'generateTodaDroppingPagpapatunay'])
    ->name('generate.pagpapatunay.todadrop');
Route::get('/generate-pagpapatunay/podadrop/{id}', [PDFGenerator::class, 'generatePodaDroppingPagpapatunay'])
    ->name('generate.pagpapatunay.podadrop');
    
// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //create function for admin
Route::get('/TODAapplication/create', [TODAapplicationController::class, 'create'])->name('TODAapplication.create');
Route::get('/PODAdropping/create', [DroppingController::class, 'createdroppoda'])->name('PODAdropping.create');
Route::get('/PPFapplication/create', [PPFapplicationController::class, 'create'])->name('PPFapplication.create');
Route::get('/TODADropping/create', [DroppingController::class, 'createdroptoda'])->name('TODADropping.create');
Route::get('PODAapplication/create', [PodaApplicationController::class, 'create'])->name('PODAapplication.create');
Route::get('ServiceApplication/create', [ServiceApplicationController::class, 'create'])->name('ServiceApplication.create');


Route::get('/TODAapplication/{TODAapplication}', [TODAapplicationController::class, 'showuser'])->name('TODAapplication.show');


Route::resource('schedules', ScheduleOfServiceController::class);
Route::get('/schedules/user/{newApplication}', [ScheduleOfServiceController::class, 'show'])->name('schedules.show');


Route::put('/ServiceApplication/{id}/update-status', [ServiceApplicationController::class, 'updateStatus'])->name('ServiceApplication.updateStatus');


Route::get('/users', [UserController::class, 'index']);
Route::resource('codes', CodeController::class);



//Id Generator
Route::get('/generate-toda-id/{id}', [PDFGenerator::class, 'generateTodaID'])->name('generate.toda.id');
Route::get('/generate-poda-id/{id}', [PDFGenerator::class, 'generatePodaID'])->name('generate.poda.id');
Route::get('/generate-toda-cerf/{id}', [TodaCerfController::class, 'generateTodaCerf'])->name('generate.toda.cerf');
Route::get('/generate-poda-cerf/{id}', [podaCerfController::class, 'generatePodaCerf'])->name('generate.poda.cerf');
Route::get('/generate-service-id/{id}', [PDFGenerator::class, 'generateServiceID'])->name('generate.service.id');


//update-remarks&status
Route::put('/toda-requirements/update', [TODAapplicationController::class, 'updatereq'])->name('toda-requirements.update');
Route::put('/poda-requirements/update', [PodaApplicationController::class, 'updatereq'])->name('poda-requirements.update');
Route::put('/sticker-requirements/update', [PPFapplicationController::class, 'updatereq'])->name('sticker-requirements.update');
Route::put('/todaDrop-requirements/update', [DroppingController::class, 'todaUpdatereq'])->name('todadrop-requirements.update');
Route::put('/podaDrop-requirements/update', [DroppingController::class, 'podaUpdatereq'])->name('podadrop-requirements.update');
Route::put('/service-requirements/update', [ServiceApplicationController::class, 'updatereq'])->name('service-requirements.update');

//upload using excel
Route::post('/upload-excel-toda', [TODAapplicationController::class, 'uploadExcel'])->name('upload.excel-toda');
Route::post('/upload-excel-poda', [PodaApplicationController::class, 'uploadExcel'])->name('upload.excel-poda');
Route::post('/upload-excel-sticker', [PPFapplicationController::class, 'uploadExcel'])->name('upload.excel-sticker');
Route::post('/upload-excel-service', [ServiceApplicationController::class, 'uploadExcel'])->name('upload.excel-service');
Route::post('/upload-excel-toda-dropping', [DroppingController::class, 'todauploadExcel'])->name('upload.excel-toda-dropping');
Route::post('/upload-excel-poda-dropping', [DroppingController::class, 'podauploadExcel'])->name('upload.excel-poda-dropping');
});

// TODAapplication routes
Route::middleware('auth')->group(function () {
    Route::post('TODAapplication', [TODAapplicationController::class, 'store'])->name('TODAapplication.store');
    Route::get('TODAapplication/{TODAapplication}', [TODAapplicationController::class, 'show'])->name('TODAapplication.show');
    Route::get('TODAapplication/{TODAapplication}/edit', [TODAapplicationController::class, 'edit'])->name('TODAapplication.edit');
    Route::put('TODAapplication/{TODAapplication}', [TODAapplicationController::class, 'update'])->name('TODAapplication.update');
    Route::delete('TODAapplication/{TODAapplication}', [TODAapplicationController::class, 'destroy'])->name('TODAapplication.destroy');
    Route::put('/TODAapplication/{id}/update-status', [TODAapplicationController::class, 'updateStatus'])->name('TODAapplication.updateStatus');
});

Route::post('/toda-applications/{id}/create-user', [TODAapplicationController::class, 'createUserAccount'])
    ->middleware(['auth'])
    ->name('toda-applications.create-user');

// PODAapplication routes
Route::middleware('auth')->group(function () {
    Route::post('PODAapplication', [PodaApplicationController::class, 'store'])->name('PODAapplication.store');
    Route::get('PODAapplication/{PODAapplication}', [PodaApplicationController::class, 'show'])->name('PODAapplication.show');
    Route::get('PODAapplication/{PODAapplication}/edit', [PodaApplicationController::class, 'edit'])->name('PODAapplication.edit');
    Route::put('PODAapplication/{PODAapplication}', [PodaApplicationController::class, 'update'])->name('PODAapplication.update');
    Route::delete('PODAapplication/{PODAapplication}', [PodaApplicationController::class, 'destroy'])->name('PODAapplication.destroy');
    Route::put('/PODAapplication/{id}/update-status', [PodaApplicationController::class, 'updateStatus'])->name('PODAapplication.updateStatus');
});

// PPFapplication routes
Route::middleware('auth')->group(function () {
    Route::post('PPFapplication', [PPFapplicationController::class, 'store'])->name('PPFapplication.store');
    Route::get('PPFapplication/{PPFapplication}', [PPFapplicationController::class, 'show'])->name('PPFapplication.show');
    Route::get('PPFapplication/{PPFapplication}/edit', [PPFapplicationController::class, 'edit'])->name('PPFapplication.edit');
    Route::put('PPFapplication/{PPFapplication}', [PPFapplicationController::class, 'update'])->name('PPFapplication.update');
    Route::delete('PPFapplication/{PPFapplication}', [PPFapplicationController::class, 'destroy'])->name('PPFapplication.destroy');
    Route::put('/PPFapplication/{id}/update-status', [PPFapplicationController::class, 'updateStatus'])->name('PPFapplication.updateStatus');
});

// TODADropping routes
Route::middleware('auth')->group(function () {
    Route::post('/TODADropping', [DroppingController::class, 'storedroptoda'])->name('TODADropping.store');
    Route::get('/TODADropping/edit/{TODAdropping}', [DroppingController::class, 'edittoda'])->name('TODADropping.edit');
    Route::put('/todadropping/update/{TODAdropping}', [DroppingController::class, 'updatedroptoda'])->name('TODADropping.update');
    Route::delete('/todadropping/{TODAdropping}', [DroppingController::class, 'TODAdestroy'])->name('TODADropping.TODAdestroy');
    Route::put('/TODADropping/{id}/update-status', [DroppingController::class, 'updateStatustoda'])->name('TODADropping.updateStatus');

    Route::get('/TODADropping/show/{TODAdropping}', [DroppingController::class, 'showtoda'])->name('TODADropping.show');
});


Route::middleware('auth')->group(function () {
    Route::post('/PODAdropping', [DroppingController::class, 'storedroppoda'])->name('PODAdropping.store');
    Route::get('/PODAdropping/edit/{PODAdropping}', [DroppingController::class, 'editpoda'])->name('PODAdropping.edit');
    Route::put('/PODAdropping/update/{PODAdropping}', [DroppingController::class, 'updatedroppoda'])->name('PODAdropping.update');
    Route::delete('/PODAdropping/{PODAdropping}', [DroppingController::class, 'PODAdestroy'])->name('PODAdropping.PODAdestroy');
    Route::put('/PODAdropping/{id}/update-status', [DroppingController::class, 'updateStatuspoda'])->name('PODAdropping.updateStatus');

    Route::get('/PODADropping/show/{PODAdropping}', [DroppingController::class, 'showpoda'])->name('PODADropping.show');
});

Route::middleware('auth')->group(function () {
    // Manually define each route for the ServiceApplication resource
    Route::post('ServiceApplication', [ServiceApplicationController::class, 'store'])->name('ServiceApplication.store');
    Route::get('ServiceApplication/{ServiceApplication}', [ServiceApplicationController::class, 'show'])->name('ServiceApplication.show');
    Route::get('ServiceApplication/{ServiceApplication}/edit', [ServiceApplicationController::class, 'edit'])->name('ServiceApplication.edit');
    Route::put('ServiceApplication/{ServiceApplication}', [ServiceApplicationController::class, 'update'])->name('ServiceApplication.update');
    Route::delete('ServiceApplication/{ServiceApplication}', [ServiceApplicationController::class, 'destroy'])->name('ServiceApplication.destroy');
});

// TMU routes
Route::middleware(['auth', 'role:tmu'])->group(function () {
    Route::get('tmu/dashboard', [ViolatorController::class, 'index'])->name('tmu.dashboard');
    
    Route::prefix('violators')->name('violators.')->group(function () {
        // List all violators
        Route::get('/', [ViolatorController::class, 'index'])->name('index');
        
        // Upload violators list
        Route::post('/upload', [ViolatorController::class, 'upload'])->name('upload');

        // Store a new violator
        Route::post('/', [ViolatorController::class, 'store'])->name('store');
        
        // Update an existing violator
        Route::put('/{violator}', [ViolatorController::class, 'update'])->name('update');
        
        // Delete a violator
        Route::delete('/{violator}', [ViolatorController::class, 'destroy'])->name('destroy');
    });
});

//superadmin
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('superadmin/dashboard', [AdminController::class, 'superindex'])->name('superadmin.dashboard');
    Route::get('/officers', [UserController::class, 'index'])->name('officers.index');
    Route::get('/tmu_officers', [UserController::class, 'tmu_index'])->name('tmu.index');

    Route::get('/TODAapplication-history', [SuperAdminController::class, 'showAllHistory'])->name('TodaApp.history');
});

Route::middleware(['auth', 'role:superadmin,admin'])->group(function () {
    Route::get('/TODAapplication', [TODAapplicationController::class, 'index'])->name('TODAapplication.index');
    Route::get('/PODAapplication', [PodaApplicationController::class, 'index'])->name('PODAapplication.index');
    Route::get('/PPFapplication', [PPFapplicationController::class, 'index'])->name('PPFapplication.index');
    Route::get('/TODADropping', [DroppingController::class, 'todaIndex'])->name('TODADropping.index');
    Route::get('/PODAdropping', [DroppingController::class, 'podaIndex'])->name('PODAdropping.index');

    Route::get('ServiceApplication', [ServiceApplicationController::class, 'index'])->name('ServiceApplication.index');
    Route::get('/users', [UserController::class, 'driverIndex']);
    
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users')->name('user.')->group(function () {
        Route::post('/', [UserController::class, 'user_store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tmu')->name('tmu.')->group(function () {
        Route::post('/', [UserController::class, 'tmu_store'])->name('store');
        Route::put('/{id}', [UserController::class, 'tmu_update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'tmu_destroy'])->name('destroy');
    });

     Route::post('/update-remarks/toda/{id}', [TODAapplicationController::class, 'updateRemarks'])->name('update.remarks.toda');
     Route::post('/update-remarks/poda/{id}', [PodaApplicationController::class, 'updateRemarks'])->name('update.remarks.poda');
     Route::post('/update-remarks/sticker/{id}', [PPFapplicationController::class, 'updateRemarks'])->name('update.remarks.sticker');
     Route::post('/update-remarks/private-service/{id}', [ServiceApplicationController::class, 'updateRemarks'])->name('update.remarks.privatse-service');
     Route::post('/update-remarks/poda-drop/{id}', [DroppingController::class, 'podaupdateRemarks'])->name('update.remarks.poda-drop');
     Route::post('/update-remarks/toda-drop/{id}', [DroppingController::class, 'todaupdateRemarks'])->name('update.remarks.toda-drop');


    //upload-reupload admin
     Route::post('/admin/toda-requirements/{toda_application_id}/upload/{requirement_type}', 
     [todaRequirementsController::class, 'adminUpload'])
     ->name('admin.toda-requirements.upload');

     Route::post('/admin/poda-requirements/{poda_application_id}/upload/{requirement_type}', 
     [PodaRequirementsController::class, 'adminUpload'])
     ->name('admin.poda-requirements.upload');

     Route::post('/admin/sticker-requirements/{sticker_application_id}/upload/{requirement_type}', 
     [StickerRequirementsController::class, 'adminUpload'])
     ->name('admin.sticker-requirements.upload');

     Route::post('/admin/service-requirements/{private_service_id}/upload/{requirement_type}', 
     [ServiceRequirementController::class, 'adminUpload'])
     ->name('admin.service-requirements.upload');

     Route::post('/admin/todadrop-requirements/{toda_dropping_id}/upload/{requirement_type}', 
     [TodaDroppingRequirementsController::class, 'adminUpload'])
     ->name('admin.todadrop-requirements.upload');

     Route::post('/admin/podadrop-requirements/{poda_dropping_id}/upload/{requirement_type}', 
     [PodaDroppingRequirementsController::class, 'adminUpload'])
     ->name('admin.podadrop-requirements.upload');
});


Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/google-auth/callback', [GoogleAuthController::class, 'callback']);
Route::get('/check-redirect', function() {
    return config('app.url') . '/google-auth/callback';
});

Route::get('language/{lang}', [App\Http\Controllers\LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/api/predefined-messages/{id}', [PredefinedMessageController::class, 'show']);
Route::put('/api/toda-applications/{id}/remarks', [TODAApplicationController::class, 'updateRemarks']);

// In routes/web.php
Route::get('/test-sms', function() {
    $controller = new \App\Http\Controllers\SendSMSController();
    $request = new \Illuminate\Http\Request();
    $request->merge([
        'number' => '9682952301', // Your number
        'message' => 'Test SMS ' . date('Y-m-d H:i:s')
    ]);
    return $controller->sendSMS($request);
});
Route::fallback(function () {
    return view('errors.custom');
});
require __DIR__.'/auth.php';

