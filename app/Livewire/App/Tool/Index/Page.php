<?php

namespace App\Livewire\App\Tool\Index;

use App\Jobs\DeleteEmailAttachments;
use App\Livewire\Traits\HasPrivileges;
use App\Livewire\Traits\Sortable;
use App\Mail\SendMemberMassMail;
use App\Models\MailHistoryEntry;
use App\Models\MailingList;
use App\Models\Membership\Member;
use Exception;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Page extends Component
{
    use HasPrivileges, WithFileUploads, Sortable, WithPagination;

    public array $subject;

    public array $message;

    public array $attachments;

    public bool $include_mailing_list;

    public bool $target_type;

    public array $url_label;

    public string $url;

    #[Computed]
    public function mailingList(): LengthAwarePaginator
    {
        return MailingList::query()
            ->whereNotNull('verified_at')
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function sendMembersMail(): void
    {
        $this->checkPrivilege(MailingList::class);
        $this->validate();

        MailHistoryEntry::create([
            'user_id' => Auth::user()->id,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $savedFiles = [];
        foreach ($this->attachments as $locale => $file) {
            if ($file instanceof TemporaryUploadedFile) {
                $originalFileName = $file->getClientOriginalName();
                $path = $file->store('mail_attachments'); // Save file
                $fullPath = storage_path("app/private/{$path}"); // Get absolute path
                $savedFiles[$locale] = [
                    'local' => $fullPath,
                    'original' => $originalFileName,
                ]; // Store full path

            } else {
                Log::error('Invalid file detected:', ['file' => $file]);
            }
        }



        if (empty($savedFiles)) {
            Log::error('No valid attachments were saved!');
        }

        $counter = 0;
        foreach (Member::all() as $member) {
            if ($member->email) {

                Log::info('Sending email with attachments: '.json_encode([$savedFiles[$member->locale]]));
                Mail::to($member->email)
                    ->queue(new SendMemberMassMail(
                        $member->fullName(),
                        $this->subject[$member->locale],
                        $this->message[$member->locale],
                        $member->locale,
                        $this->url,
                        $this->url_label[$member->locale],
                        [$savedFiles[$member->locale]]
                    ));
                $counter++;
            }
        }

        if ($this->include_mailing_list){




        }

        Flux::toast('Die E-Mail wurde an '.$counter.' verschickt!', 'Erfolg', 6000, 'success');

        DeleteEmailAttachments::dispatch($savedFiles)->delay(now()->addMinutes(5));
    }

    public function sendTestMailToSelf(): void
    {
        $this->checkPrivilege(MailingList::class);
        $user = Auth::user();

        //        if (!is_string($this->subject[$user->locale])) {
        //            throw new \Exception('Subject must be a string, but '.gettype($this->subject[$user->locale]).' given.');
        //        }

        try {
            Mail::to($user->email)
                ->queue(new SendMemberMassMail(
                    (string) $user->name,
                    (string) $this->subject[$user->locale], // Ensure it's a string
                    (string) $this->message[$user->locale], // Ensure it's a string
                    $user->locale,
                    $this->url,
                    (string) $this->url_label[$user->locale], // Ensure it's a string
                    null
                ));
            Flux::toast('Testmail sent');
        } catch (Exception $exception) {
            Flux::toast('Testmail not sent '.$exception->getMessage());
        }
    }

    protected function rules(): array
    {
        return [
            'attachments.*' => 'file|max:20480',  // 20MB max
            'subject.hu' => 'required',
            'subject.de' => 'required',
            'message.hu' => 'required',
            'message.de' => 'required',
            'url' => 'nullable',
            'url_label.de' => 'nullable',
            'url_label.hu' => 'nullable',
        ];
    }

    public function addDummyData():void
    {
        $this->subject['hu'] = fake()->realText(50);
        $this->subject['de'] = fake()->realText(50);
        $this->message['hu'] = fake()->realTextBetween(20);
        $this->message['de'] = fake()->realTextBetween(20);
        $this->url = 'magyar-kolonia-berlin-org';
        $this->url_label['hu'] = 'Kattincs ide';
        $this->url_label['de'] = 'Click hier';
    }


    public function render()
    {
        return view('livewire.app.tool.index.page');
    }
}
