<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomersReportsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesReportsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
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

Route::get('editInvoice/{id}', [InvoiceController::class, 'edit'])->name('editInvoice');
Route::get('print_invoice/{id}', [InvoiceController::class, 'print_invoice'])->name('print_invoice');

Route::get('invoicesDetails/{id}', [InvoiceController::class, 'show']);

Route::get('editPaymentStatus/{id}', [InvoiceDetailsController::class, 'edit'])->name('edit-payment-status');
Route::get('updatePaymentStatus/{id}', [InvoiceDetailsController::class, 'update'])->name('update_payment_status');

Route::get('viewFile/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'openFile']);
Route::get('download/{invoice_number}/{file_name}', [InvoiceAttachmentsController::class, 'getFile']);
Route::post('delete_file', [InvoiceAttachmentsController::class, 'destroy'])->name('delete_file');

Route::get('invoices_paid', [InvoiceController::class, 'invoices_paid']);
Route::get('invoices_unpaid', [InvoiceController::class, 'invoices_unpaid']);
Route::get('invoices_partiall', [InvoiceController::class, 'invoices_partiall']);

Route::resource('invoices_archive', InvoicesArchiveController::class);

Route::get('export_invoices', [InvoiceController::class, 'export']);

Route::get('invoices_reports', [InvoicesReportsController::class, 'index']);
Route::post('search_invoices', [InvoicesReportsController::class, 'search_invoices'])->name('search_invoices');

Route::get('customers_reports', [CustomersReportsController::class, 'index']);
Route::post('search_customers', [CustomersReportsController::class, 'search_customers'])->name('search_customers');

Route::get('markAsRead_all', [InvoiceController::class, 'markAsReadAll'])->name('markAsRead_all');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index']);
