<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Google;
use App\Http\Livewire\CalendarModal;

use App\Http\Controllers\WorkdoneController;
use App\Http\Controllers\GoogleImportController;

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
    return view('welcome');
});

Route::get('/google.getDatetoImport', function () {
    return view('google.getDatetoImport');
})->name('google.import');


// Definindo a rota 'importfromgoogle'
Route::get('/importfromgoogle', [GoogleImportController::class, 'import'])->name('importfromgoogle');
Route::get('/wwd', [WorkdoneController::class, 'list'])->name('list');

Route::get('/proposals/print/{proposal}', [ProposalController::class, 'print'])->name('proposals.print');

Route::get('/proposals/tabelaPreco{proposal}', [ProposalController::class, 'tabelaPreco'])->name('proposals.tabelaPreco');

Route::get('/proposals/print-contract/{contract}', [ProposalController::class, 'printContract'])->name('proposals.printContract');

Route::get('/testcalendar', [CalendarController::class, 'eventos'])->name('eventos');

Route::get('/calendar', [CalendarController::class, 'calendar'])->name('calendar');

// Definindo a rota para buscar ordens por data
Route::get('/get-orders-by-date', [OrderController::class, 'getOrdersByDate'])->name('getOrdersByDate');

Route::get('printexcel', [ImportExcelController::class, 'printexcel'])->name('printexcel');

Route::get('/exportorder', [ExportController::class, 'exportOrder'])->name('exportorder');

Route::get('/exportcalendar', [ExportController::class, 'exportCalendar'])->name('exportcalendar');

Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

Route::get('/events/modal/{eventId}', function ($eventId) {
    //dd($eventId); // Comente ou remova esta linha
    return view('livewire.calendar-modal', ['eventId' => $eventId]);
})->name('events.modal');

/*
Route::get(
    '/admin/resources/events/{event}/view',
    [EventController::class, 'show']
    // Sua lógica para exibir um evento específico aqui.
    // Você pode precisar ajustar isso de acordo com suas necessidades.
)->name('filament.admin.resources.events.view');

Route::get('/emilio/{id}', [EventController::class, 'show'])->name('emilio');
/*
Route::get('master', 'FullCalendarController@index')->name('index');
Route::get('searchCleaning', 'FullCalendarController@index')->name('searchCleaning');
Route::get('/load-events', 'EventController@loadEvents')->name('routeLoadEvents');
Route::put('/event-update', 'EventController@update')->name('routeEventUpdate');
Route::delete('/event-destroy', 'EventController@destroy')->name('routeEventDelete');
*/
