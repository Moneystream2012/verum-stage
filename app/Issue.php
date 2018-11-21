<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Amelia\Rememberable\Rememberable;

/**
 * App\Issue.
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property int $support_id
 * @property string $support_type
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IssueDialog[] $dialogs
 * @property-read mixed $is_baned_send
 * @property-read mixed $status_text
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $support
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereSupportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereSupportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereUserId($value)
 * @mixin \Eloquent
 * @property int $read
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Issue whereRead($value)
 */
class Issue extends Model
{
    use Rememberable;
    public $fillable = [
        'title',
        'support_type',
        'support_id',
        'user_id',
        'status',
        'read'
    ];

    public function support()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        $status = $this->attributes['status'];

        return trans('personal-office/issues/status.'.$status);
    }

    public function getIsBanedSendAttribute()
    {
        $status = $this->attributes['status'];

        return $status == '0' || $status == 2;
    }

    public function dialogs()
    {
        return $this->hasMany(IssueDialog::class);
    }
}
