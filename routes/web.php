<?php

use App\Http\Controllers\{
    Profile\ProfileController,
    Invoices\InvoiceController,
    Invoices\ArchiveController,
    Sections\SectionController,
    Products\ProductController,
};

use Illuminate\Support\Facades\Route;

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

Route::get('/', fn () => redirect()->route('login'));


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('invoices', InvoiceController::class);
    Route::get('/section/{id}', [InvoiceController::class, 'getproducts']);
    Route::get('/InvoicesDetails/{id}', [InvoiceController::class, 'show']);
    Route::post('invoiceattachmentsadd', [InvoiceController::class, 'invoiceattachmentsadd'])->name('invoiceattachmentsadd');
    Route::get('View_file/{invoice_number}/{file_name}', [InvoiceController::class, 'open_file']);
    Route::get('Download/{invoice_number}/{file_name}', [InvoiceController::class, 'download_file']);
    Route::post('delete_file', [InvoiceController::class, 'delete_file'])->name('delete_file');
    Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit']);
    Route::get('Print_invoice/{id}', [InvoiceController::class, 'print_invoice']);
    Route::resource('archives', ArchiveController::class);



    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::post('delete_all_p', [ProductController::class, 'delete_all_p'])->name('delete_all_p');
    Route::post('Filter_Products_Section', [ProductController::class, 'Filter_Products_Section'])->name('Filter_Products_Section');
});

require __DIR__.'/auth.php';
