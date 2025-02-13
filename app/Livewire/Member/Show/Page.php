<?php

namespace App\Livewire\Member\Show;

use App\Enums\MemberType;
use App\Livewire\Forms\MemberForm;
use App\Mail\AcceptMembershipMail;
use App\Mail\InvitationMail;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Invitation;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use App\Models\User;
use App\Notifications\MemberAcceptedNotification;
use App\Notifications\NewMemberApplied;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Page extends Component
{

    use WithPagination;

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


    public $sortBy = 'date';
    public $sortDirection = 'desc';

    protected $listeners = ['updated-payments' => 'payments'];

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function payments(): LengthAwarePaginator
    {
        return MemberTransaction::query()
            ->where('member_id', '=', $this->member->id)
            ->tap(fn($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->tap(fn($query) => $this->searchPayment ? $query->whereHas('transaction', function ($query)
            {
                $query->where('label', 'LIKE', '%'.$this->searchPayment.'%')
                    ->orWhere('reference', 'LIKE', '%'.$this->searchPayment.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->searchPayment.'%');
            }) : $query)
            ->paginate(10);
    }

    public function mount(Member $member): void
    {
        $this->memberForm->set($member);
        $this->users = User::select('id', 'name')
            ->get();

        $this->feeStatusResults = $member->feeStatus();

        $this->feeStatus = $this->feeStatusResults['status'];
        $this->openFees = number_format($this->feeStatusResults['paid'] / 100, 2, ',', '.');
    }

    public function detachUser(int $userid): void
    {
        if ($this->memberForm->user_id === $userid) {
            $this->memberForm->user_id = null;
            if ($this->member->save()) {
                $this->hasUser = false;
                Flux::toast(
                    heading: __('members.show.detached.success.head'),
                    text: __('members.show.detached.success.msg', ['name' => $this->member->name]),
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
                        heading: __('members.show.attached.success.head'),
                        text: __('members.show.attached.success.msg', ['name' => $getUser->name]),
                        variant: 'success',
                    );
                    $this->memberForm->user_id = $this->newUser;
                }
            } else {
                Flux::toast(
                    heading: __('members.show.attached.failed.head'),
                    text: __('members.show.attached.failed.msg'),
                    variant: 'danger',
                );
            }
        }
    }

    public function updateMemberData(): void
    {
        $this->checkUser();

        if ($this->memberForm->updateData()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateContactData(): void
    {
        $this->checkUser();

        if ($this->memberForm->updateContact()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
                variant: 'success',
            );
        }
    }

    public function updateMembershipData(): void
    {
        $this->checkUser();

        $this->member->type = $this->member_type;
        $this->member->is_deducted = $this->is_deducted;
        $this->member->deduction_reason = $this->deduction_reason;


        if ($this->member->save()) {
            Flux::toast(
                heading: __('members.update.success.title'),
                text: __('members.update.success.content'),
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
                ->send(new InvitationMail($invitation, $this->memberForm->member));

            Flux::toast(
                heading: __('Erfolg'),
                text: __('Einladung verschickt'),
                variant: 'success',
            );
        } catch (ValidationException $e) {
            Flux::toast(
                heading: __('Fehler'),
                text: __('Wurde nicht verschickt: '.$e->getMessage()),
                variant: 'danger',
            );
        }
    }

    public function acceptApplication(): void
    {
        $this->checkUser();

        $this->memberForm->type = MemberType::ST->value;
        $this->memberForm->entered_at = now();

        if ($this->memberForm->updateMembership()) {
            Flux::toast(
                heading: __('Erfolg'),
                text: __('Mitgliedshaft wurde angenommen'),
                variant: 'success',
            );
            Mail::to($this->memberForm->email)
                ->send(new AcceptMembershipMail($this->member));
        }
    }

    public function cancelMember()
    {
        try {
            $this->authorize('delete', Member::class);
        } catch (AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }

        Flux::modal('delete-membership')
            ->show();
    }

    protected function checkUser(): void
    {
        try {
            $this->authorize('update', $this->member);
        } catch (AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this member! '.$e->getMessage(),
                variant: 'danger',
            );
            return;
        }
    }

    public function deleteMembershipForSure()
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
                heading: __('Erfolg'),
                text: __('Mitgliedshaft wurde gekündigt').$msg,
                variant: 'success',
            );
        }
    }

    public function reactivateMembership(): void
    {
        $this->authorize('delete', Member::class);

        if ($this->memberForm->reactivateMembership()) {
            Flux::toast(
                heading: __('Erfolg'),
                text: __('Mitgliedshaft wurde wiederhergestellt'),
                variant: 'success',
            );
        }
    }

    public function download(int $receipt_id): StreamedResponse
    {
        $receipt = Receipt::findOrFail($receipt_id);

        $filePath = "accounting/receipts/{$receipt->file_name}";

        // Debugging: Check if the file exists
        if (!Storage::disk('local')
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

    public function render()
    {
        return view('livewire.member.show.page');
    }
}
