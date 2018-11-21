<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transfer.
 *
 * @property int $id
 * @property int $user_id
 * @property int $to_id
 * @property string $from_username
 * @property string $to_username
 * @property float $amount
 * @property float $cost_amount
 * @property \Carbon\Carbon|null $created_at
 * @property string $method
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereCostAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereFromUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereToUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transfer whereUserId($value)
 * @mixin \Eloquent
 */
class Transfer extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'from_username',
        'to_id',
        'to_username',
        'amount',
        'cost_amount',
        'method',
    ];
}
