<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AccionesArgentinaController;
use App\Http\Controllers\AccionesChileController;
use App\Http\Controllers\LeadsArgentinaController;
use App\Http\Controllers\LeadsChileController;
use App\Http\Controllers\ArgentinaController;
use App\Http\Controllers\ChileController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PDFCleController;

use App\Http\Controllers\CacController;

use Illuminate\Support\Facades\Mail;




//Route::group(['middleware' => ['web']], function () {
    // En este grupo, todas las rutas estarán protegidas por el middleware web

    // Ejemplo de rutas protegidas por el middleware web
    //Route::get('/', 'HomeController@index')->name('home');
    //Route::get('/perfil', 'PerfilController@index')->name('perfil');
    // Agrega más rutas que necesitan el middleware web aquí
//});

// Aquí puedes tener más rutas que no requieren middleware web

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

Route::get('/chile_cotiza/{id}/verPDF', [PDFCleController::class, 'verPDF']);
Route::get('/argentina_cotiza/{id}/verPDF', [PDFController::class, 'verPDF']);

Route::get('/argentina_cotiza/{id}/acepta', [ArgentinaController::class, 'acepta'])->name('acepta.argentina');

Route::get('/chile_cotiza/{id}/acepta', [ChileController::class, 'acepta'])->name('acepta.chile');

Route::get('/argentina_cotiza/{idconsulta}/editproyecto', [ArgentinaController::class, 'editProyecto'])->name('editproyecto.argentina');
Route::put('/argentina_cotiza/{id}/updateproyecto', [ArgentinaController::class, 'updateProyecto'])->name('actualizarproyecto.argentina');

Route::get('/argentina_cotiza/{idconsulta}/recotizar', [ArgentinaController::class, 'recotizar'])->name('recotizar.argentina');
Route::put('/argentina_cotiza/{id}/updateproyecto', [ArgentinaController::class, 'updateProyecto'])->name('actualizarproyecto.argentina');
//MODULOOOOOOOOOOOOOOOOOOOOOOO
Route::put('/argentina_cotiza/{id}/actualizarModulo', [ArgentinaController::class, 'actualizarModulo'])->name('actualizarModulo.argentina');
//FIN
Route::get('/chile_cotiza/{idconsulta}/recotizar', [ChileController::class, 'recotizar'])->name('recotizar.argentina');

Route::get('/chile_cotiza/{idconsulta}/editproyecto', [ChileController::class, 'editProyecto'])->name('editproyecto.chile');
Route::put('/chile_cotiza/{id}/updateproyecto', [ChileController::class, 'updateProyecto'])->name('actualizarproyecto.chile');

//MODILOSSSSSSSSSSSSSSSS
Route::put('/chile_cotiza/{id}/actualizarModulo', [ChileController::class, 'actualizarModulo'])->name('actualizarModulo.chile');
//FIN

Route::post('/guardar-motivochl', 'MotivochlController@guardarMotivo')->name('guardar.motivochl');
Route::post('/guardar-motivo', 'MotivoController@guardarMotivo')->name('guardar.motivo');

Route::post('/guardar-motivochl', 'MotivoController@guardarMotivoChl')->name('guardar.motivo.chl');

// Rutas para Argentina
Route::get('/argentina', [ArgentinaController::class, 'index']);
// ... otras rutas relacionadas con la lógica de Argentina
Route::get('/enviar-reportes', [PDFController::class, 'mailReportes']);

Route::post('/formulario', 'App\Http\Controllers\FormDataController@storeForm')->name('formulario.store');
Route::post('/formulario2', 'App\Http\Controllers\FormDataCleController@storeForm')->name('formulario2.store');

Route::post('/import/excel', 'App\Http\Controllers\ExcelImportController@import')->name('import.excel');
//Route::post('/import/excel', 'ExcelImportController@import')->name('import.excel');

Route::post('/import/excel_cl', 'App\Http\Controllers\ExcelImportController_cl@import')->name('import.excel_cl');


Route::get('/', [AuthController::class, 'index'])->name('home');

Route::resource("/usuarios", UsuariosController::class);

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::get('/logados', [AuthController::class, 'logados'])->name('logados');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('/password', PasswordController::class)
    ->parameters(['email' => 'email']);

Route::get('/show/{email}', [PasswordController::class, 'show'])->name('show');

Route::post('/store', [PasswordController::class, 'store'])->name('store');
Route::get('/showResetForm', [PasswordController::class, 'showResetForm'])->name('showResetForm');
Route::post('/reset', [PasswordController::class, 'reset'])->name('reset');

Route::resource("/roles", RolesController::class);

Route::resource("/leads_chile", LeadsChileController::class);
Route::get('/solicitar_cotizacion/chl/{id}', [LeadsChileController::class, 'solicitarCotizacion'])->name('solicitar_cotizacion');

Route::resource("/acciones_chile", AccionesChileController::class);
Route::get('/acciones_chile/create/{LeadsChile}', [AccionesChileController::class, 'create']);

Route::resource("/leads_argentina", LeadsArgentinaController::class);
Route::get('/solicitar_cotizacion/arg/{id}', [LeadsArgentinaController::class, 'solicitarCotizacion'])->name('solicitar_cotizacion');

Route::resource("/acciones_argentina", AccionesArgentinaController::class);
Route::get('/acciones_argentina/create/{LeadsArgentina}', [AccionesArgentinaController::class, 'create']);

Route::resource("/chile_cotiza", ChileController::class);
Route::resource("/argentina_cotiza", ArgentinaController::class);

Route::get('/argentina_cotiza/{id}/ver', [ArgentinaController::class, 'ver'])->name('ver.argentina');

Route::get('/argentina_cotiza/{id}/mail', [PDFController::class, 'enviarCotizacionMail']);

Route::get('/chile_cotiza/{id}/ver', [ChileController::class, 'ver'])->name('ver.chile');

Route::get('/chile_cotiza/{id}/mail', [PDFCleController::class, 'enviarCotizacionMail']);

Route::get('cac-bases', [CacController::class, 'cac'])->name('cac.agenda');
