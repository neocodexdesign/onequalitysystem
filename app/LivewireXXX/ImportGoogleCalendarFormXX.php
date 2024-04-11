<?php

namespace App\Livewire;

use Livewire\Component;
use Modal\ModalComponent; // Se estiver usando o Livewire Modal


class ImportGoogleCalendarForm extends ModalComponent
{
    protected $listeners = ['openModal'];

    public $dateFrom;
    public $dateTo;
    public $status;

    protected $rules = [
        'dateFrom' => 'required|date',
        'dateTo' => 'required|date|after_or_equal:dateFrom',
        'status' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        // Aqui você pode redirecionar ou chamar diretamente o controller
        // Por exemplo, redirecionando para uma rota que trata a lógica
        return redirect()->route('importfromgoogle', [
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'status' => $this->status,
        ]);
    }

    public function render()
    {
        return view('livewire.import-google-calendar-form');                              
    }

}