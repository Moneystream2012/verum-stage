<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Keygen;

/**
 * App\Replenishment.
 *
 * @property int $id
 * @property int $user_id
 * @property string $method
 * @property string $to
 * @property float $cost_amount
 * @property float $amountUSD
 * @property float $amountVMC
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $done_at
 * @property string|null $token
 * @property string|null $payment_url
 * @property int|null $payment_id
 * @property-write mixed $amount_vmc
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereAmountUSD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereAmountVMC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereCostAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereDoneAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment wherePaymentUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereUserId($value)
 * @mixin \Eloquent
 * @property float $amount
 * @property string $currency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Replenishment whereCurrency($value)
 * @property-read mixed $amount_format
 * @property-read mixed $cost_amount_format
 */
class Replenishment extends Model
{
    const UPDATED_AT = null;
    public $incrementing = false;

    protected $dates = [
        'created_at',
        'done_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'method',
        'to',
        'currency',
        'amount',
        'cost_amount',
        'status',
        'done_at',
        'payment_url',
        'payment_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pay()
    {
        if ($this->currency == 'BTC') {
            $this->user->investBalance('btc_'.$this->to, $this->amount);
        } else {
            $this->user->investBalance($this->to, $this->amount);
        }
    }

    public static function generateID(): int
    {
        $last = self::max('id');
        if (! $last) return 1;

        return intval($last) + random_int(10, 18);
    }

    public function getAmountFormatAttribute($value)
    {
        return $this->attributes['currency'] == 'USD' ? formatUSD($this->attributes['amount']) : formatVMC($this->attributes['amount']);
    }

    public function getCostAmountFormatAttribute($value)
    {
        return $this->attributes['currency'] == 'USD' ? formatUSD($this->attributes['cost_amount']) : formatVMC($this->attributes['cost_amount']);
    }
}
