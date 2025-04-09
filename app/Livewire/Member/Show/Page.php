<?php

namespace App\Livewire\Member\Show;

use App\Enums\MemberType;
use App\Livewire\Forms\Member\MemberForm;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\PersistsTabs;
use App\Livewire\Traits\Sortable;
use App\Mail\AcceptMembershipMail;
use App\Mail\InvitationMail;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Invitation;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use App\Models\User;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Page extends Component
{
    use HasPrivileges, PersistsTabs, Sortable, WithPagination;

    public $users;

    public int $newUser = 0;

    public Member $member;

    public MemberForm $memberForm;

    public $confirm_deletion_text = '';

    public $hasUser = false;

    protected $feeStatusResults = [];

    public $openFees;

    public $feeStatus;

    public $searchPayment = '';

    public $transaction;

    public string $defaultTab = 'member-show-profile';

    public string $selectedTab;

    public $invitation_status;

    protected $listeners = ['updated-payments' => 'payments', 'membershipAccepted'];

    public $fee_type;

    #[Computed]
    public function payments(): LengthAwarePaginator
    {
        return MemberTransaction::query()
            ->where('member_id', '=', $this->member->id)
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn ($query) => $this->searchPayment ? $query->whereHas('transaction', function ($query) {
                $query->where('label', 'LIKE', '%'.$this->searchPayment.'%')
                    ->orWhere('reference', 'LIKE', '%'.$this->searchPayment.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->searchPayment.'%');
            }) : $query)
            ->paginate(10);
    }

    public function mount(Member $member): void
    {
        try{
            $this->authorize('view', $member);
        } catch (AuthorizationException $e) {
            Flux::toast($e->getMessage(), 'error');
            Log::alert('Unberechtigter Zugriffsversuch ',[
                'Mitglied' => $member,
                'User' => Auth::user()??'extern',
                'msg' => $e->getMessage(),
            ]);
            $this->redirect(route('backend.members.index'),true);
        }
        $this->selectedTab = $this->getSelectedTab();
        $this->memberForm->set($member);
        $this->users = User::select('id', 'name')
            ->get();

        $this->invitation_status = $member->checkInvitationStatus();

        $this->feeStatusResults = $member->feeStatus();

        $this->feeStatus = $this->feeStatusResults['status'];
        $this->openFees = number_format($this->feeStatusResults['paid'], 2, ',', '.');

        $this->fee_type = $this->memberForm->fee_type;
    }

    public function detachUser(int $userid): void
    {
        if ($this->memberForm->user_id === $userid) {
            $this->memberForm->user_id = null;
            if ($this->member->save()) {
                $this->hasUser = false;
                Flux::toast(
                    text: __('members.show.detached.success.msg', ['name' => $this->member->name]),
                    heading: __('members.show.detached.success.head'),
                    variant: 'success',
                );
            }
        }
    }

    public function attachUser(): void
    {
        if ($this->newUser > 0) {
            $getUser = User::find($this->newUser);
            if ($getUser->id === $this->newUser) {
                $this->memberForm->member->user_id = $this->newUser;
                if ($this->memberForm->member->save()) {
                    $this->hasUser = true;

                    Flux::toast(
                        text: __('members.show.attached.success.msg', ['name' => $getUser->name]),
                        heading: __('members.show.attached.success.head'),
                        variant: 'success',
                    );
                    $this->memberForm->user_id = $this->newUser;
                }
            } else {
                Flux::toast(
                    text: __('members.show.attached.failed.msg'),
                    heading: __('members.show.attached.failed.head'),
                    variant: 'danger',
                );
            }
        }
    }

    public function updateMemberData(): void
    {
        $this->checkPrivilege(Member::class);

        if ($this->memberForm->updateData()) {
            Flux::toast(
                text: __('members.update.success.content'),
                heading: __('members.update.success.title'),
                variant: 'success',
            );
        }
    }

    public function sendInvitation(): void
    {
        try {
            $this->validate([
                'memberForm.email' => 'required|email|unique:invitations,email|unique:users,email',
            ]);

            $invitation = Invitation::create([
                'email' => $this->memberForm->email,
                'token' => Str::random(32),
            ]);

            Mail::to($this->memberForm->email)
                ->locale($this->memberForm->locale)
                ->send(new InvitationMail($invitation, $this->memberForm->member));

            Flux::toast(
                text: __('Einladung verschickt'),
                heading: __('Erfolg'),
                variant: 'success',
            );
        } catch (ValidationException $e) {
            Flux::toast(
                text: __('Wurde nicht verschickt: '.$e->getMessage()),
                heading: __('Fehler'),
                variant: 'danger',
            );
        }
    }

    public function acceptApplication(bool $sendEMail = true): void
    {
        $this->checkPrivilege(Member::class);

        $this->memberForm->type = MemberType::ST->value;
        $this->memberForm->entered_at = now();

        if ($this->memberForm->updateData()) {
            Flux::toast(
                text: __('Mitgliedshaft wurde angenommen'),
                heading: __('Erfolg'),
                variant: 'success',
            );
            if ($sendEMail) {
                Mail::to($this->memberForm->email)
                    ->send(new AcceptMembershipMail($this->member));
            }
            $this->dispatch('membershipAccepted');
        }
    }

    public function cancelMember(): void
    {
        try {
            $this->authorize('delete', Member::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }

        Flux::modal('delete-membership')
            ->show();
    }

    public function deleteMembershipForSure(): void
    {
        $this->authorize('delete', Member::class);
        $msg = '';
        if ($this->memberForm->user_id) {
            if (Auth::user()->id !== $this->memberForm->user_id) {
                $msg = User::find($this->memberForm->user_id)
                    ->delete() ? ' Benutzer gelöscht' : ' Fehler beim Löschen des Benutzers '.$this->memberForm->user_id;
            }
        }

        if ($this->memberForm->cancelMembership()) {
            Flux::toast(
                text: __('Mitgliedshaft wurde gekündigt').$msg,
                heading: __('Erfolg'),
                variant: 'success',
            );
        }
    }

    public function reactivateMembership(): void
    {
        $this->authorize('delete', Member::class);

        if ($this->memberForm->reactivateMembership()) {
            Flux::toast(
                text: __('Mitgliedshaft wurde wiederhergestellt'),
                heading: __('Erfolg'),
                variant: 'success',
            );
        }
    }

    public function download(int $receipt_id): StreamedResponse
    {
        $receipt = Receipt::findOrFail($receipt_id);

        $filePath = "accounting/receipts/{$receipt->file_name}";

        // Debugging: Check if the file exists
        if (! Storage::disk('local')
            ->exists($filePath)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')
            ->download($filePath);
    }

    public function bookItem(int $transaction_id): void
    {
        $this->authorize('book-item', Account::class);
        $this->dispatch('book-transaction', transactionId: $transaction_id);
        $this->transaction = Transaction::find($transaction_id);
        Flux::modal('book-transaction')
            ->show();
    }

    public function editItem(int $transaction_id): void
    {
        $this->authorize('update', Account::class);
        $this->dispatch('edit-transaction', transactionId: $transaction_id);
        $this->transaction = Transaction::find($transaction_id);

        Flux::modal('add-new-payment')
            ->show();
    }

    public function checkBirthDate() {}

    public function render(): \Illuminate\View\View
    {
        return view('livewire.member.show.page');
    }
}
