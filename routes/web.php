<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();
// Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoiceController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);

Route::get('/section/{id}', [InvoiceController::class, 'getProducts']);

Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);

Route::get('/editInvoice/{id}', [InvoiceController::class, 'edit'])->name('editInvoice');
Route::get('/invoicesDetails/{id}', [InvoiceController::class, 'show']);



Route::get('/viewFile/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'openFile']);
Route::get('/download/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'getFile']);
Route::post('/delete_file', [InvoiceAttachmentsController::class, 'destroy'])->name('delete_file');

Route::get('/{page}', [AdminController::class, 'index']);
