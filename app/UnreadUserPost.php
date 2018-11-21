<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UnreadUserPost
 *
 * @property int $user_id
 * @property int $unread
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UnreadUserPost whereUnread($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UnreadUserPost whereUserId($value)
 * @mixin \Eloquent
 */
class UnreadUserPost extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'unread',
    ];
}
