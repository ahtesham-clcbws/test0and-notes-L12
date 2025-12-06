<?php

namespace App\Livewire\Admin\Pages;

use App\Models\NewModels\Pages;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layouts.admin')]
class PagesList extends Component
{
    public function render()
    {
        $pages = Pages::all();
        return view('livewire.admin.pages.pages-list',[
            'pages' => $pages
        ]);
    }
}
