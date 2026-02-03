
<?php

use App\Http\Controllers\ConvocationRegistrationController;
use App\Http\Controllers\StudentExitSurveyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SecondProgramRegistrationController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PdfController;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/clear', function() {

Artisan::call('route:cache');
Artisan::call('cache:clear');
Artisan::call('config:cache');
Artisan::call('view:clear');
Artisan::call('serve');
return "Cleared!";
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

// Route::get('/pdf', function () {
//     return view('student.pdf.registration-form');
// });

// Route::get('/dashboard', function () {
//     //return view('dashboard');
//     return view('admin.dashboard.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Student
// Convocation Registration (First Program)
Route::middleware(['auth', 'verified', 'student'])->group(function () {
    //Route::get('/dashboard', [ConvocationRegistrationController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard/student/information/edit/{id}', [ConvocationRegistrationController::class, 'edit'])->name('edit_student_information');
    Route::post('dashboard/student/information/update', [ConvocationRegistrationController::class, 'update'])->name('update_student_information');
    Route::get('dashboard/student/photo/upload/{id}', [ConvocationRegistrationController::class, 'photoUpload'])->name('student_photo_upload');
    Route::post('dashboard/student/photo/upload/update', [ConvocationRegistrationController::class, 'photoUpdate'])->name('student_photo_update');
    Route::post('dashboard/student/convocation-registration', [ConvocationRegistrationController::class, 'formSubmit'])->name('student_form_submit');
    Route::get('dashboard/registration-form-pdf', [ConvocationRegistrationController::class, 'registrationFormPDF'])->name('registrationFormPDF');
    Route::get('dashboard/student-copy-pdf', [ConvocationRegistrationController::class, 'studentCopyPDF'])->name('studentCopyInPDF');
    Route::get('dashboard/download/payment-slip-pdf', [ConvocationRegistrationController::class, 'paymentSlipPDF'])->name('paymentSlipPDF');

    //PEO Form
    Route::get('dashboard/admin/add/peo', [AdminController::class, 'addPeo'])->name('add_peo');
    Route::get('dashboard/admin/add/peo_po', [AdminController::class, 'addPeoPO'])->name('add_peo_po');
    Route::post('dashboard/admin/add/peo/submit', [AdminController::class, 'submitPeo'])->name('submit_peo');
    Route::post('dashboard/admin/add/peo_po/submit', [AdminController::class, 'submitPeoPO'])->name('submit_peo_po');

    //Student Exit Survey
    Route::get('dashboard/student/student-exit-survey', [StudentExitSurveyController::class, 'create'])->name('student_exit_survey.add');
    Route::post('dashboard/student/student-exit-survey', [StudentExitSurveyController::class, 'store'])->name('student_exit_survey.store'); 

});
// Convocation Registration (Second Program - If Applicable)
Route::middleware(['auth', 'verified', 'student'])->group(function () {
    Route::get('dashboard/student/second-registration/{id}', [SecondProgramRegistrationController::class, 'add'])->name('student_second_registration');
    Route::post('dashboard/student/second-registration/submit', [SecondProgramRegistrationController::class, 'submit'])->name('student_second_registration_submit');
    Route::get('dashboard/student/second-registration/edit/{id}', [SecondProgramRegistrationController::class, 'edit'])->name('edit_second_registration');
    Route::post('dashboard/student/second-registration/update', [SecondProgramRegistrationController::class, 'update'])->name('update_second_registration');
});
//Support Ticket
Route::get('support/ticket', [SupportTicketController::class, 'add'])->name('add_support_ticket');
Route::post('support/ticket/submit', [SupportTicketController::class, 'submit'])->name('submit_ticket');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// Admin
// 
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    //First Program
    //Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    // PEO feedback
    Route::get('dashboard/admin/peo-feedback', [AdminController::class, 'peoFeedback'])->name('peo_feedback');
    
    // PEO + PO feedback
    Route::get('dashboard/admin/peo-po-feedback', [AdminController::class, 'peoPoFeedback'])->name('peo_po_feedback');

    Route::get('dashboard/admin/all-student', [AdminController::class, 'allStudent'])->name('all_student');
    Route::get('dashboard/admin/add/student', [AdminController::class, 'addStudent'])->name('add_student');
    Route::post('dashboard/admin/add/student/submit', [AdminController::class, 'submitStudent'])->name('submit_student');
    Route::get('dashboard/admin/student-information/view/{id}', [AdminController::class, 'viewStudent'])->name('admin_view_student_information');
    Route::get('dashboard/admin/student-information/edit/{id}', [AdminController::class, 'editStudent'])->name('admin_edit_student_information');
    Route::post('dashboard/admin/student-information/update', [AdminController::class, 'updateStudent'])->name('admin_update_student_information');
    Route::get('dashboard/admin/student-program-status-configuration/edit/{id}', [AdminController::class, 'editProgramStatusConfiguration'])->name('admin_edit_student_program_status_configuration');
    Route::post('dashboard/admin/student-program-status-configuration/update', [AdminController::class, 'updateProgramStatusConfiguration'])->name('admin_update_student_program_status_configuration');
    Route::get('dashboard/admin/student-information/edit/email/{id}', [AdminController::class, 'editStudentEmail'])->name('admin_edit_student_email');
    Route::post('dashboard/admin/student-information/email/update', [AdminController::class, 'updateStudentEmail'])->name('admin_update_student_email');
    Route::post('dashboard/admin/student-registration/confirmation', [AdminController::class, 'registrationConfirmation'])->name('registration_confirmation');
    //Route::get('dashboard/student/photo/upload/{id}', [AdminController::class, 'photoUpload'])->name('student_photo_upload');
    //Route::post('dashboard/student/photo/upload/update', [AdminController::class, 'photoUpdate'])->name('student_photo_update');
    //Second Program
    Route::get('dashboard/admin/student-second-registration/edit/{id}', [AdminController::class, 'editSecondProgram'])->name('admin_edit_second_registration');
    Route::post('dashboard/admin/second-registration/update', [AdminController::class, 'updateSecondProgram'])->name('admin_update_second_registration');
    //PDF
    Route::get('dashboard/registration-form-pdf/{id}', [PdfController::class, 'registrationFormPDF'])->name('adminRegistrationFormPDF');
    Route::get('dashboard/student-copy-pdf/{id}', [PdfController::class, 'studentCopyPDF'])->name('adminStudentCopyPDF');
    //Entry Pass PDF
    Route::get('dashboard/all-selected-entry-pass-in-pdf', [PdfController::class, 'adminAllSelectedEntryPassPDF'])->name('adminAllSelectedEntryPassPDF');
    //Support Ticket
    Route::get('dashboard/admin/support/ticket/all', [SupportTicketController::class, 'allSupportTicket'])->name('all_support_ticket');
    Route::post('dashboard/admin/support/ticket/solve', [SupportTicketController::class, 'solveSupport'])->name('admin_solve_support');
    //CSV for selected registration confirmed student list
    Route::get('dashboard/all-selected-student-list-in-excel', [AdminController::class, 'adminAllSelectedStudentListInExcel'])->name('adminAllSelectedStudentListInExcel');
    //CSV for registration completed student list
    Route::get('dashboard/admin/registration-completed-student-list-for-single-program-in-excel', [AdminController::class, 'registrationCompletedStudentListSingleProgramInExcel'])->name('registrationCompletedStudentListSingleProgramInExcel');
    Route::get('dashboard/admin/registration-completed-student-list-for-double-program-in-excel', [AdminController::class, 'registrationCompletedStudentListDoubleProgramInExcel'])->name('registrationCompletedStudentListDoubleProgramInExcel');
    Route::get('dashboard/admin/unregistered-student-list-in-excel', [AdminController::class, 'unRegisteredStudentListInExcel'])->name('unRegisteredStudentListInExcel');
    //CSV for registration confirmed student list
    Route::get('dashboard/admin/registration-confirmed-student-list-for-single-program-in-excel', [AdminController::class, 'registrationConfirmedStudentListSingleProgramInExcel'])->name('registrationConfirmedStudentListSingleProgramInExcel');
    Route::get('dashboard/admin/registration-confirmed-student-list-for-double-program-in-excel', [AdminController::class, 'registrationConfirmedStudentListDoubleProgramInExcel'])->name('registrationConfirmedStudentListDoubleProgramInExcel');
    //CSV for registration-completed but not confirmed list
    Route::get('dashboard/admin/registration-completed-but-not-confirmed-student-list-for-single-program-in-excel', [AdminController::class, 'totalRegistrationCompletedButNotConfirmedSingleProgramInExcel'])->name('totalRegistrationCompletedButNotConfirmedSingleProgramInExcel');
    Route::get('dashboard/admin/registration-completed-but-not-confirmed-student-list-for-double-program-in-excel', [AdminController::class, 'totalRegistrationCompletedButNotConfirmedDoubleProgramInExcel'])->name('totalRegistrationCompletedButNotConfirmedDoubleProgramInExcel');
});

// Route::get('/send-test-email', function () {
//     Mail::to('ishan@ndub.edu.bd')->send(new WelcomeEmail());

//     return 'Email sent successfully!';
// });

require __DIR__ . '/auth.php';