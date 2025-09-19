<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\Hospital;

class FormModals extends Component
{
    public string $id;
    public $barangays;
    public $diseases;
    public $hospitals;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->barangays = Barangay::all();
        $this->diseases  = Disease::all();
        $this->hospitals = Hospital::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.modals.form-modals');
    }
}
