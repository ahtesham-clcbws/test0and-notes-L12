<?php

namespace App\Livewire\Frontend;

use App\Models\NewModels\Pages as PageModel;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('Layouts.frontend')]
class Pages extends Component
{
    public ?PageModel $page;

    public function mount(string $slug)
    {
        if (!$slug) {
            return redirect('/');
        }
        if ($page = PageModel::where('slug', $slug)->first()) {
            $this->page = $page;
        } else {
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.frontend.pages');
    }
}
