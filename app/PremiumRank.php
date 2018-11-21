<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PremiumRank
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $rank
 * @property bool $paid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PremiumRank whereUserId($value)
 * @mixin \Eloquent
 */
class PremiumRank extends Model
{
    protected $fillable = [
        'amount',
        'rank',
        'paid',
    ];

    protected $casts = [
        'amount' => 'double',
    ];
}
