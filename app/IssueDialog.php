<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\IssueDialog
 *
 * @property int $id
 * @property int $issue_id
 * @property bool $is_support
 * @property bool $read
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereIsSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereIssueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IssueDialog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IssueDialog extends Model
{
    public $fillable = [
        'body',
        'is_support',
    ];

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = str_replace("\n", '<br />', strip_tags(trim($value, '\t\r\0\x0B')));
    }
}
