<?php

namespace App\Livewire\Dashboard\Widgets;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class UpcommingBirthdayList extends Component
{
    use  WithPagination;

    public $monthName;

    public $currentMonth;

    #[Computed]
    public function members(): LengthAwarePaginator
    {

        return \App\Models\Membership\Member::query()
            ->whereMonth('birth_date', $this->currentMonth)
            ->orderByRaw("strftime('%d', birth_date) ASC")   // only for sqlite
//            ->orderByRaw('DAY(birth_date) ASC')
            ->paginate(5);

    }

    public function nextMonth(): void
    {
        if ($this->currentMonth < 12) {
            $this->currentMonth++;
        } else {
            $this->currentMonth = 1;
        }
        $this->dispatch('$refresh');
        $this->setMonthName();
        $this->resetPage();
    }

    public function previousMonth(): void
    {
        if ($this->currentMonth > 1) {
            $this->currentMonth--;
        } else {
            $this->currentMonth = 12;
        }
        $this->members();
        $this->setMonthName();
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->currentMonth = Carbon::today()->month;
        $this->setMonthName();

    }

    protected function setMonthName(): void
    {
        $date = Carbon::create(date('Y'), $this->currentMonth, '1');

        $locale = app()->getLocale();

        if ($locale === 'hu') {
            $banMonths = ['január', 'február', 'március', 'augusztus', 'október', 'november', 'december'];

            $monthName = $date->locale(app()->getLocale())->monthName;
            // Richtige Endung setzen
            $suffix = in_array($monthName, $banMonths) ? 'ban' : 'ben';

            $this->monthName = $monthName.$suffix;

        } else {
            $this->monthName = $date->locale(app()->getLocale())->monthName;
        }

    }

    public function render()
    {
        return view('livewire.dashboard.widgets.upcomming-birthday-list');
    }
}
