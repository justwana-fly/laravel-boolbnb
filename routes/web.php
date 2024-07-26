<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\LeadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Apartment;
use App\Http\Controllers\Admin\PaymentController;


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
Route::get('/', [HomeController::class, 'index'])->name('home');

// Middleware controlla se l'utente è autenticato e verificato; se sì, allora le rotte vengono eseguite;
// se no entra in gioco la rotta di fallback che rimanda alla dashboard: ma se non è autenticato,
// allora viene rimandato alla login (e questo è definito in app/Http/Middleware/Authenticate.php)
Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [ApartmentController::class, 'index'])->name('admin.apartments.index');
    Route::get('/admin/apartments', [ApartmentController::class, 'index'])->name('admin.apartments.index');
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments'=>'apartment:slug']);
    Route::resource('services', ServiceController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('leads', LeadController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'verified'])
->name('admin.')
->prefix('admin')
->group(function () {
Route::resource('apartments', ApartmentController::class)->parameters(['apartments'=>'apartment:slug']);
// Definisci le rotte per le sponsorizzazioni

Route::get('promotion/create/{apartment:slug}', [PromotionController::class, 'create'])->name('promotion.create');
Route::post('promotion/store/{apartment:slug}', [PromotionController::class, 'store'])->name('promotion.store');
Route::get('promotion/show/{apartment:slug}', [PromotionController::class, 'show'])->name('promotion.show');
});
Route::get('/remove-expired-promotions', [PromotionController::class, 'removeExpiredPromotions'])->name('admin.promotions.removeExpired');


Route::get('admin/payment/form', [PaymentController::class, 'show'])->name('admin.payment.form');
Route::post('admin/payment/process', [PaymentController::class, 'process'])->name('admin.payment.process');
Route::get('admin/payment/success', [PaymentController::class, 'success'])->name('admin.payment.success');
Route::get('admin/payment/show', [PaymentController::class, 'show'])->name('admin.payment.show');




require __DIR__ . '/auth.php';

Route::fallback(function () {
    return redirect()->route('admin.apartments.index');
});
