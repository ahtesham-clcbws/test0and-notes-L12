<?php

namespace App\Livewire\Admin;

use App\Models\NewModels\ImportantLink;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layouts.admin')]
class ManageImportantLinks extends Component
{
    public function render()
    {
        $important_links = ImportantLink::query()
            ->orderByDesc('id')
            ->get();
        return view('livewire.admin.manage-important-links', [
            'important_links' => $important_links
        ]);
    }

    public bool $formState = false;
}
