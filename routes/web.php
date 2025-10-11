<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MpesaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ContactController;


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

use Illuminate\Support\Facades\Auth;
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/admin',[AdminController::class, 'admin'])->name('admin');
Route::post('/addUser', [UserController::class, 'adminAddUser'])->name('adminAddUser');
Route::post('/addAdmin', [AdminController::class, 'adminAddAdmin'])->name('adminAddAdmin');
Route::post('/updateUser', [UserController::class, 'adminUpdateUser'])->name('adminUpdateUser');
Route::post('/updateAdmin', [AdminController::class, 'adminUpdateAdmin'])->name('adminUpdateAdmin');
Route::post('/deleteUser', [UserController::class, 'adminDeleteUser'])->name('adminDeleteUser');
Route::post('/deleteAdmin', [AdminController::class, 'adminDeleteAdmin'])->name('adminDeleteAdmin');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/addCar', [CarController::class, 'adminAddCar'])->name('adminAddCar');
Route::post('/updateCar', [CarController::class, 'adminUpdateCar'])->name('adminUpdateCar');
Route::post('/deleteCar', [CarController::class, 'adminDeleteCar'])->name('adminDeleteCar');
Route::resource('car-models', [CarModelController::class, 'index'])->name('car_models.index');
Route::post('/searchCar', [CarController::class, 'searchCar'])->name('searchCar.index');
Route::get('/myProfile', [MyProfileController::class, 'profile'])->name('profile.index');
Route::post('/myProfile/update', [MyProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/customerRegistration', [UserController::class, 'customerRegistration'])->name('customerRegistration');
Route::get('/carDetails', [CarController::class, 'carDetails'])->name('carDetails');
Route::get('/carDetailsPerKm', [CarController::class, 'carDetailsPerKm'])->name('carDetailsPerKm');
Route::get('/carDetailsPerDay', [CarController::class, 'carDetailsPerDay'])->name('carDetailsPerDay');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/contact',[HomeController::class, 'contact'])->name('contact');
Route::get('/about',[HomeController::class, 'about'])->name('about');

// Route to file download
Route::get('/download-file/{filename}', [UserController::class, 'downloadFile'])->name('downloadFile');
// Route to upload file
Route::post('/upload-file', [UserController::class, 'uploadFile'])->name('uploadFile');

Route::get('/', [CarController::class, 'welcome'])->middleware('auth')->name('welcome');
Route::post('/bookcarPerDay', [BookingController::class, 'bookCarPerDay'])->name('bookCarPerDay');
Route::post('/bookcarPerKm', [BookingController::class, 'bookCarPerKm'])->name('bookCarPerKm');

// Route::post('/createBookingAndRedirectToPayment', [BookingController::class, 'createBookingAndRedirectToPayment'])->name('createBookingAndRedirectToPayment');
Route::match(['get', 'post'],'/redirectToPaymentPagePerDay', [BookingController::class, 'redirectToPaymentPagePerDay'])->name('redirectToPaymentPagePerDay');
Route::match(['get', 'post'],'/redirectToPaymentPagePerKm', [BookingController::class, 'redirectToPaymentPagePerKm'])->name('redirectToPaymentPagePerKm');

Route::get('/process-payment-direct/{car}', [BookingController::class, 'showDirectPaymentPage'])->name('process.payment.direct');
Route::post('/process-booking-payment-direct', [BookingController::class, 'processDirectBookingPayment'])->name('process.booking.payment.direct');
Route::post('/bookcarPerKm', [BookingController::class, 'bookCarPerKm'])->name('bookCarPerKm');
// Route::post('/initiatePaymentAndBooking', [BookingController::class, 'initiatePaymentAndBooking'])->name('initiatePaymentAndBooking');
// Route::post('/initiatePaymentAndBookingPerKm', [BookingController::class, 'initiatePaymentAndBookingPerKm'])->name('initiatePaymentAndBookingPerKm');
Route::get('/customerBookings', [BookingController::class, 'customerBookings'])->name('customerBookings');
Route::get('allBookings', [BookingController::class, 'allBookings'])->name('allBookings');
Route::get('/carListings', [CarController::class, 'carListings'])->name('carListings');
Route::get('/adminDashboard', [HomeController::class, 'adminDashboard'])->name('adminDashboard');
Route::post('/makePayment/{booking}', [BookingController::class, 'makePayment'])->name('makePayment');
Route::get('/downloadReceipt/{booking}', [BookingController::class, 'downloadReceipt'])->name('downloadReceipt');
Route::post('/deleteBooking/{booking}', [BookingController::class, 'destroy'])->name('deleteBooking');
Route::post('/makePaymentAll', [BookingController::class, 'makePaymentAll'])->name('makePaymentAll');

Route::post('/returnCar/{booking}', [BookingController::class, 'returnCar'])->name('returnCar');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/contact-messages', [ContactController::class, 'messages'])->name('contact.messages')->middleware('auth');
Route::post('/deleteMessage/{message}', [ContactController::class, 'deleteMessage'])->name('deleteMessage');
Route::post('/replyMessage/{message}', [ContactController::class, 'replyMessage'])->name('replyMessage');

Route::post('/sendResetPassword', [UserController::class, 'sendResetPassword'])->name('sendResetPassword');
Route::get('forgotPassword', [UserController::class, 'forgotPassword'])->name('forgotPassword');

Route::get('/sms', [SmsController::class, 'sms'])->name('sms');
Route::get('/mpesa/{bookingId}', [MpesaController::class, 'mpesa'])->name('mpesa');

// M-Pesa callback route (no CSRF protection needed for external callbacks)
Route::post('/mpesa/callback', [BookingController::class, 'mpesaCallback'])->name('mpesa.callback');

// Payment processing routes
Route::match(['get', 'post'],'/process-payment/{booking}', [BookingController::class, 'PaymentPage'])->name('PaymentPage');
Route::post('/process-payment', [BookingController::class, 'processPayment'])->name('processPayment');


