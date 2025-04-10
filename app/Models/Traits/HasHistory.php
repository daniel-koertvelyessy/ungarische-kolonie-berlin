<?php

namespace App\Models\Traits;

use App\Jobs\RecordHistory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 *  track changes in important models
 */
trait HasHistory
{
    public static function bootHasHistory(): void
    {

        static::created(function ($model) {
            $model->recordHistory('created');
        });

        static::updating(function ($model) {
            $model->recordHistory('updated');
        });

        static::deleting(function ($model) {
            //            Log::debug('make static deleted', ['model' => $model]);
            $model->recordHistory('deleted');
        });

    }

    public function histories(): MorphMany
    {
        return $this->morphMany(\App\Models\History::class, 'historable');
    }

    protected function recordHistory($action): void
    {

        $changes = $action === 'updated' ? [
            'old' => array_intersect_key($this->getOriginal(), $this->getDirty()),
            'new' => $this->getDirty(),
        ] : null;

        //        Log::debug('record history', ['payload' => [
        //            'user_id' => Auth::id(),
        //            'action' => $action,
        //            'changes' => $changes ? json_encode($changes) : null,
        //            'changed_at' => now(),
        //        ]]);

        //        $this->histories()->create([
        //            'user_id' => Auth::id(),
        //            'action' => $action,
        //            'changes' => $changes ? json_encode($changes) : null,
        //            'changed_at' => now(),
        //        ]);
        //
        //        Log::debug('issue job', ['changes' => $changes]);

        RecordHistory::dispatch($this, $action, $changes, Auth::id());
    }
}
