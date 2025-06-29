<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\History;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RecordHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $historableId;

    protected $historableType;

    protected $action;

    protected $changes;

    protected $userId;

    public function __construct($historable, $action, $changes = null, $userId = null)
    {
        $this->historableId = $historable->id;
        $this->historableType = get_class($historable);
        $this->action = $action;
        $this->changes = $changes;
        $this->userId = $userId;
    }

    public function handle(): void
    {

        $data = [
            'historable_id' => $this->historableId,
            'historable_type' => $this->historableType,
            'user_id' => $this->userId,
            'action' => $this->action,
            'changes' => $this->changes ? json_encode($this->changes) : null,
            'changed_at' => now(),
        ];

        //        Log::debug('job started', ['data' => $data]);

        try {
            History::create($data);
        } catch (\Exception $e) {
            \Log::error('History insert failed: '.$e->getMessage(), $data);
            throw $e;
        }
    }
}
