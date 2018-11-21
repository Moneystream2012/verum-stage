<?php

namespace App;

use Amelia\Rememberable\Rememberable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Compute.
 *
 * @property int $id
 * @property int $user_id
 * @property string $from
 * @property string $to
 * @property float $point_left
 * @property float $point_right
 * @property float $reward
 * @property float $amount
 * @property int $plan
 * @property int $status
 * @property int $number_of
 * @property \Carbon\Carbon|null $computed_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereComputedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereNumberOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute wherePointLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute wherePointRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 * @property int $rank
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Compute matching()
 */
class Compute extends Model
{
    use Rememberable;

    const STATUS_PROCESSING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_REJECTION = 2;

    protected $fillable = [
        'user_id',
        'from',
        'to',
        'amount',
        'plan',
        'rank',
        'reward',
        'status',
        'point_left',
        'point_right',
        'number_of',
        'computed_at',
    ];

    protected $dates = [
        'computed_at',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->computed_at = $model->freshTimestamp();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMatching($query)
    {
        return $query->where('from', 'matching');
    }

}
