<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\Hospital;
use App\Models\User;

class FormModals extends Component
{
    public string $id;
    public $barangays;
    public $diseases;
    public $hospitals;
    public $patient;

    public function __construct(string $id, $patient = null, $hospitals = null, $diseases = null)
    {
        $this->id = $id;
        $this->patient = $patient;
        $this->barangays = Barangay::all();
        $this->diseases = $diseases ?? Disease::all();
        $this->hospitals = $hospitals ?? Hospital::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.modals.form-modals');
    }
}