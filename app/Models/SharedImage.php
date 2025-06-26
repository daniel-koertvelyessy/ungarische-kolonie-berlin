<?php

// app/Models/SharedImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $guest_token
 * @property string $filename
 * @property string $original_filename
 * @property string|null $caption
 * @property string $author
 * @property string|null $alt_text
 * @property int|null $file_size
 * @property string|null $mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Membership\Invitation|null $invitation
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\SharedImageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereAltText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereGuestToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereOriginalFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SharedImage whereUserId($value)
 *
 * @mixin \Eloquent
 */
class SharedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'user_id',
        'invitation_id',
        'path',
        'thumbnail_path',
        'is_approved',
        'approved_by',
        'approved_at',
        'file_size',
        'dimensions',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
        'dimensions' => 'array',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function invitation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Membership\Invitation::class);
    }

    public function approver(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function getAuthorAttribute(): string
    {
        return $this->user->name ?? $this->invitation?->email;
    }

    public function imageUrl(): string
    {
        return Storage::disk('local')->url($this->path);
    }

    public function thumbnailUrl(): ?string
    {
        return $this->thumbnail_path
            ? Storage::disk('local')->url($this->thumbnail_path)
            : null;
    }
}
