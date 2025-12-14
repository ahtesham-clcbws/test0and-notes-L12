<?php

namespace App\Livewire\Frontend;

use App\Models\NewModels\ImportantLink;
use Livewire\Component;

class ImportantLinksWebsitePage extends Component
{
    public function render()
    {
        $important_links = ImportantLink::orderByDesc('id')->where('status', true)->get();
        return view('livewire.frontend.important-links-website-page', [
            'important_links'=>$important_links
        ]);
    }
}
