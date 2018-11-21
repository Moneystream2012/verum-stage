<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exchange.
 *
 * @property int $id
 * @property int $user_id
 * @property string $from_method
 * @property string $to_method
 * @property float $amount
 * @property \Carbon\Carbon|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereFromMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereToMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereUserId($value)
 * @mixin \Eloquent
 */
class Exchange extends Model
{
    const STATUS_PROCESSING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_REJECTION = 2;
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'from_method',
        'to_method',
        'amount',
        'cost_amount',
    ];
}
