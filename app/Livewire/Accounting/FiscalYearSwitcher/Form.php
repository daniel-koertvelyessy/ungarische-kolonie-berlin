<?php

namespace App\Livewire\Accounting\FiscalYearSwitcher;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Form extends Component
{
    public array $fiscalYears = [];

    public string $current_fiscal_year;

    public function mount(): void
    {
        $this->current_fiscal_year = session('financialYear');
        $this->fiscalYears = DB::table('transactions')
            ->selectRaw('DISTINCT strftime("%Y", date) as year')
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->all();
    }

    public function setFY($fy): void
    {
        Session::put('financialYear', $fy);
        $this->redirect(request()->header('Referer') ?? '/dashboard');
    }

    public function render()
    {
        return view('livewire.accounting.fiscal-year-switcher.form');
    }
}
