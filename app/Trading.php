<?php

namespace App;

use App\Extensions\GlobalSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Trading
 *
 * @property int $id
 * @property int $user_id
 * @property float $invest
 * @property float $profit
 * @property int $number_of
 * @property \Carbon\Carbon $calculate_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $final_at
 * @property string $status
 * @property-read mixed $number_of_payout
 * @property-read mixed $payout
 * @property-read mixed $payout_count
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading calculate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereCalculateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereFinalAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereInvest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereNumberOf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Trading whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reward[] $rewards
 * @property-read \App\User $user
 */
class Trading extends Model
{
    const ACTIVE = 1;
    const FINAL = 2;
    const REFUND = 3;
    const BETWEEN_PAYMENTS = 1;
    const PAYOUT_COUNT = 365;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'invest',
        'profit',
        'number_of',
        'calculate_at',
        'final_at',
        'status',
    ];

    protected $dates = [
        'calculate_at',
        'created_at',
        'final_at',
    ];

    protected $appends = [
        'number_of_payout',
        'status_text',
        'payout'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rewards()
    {
        return $this->morphMany(Reward::class, 'from');
    }

    public static function getPercentPayout():float
    {
        $globalSettings = new GlobalSettings();
        return $globalSettings->get('trading_percent') ?? 0.5;
    }

    public static function setPercentPayout(float $percent)
    {
        $globalSettings = new GlobalSettings();
        return $globalSettings->set('trading_percent', $percent);
    }

    public function getPayoutAttribute(): float
    {
        return round((self::getPercentPayout() / 100) * $this->invest, 2);
    }

    public function getPayoutCountAttribute(): float
    {
        return self::PAYOUT_COUNT;
    }

    public function getNumberOfPayoutAttribute()
    {
        return $this->number_of .' / '. $this->payout_count;
    }

    public function getStatusTextAttribute()
    {
        return trans('unify/personal-office/status.trading.' .$this->status);
    }

    public function scopeCalculate($query)
    {
        return $query->where('calculate_at', '<=', Carbon::now())->where('status', self::ACTIVE)->where('number_of', '<=',self::PAYOUT_COUNT);
    }

}
