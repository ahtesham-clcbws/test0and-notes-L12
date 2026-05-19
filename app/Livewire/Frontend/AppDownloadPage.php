<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AppDownloadPage extends Component
{
    #[Layout('Layouts.frontend')]
    public function render()
    {
        return view('livewire.frontend.app-download-page');
    }
}
