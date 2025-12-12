<?php

namespace App\Livewire\Frontend;

use App\Models\NewModels\FrequentlyAskedQuestion;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('Layouts.frontend')]
class Faq extends Component
{
    public function render()
    {
        $faqs = FrequentlyAskedQuestion::where('status', true)->inRandomOrder()->get();
        return view('livewire.frontend.faq', ['faqs'=>$faqs]);
    }
}
