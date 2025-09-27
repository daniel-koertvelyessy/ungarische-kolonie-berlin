<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard\Widgets;

use App\Enums\MemberType;
use App\Models\Membership\Member;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

final class Applicants extends Component
{
    use WithPagination;

    public array $selectedApplicants = [];

    public array $applicantsOnPage = [];

    public array $allApplicants = [];

    public $sortBy = 'date';

    public $sortDirection = 'desc';

    public string $search = '';

    public int $numApplicants;

    public function sort($column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function mount()
    {
        $this->numApplicants = Member::countNewApplicants();
    }

    protected function applySearch($query)
    {
        return $this->search !== '' ? $query->where($this->search, 'like', '%'.$this->search.'%') : $query;
    }

    protected function applySortDirection($query)
    {
        return $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query;
    }

    public function deleteSelectedApplicants(): void
    {

        if (count($this->selectedApplicants) > 0 && Auth()->user()->is_admin) {

            foreach ($this->selectedApplicants as $applicant) {
                Member::find($applicant)->delete();
            }
            Flux::toast(
                heading: __('members.widgets.applicants.confirm.deletion.title'),
                text: __('members.widgets.applicants.confirm.deletion.text'),
                variant: 'success',
            );

            $this->numApplicants = Member::countNewApplicants();

        }

    }

    public function editSelectedApplicants()
    {
        if (count($this->selectedApplicants) > 1) {
            /**
             * TODO   make confirmation model to open n tabs with members to be edited
             *        or to choose one
             */
            exit;
        }

        return $this->redirect(route('backend.members.show', $this->selectedApplicants[0]));

    }

    #[Computed]
    public function applicants(): LengthAwarePaginator
    {
        /** @phpstan-ignore-next-line */
        $this->allApplicants = Member::Applicants()->map(fn ($member) => (string) $member->id)->toArray();

        $applicantList = \App\Models\Membership\Member::query()
            ->whereIn('type', [MemberType::AP->value])
            ->tap(fn ($query) => $this->search !== '' ? $query->where('name', 'like', '%'.$this->search.'%') : $query)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(5);

        $this->applicantsOnPage = $applicantList->map(fn ($member) => (string) $member->id)->toArray();

        return $applicantList;
    }

    public function render()
    {
        return view('livewire.dashboard.widgets.applicants');
    }
}
