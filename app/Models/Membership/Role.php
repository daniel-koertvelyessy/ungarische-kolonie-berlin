<?php

namespace App\Models\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Membership\MemberRole|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership\Member> $members
 * @property-read int|null $members_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership\Member> $currentMembers
 * @property-read int|null $current_members_count
 * @property int $sort
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereSort($value)
 *
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'sort'];

    protected $casts = [
        'sort' => 'integer',
    ];

    /**
     * The members that belong to the role.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_role') // Matches convention
            ->withPivot('designated_at', 'resigned_at', 'about_me', 'profile_image')
            ->withTimestamps()
            ->using(MemberRole::class)
            ->orderBy('sort', 'asc');
    }

    /**
     * The current members that belong to the role.
     */
    public function currentMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('resigned_at', null);
    }
}
