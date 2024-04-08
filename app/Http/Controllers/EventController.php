<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class EventController extends Controller
{
    public function show($id)
    {

        $event = Order::findOrFail($id);
        return view('filament.pages.show', compact('event'));
    }
}
