<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reward.
 *
 * @property int $id
 * @property int $user_id
 * @property int $from_id
 * @property string $from_type
 * @property string $to
 * @property float $amount
 * @property array $data
 * @property \Carbon\Carbon|null $reward_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $rewardtable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereFromType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereRewardAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reward whereUserId($value)
 * @mixin \Eloquent
 */
class Reward extends Model
{
    protected $fillable = [
        'user_id',
        'from_id',
        'from_type',
        'to',
        'amount',
        'data',
        'reward_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dates = [
        'reward_at',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->reward_at = $model->freshTimestamp();
        });
    }

    public function rewardtable()
    {
        return $this->morphTo();
    }
}
