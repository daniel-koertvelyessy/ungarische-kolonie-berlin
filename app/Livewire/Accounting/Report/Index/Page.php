<?php

declare(strict_types=1);

namespace App\Livewire\Accounting\Report\Index;

use App\Actions\Report\CreateAccountReportAudit;
use App\Livewire\Forms\Accounting\AccountReportAuditForm;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\Sortable;
use App\Mail\InviteAccountAuditMemberMail;
use App\Models\Accounting\AccountReport;
use App\Models\Accounting\AccountReportAudit;
use App\Models\Membership\Member;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Page extends Component
{
    use HasPrivileges;
    use Sortable;
    use WithPagination;

    public Collection $auditorList;

    public AccountReportAuditForm $form;

    public $selectedMember;

    public $selectedReport;

    #[Computed]
    public function reports(): LengthAwarePaginator
    {
        return AccountReport::query()
            ->with('account')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function mount(): void
    {
        $this->auditorList = collect(); // Initialisiere eine leere Collection
    }

    public function initiateAudit(int $id): void
    {
        if (! $this->checkPrivilege(AccountReport::class)) {
            return; // Stop execution if unauthorized
        }

        $this->selectedReport = AccountReport::find($id);

        Flux::modal('initiate-report-audit')->show();
    }

    public function addAuditor(): void
    {
        if (! $this->checkPrivilege(AccountReport::class)) {
            return; // Stop execution if unauthorized
        }

        if ($this->selectedMember) {
            $member = Member::find($this->selectedMember);
            if (! $this->auditorList->contains($member)) {
                $this->auditorList->push($member);
            }

        }
    }

    public function removeAuditor(int $auditorId): void
    {
        if (! $this->checkPrivilege(AccountReport::class)) {
            return; // Stop execution if unauthorized
        }

        $member = Member::find($auditorId);
        if ($this->auditorList->contains($member)) {
            $this->auditorList->pop($auditorId);
        }
    }

    public function sendInvitations(): void
    {
        if (! $this->checkPrivilege(AccountReport::class)) {
            return; // Stop execution if unauthorized
        }

        if ($this->auditorList->count()) {

            foreach ($this->auditorList as $auditor) {
                $this->form->account_report_id = $this->selectedReport->id;
                $this->form->user_id = $auditor->user->id;

                if ($auditor->hasUser()) {
                    $audit = CreateAccountReportAudit::handle($this->form);

                    Mail::to($auditor->email)
                        ->locale($auditor->locale)
                        ->queue(new InviteAccountAuditMemberMail($auditor, $this->selectedReport, $audit));

                    Flux::toast(
                        text: 'Einladung an '.$auditor->email.' verschickt',
                        heading: '... ist raus',
                        variant: 'success',
                    );
                } else {
                    Flux::toast(
                        text: 'Keine E-Mail für '.$auditor->email.' gefunden',
                        heading: 'Nicht so schnell',
                        variant: 'warning',
                    );
                }
            }

        } else {
            Flux::toast(
                text: 'Es sollten noch Auditoren zur Prüfung ausgewählt werden!',
                heading: 'Nicht so schnell',
                variant: 'warning',
            );
        }
    }

    public function auditReport(int $auditId): void
    {
        $accountAudit = AccountReportAudit::query()->findOrfail($auditId);
        // dd($accountAudit);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.accounting.report.index.page');
    }
}
