<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Jobs\RecordHistory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 *  track changes in important models
 */
trait HasHistory
{
    public static function bootHasHistory(): void
    {

        static::created(function ($model): void {
            $model->recordHistory('created');
        });

        static::updating(function ($model): void {
            $model->recordHistory('updated');
        });

        static::deleting(function ($model): void {
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

        //        $this->histories()->create([
        //            'user_id' => Auth::id(),
        //            'action' => $action,
        //            'changes' => $changes ? json_encode($changes) : null,
        //            'changed_at' => now(),
        //        ]);
        //

        RecordHistory::dispatch($this, $action, $changes, Auth::id());
    }
}
