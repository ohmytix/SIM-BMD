<?php

namespace App\Livewire\Aset;

use Livewire\Component;
use Livewire\Attributes\Layout;

class AsetRekonsiliasi extends Component
{
    #[Layout('layouts.app')] // Arahkan ke resources/views/layouts/app.blade.php
    public function render()
    {
        return view('livewire.aset.aset-rekonsiliasi');
    }
}
