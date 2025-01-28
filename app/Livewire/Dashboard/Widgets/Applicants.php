<?php

namespace App\Livewire\Dashboard\Widgets;

use App\Enums\MemberType;
use App\Models\Member;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Applicants extends Component
{

    use WithPagination;

    public array $selectedApplicants = [];
    public array $applicantsOnPage = [];
    public array $allApplicants = [];

    public $sortBy = 'date';
    public $sortDirection = 'desc';
    public string $search = '';

    protected $numApplicants;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    protected function applySearch($query)
    {
        return $this->search !== '' ? $query->where($this->search, 'like', '%'.$this->search.'%') : $query;
    }

    protected function applySortDirection($query)
    {
        return $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query;
    }


    public function deleteSelectedApplicants(): void{


        if (count($this->selectedApplicants) > 0 && Auth()->user()->is_admin)  {

            foreach ($this->selectedApplicants as $applicant) {
                Member::find($applicant)->delete();
            }
            Flux::toast(
                heading: __('members.widgets.applicants.confirm.deletion.title'),
                text: __('members.widgets.applicants.confirm.deletion.text'),
                variant: 'success',
            );
        }


    }

    #[Computed]
    public function applicants(): LengthAwarePaginator
    {

        $this->numApplicants = Member::countNewApplicants();

        $this->allApplicants = Member::Applicants()->map(fn ($member) => (string) $member->id)->toArray();

        $applicantList = \App\Models\Member::query()
            ->whereIn('type', [MemberType::AP->value])
            ->tap(fn($query) => $this->search !== '' ? $query->where('name', 'like', '%'.$this->search.'%') : $query)
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(5);

        $this->applicantsOnPage = $applicantList->map(fn ($member) => (string) $member->id)->toArray();

        return $applicantList;
    }

    public function render()
    {
        return view('livewire.dashboard.widgets.applicants');
    }
}
