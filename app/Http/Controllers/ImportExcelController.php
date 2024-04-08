<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Contracts\View\View;


use App\Models\Event;
use App\Imports\EventsImport;

class ImportExcelController extends Controller
{

    public function printExcel()
    {
        $data = Event::All();
        return view('filament.events.print', compact('data'));
    }

    public function importExcel()
    {
        return view('filament.events.upload');
    }
}
