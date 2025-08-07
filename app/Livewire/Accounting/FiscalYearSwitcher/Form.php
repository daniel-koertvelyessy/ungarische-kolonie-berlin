<?php

declare(strict_types=1);

namespace App\Livewire\Accounting\FiscalYearSwitcher;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

final class Form extends Component
{
    public array $fiscalYears = [];

    public string $current_fiscal_year;

    public function mount(): void
    {

        //        $fy = (string) session('financialYear');
        //
        //        $this->current_fiscal_year = $fy ?? Carbon::now()->format('Y');
        $this->current_fiscal_year = session('current_fiscal_year') ?? Carbon::now()->format('Y');
        $this->fiscalYears = DB::table('transactions')
            ->selectRaw('DISTINCT strftime("%Y", date) as year')
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->all();
    }

    public function setFY(string $fy): void
    {
        Session::put('financialYear', $fy);
        $this->redirect(request()->header('Referer') ?? '/dashboard');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.fiscal-year-switcher.form');
    }
}
