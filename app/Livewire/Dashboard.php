<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.app')]



class Dashboard extends Component
{
    
     // Arahkan ke resources/views/layouts/app.blade.php
    public function render()
    {
        $summary = app(\App\Livewire\Rekap\Index::class)->getSummaryRekap();
        return view('welcome', [
            'summary' => $summary
        ]);
    }
}