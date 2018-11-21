<?php

namespace App;

use App\Extensions\GlobalSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Deposit
 *
 * @property int $id
 * @property int $user_id
 * @property int $plan
 * @property int $number_of
 * @property float $profit
 * @property float $withdrawal_amount
 * @property bool $active
 * @property \Carbon\Carbon|null $withdrawal_at
 * @property \Carbon\Carbon|null $calculate_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $final_at
 * @property-read mixed $available_amount_transfer
 * @property-read mixed $max_amount_transfer
 * @property-read mixed $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reward[] $rewards
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit calculate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereCalculateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereFinalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereNumberOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereWithdrawalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereWithdrawalAt($value)
 * @mixin \Eloquent
 * @property int|null $payout_count
 * @property float|null $invest
 * @property bool $old
 * @property-read mixed $payout
 * @property-read mixed $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereInvest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit whereOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Deposit wherePayoutCount($value)
 * @property-read mixed $percent_payout
 */
class Deposit extends Model
{
    const BETWEEN_PAYMENTS = 31;

    const PRODUCTS = [
        1 => [
            'name' => '$10 - $499',
            'min' => 10,
            'max' => 499,
            'payout_count' => 12,
            'percent' => 16,
            'plan' => 1,
        ],
        2 => [
            'name' => '$500 - $1499',
            'min' => 500,
            'max' => 1499,
            'payout_count' => 12,
            'percent' => 17,
            'plan' => 2,
        ],
        3 => [
            'name' => '$1500 - $4999',
            'min' => 1500,
            'max' => 4999,
            'payout_count' => 12,
            'percent' => 18,
            'plan' => 3,
        ],
        4 => [
            'name' => '$5000 - $9999',
            'min' => 5000,
            'max' => 9999,
            'payout_count' => 12,
            'percent' => 19,
            'plan' => 4,
        ],
        5 => [
            'name' => '$10000 - $19999',
            'min' => 10000,
            'max' => 19999,
            'payout_count' => 12,
            'percent' => 20,
            'plan' => 5,
        ],
        6 => [
            'name' => '$19999 - $50000',
            'min' => 19999,
            'max' => 50000,
            'payout_count' => 13,
            'percent' => 20,
            'plan' => 6,
        ],
    ];
    protected $fillable = [];

    protected $dates = [
        'withdrawal_at',
        'created_at',
        'calculate_at',
        'final_at',
    ];

    protected $appends = [
        'product',
    ];

    public $timestamps = false;

    public $incrementing = false;

    public function getNextIdNumber()
    {
        $last = self::select('id', 'created_at')->orderBy('created_at', 'desc')->first();

        if (!$last) {
            $id = 1;
        } else {
            $id = $last->id;
        }

        return intval($id) + random_int(10, 100);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->setCreatedAt($model->freshTimestamp());
            $model->final_at = $model->freshTimestamp()->addDays(self::BETWEEN_PAYMENTS * $model->payout_count);
            $model->calculate_at = $model->freshTimestamp()->addDays(self::BETWEEN_PAYMENTS);
            $model->old = false;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rewards()
    {
        return $this->morphMany(Reward::class, 'from');
    }

    public function getMaxAmountTransferAttribute(): float
    {
        return round($this->payout * config('mlm.deposits_transfers.coefficient'));
    }

    public function getWithdrawalAmountAttribute($value): float
    {
        if ($this->withdrawal_at == null) {
            return 0;
        }

        return $this->withdrawal_at->isToday() ? $value : 0;
    }

    public function getAvailableAmountTransferAttribute(): float
    {
        if ($this->profit == 0) {
            return 0;
        }
        $amount = max($this->max_amount_transfer - $this->withdrawal_amount, 0);

        return round($amount < $this->profit ? $amount : $this->profit, 2);
    }

    public function getProductAttribute()
    {
        if ($this->plan == 0){
            return [
                'name' => '-',
                'min' => 0,
                'max' => 0,
                'payout_count' => 0,
                'percent' => 0,
                'plan' => 0,
            ];
        }

        return self::PRODUCTS[$this->plan];
    }

    public function getPayoutAttribute(): float
    {
        return round(($this->percent_payout / 100) * $this->invest, 2);
    }
    public function getPercentPayoutAttribute()
    {
        $globalSettings = new GlobalSettings();
        return $globalSettings->get('plan_' . $this->plan . '_percent');
    }

    public function getStatusAttribute()
    {
        return trans('unify/personal-office/status.deposit.' . (int)$this->active);
    }

    public function scopeCalculate($query)
    {
        return $query->where('calculate_at', '<=', Carbon::now())->where('active', true)->whereColumn('payout_count', '>=', 'number_of');
    }
}
