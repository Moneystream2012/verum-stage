<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Withdraw
 *
 * @property int $id
 * @property int $user_id
 * @property string $from_method
 * @property string $to_method
 * @property float $amount
 * @property float $cost_amount
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $done_at
 * @property string $wallet_address
 * @property string|null $tx
 * @property-read mixed $link_tx
 * @property-read mixed $status_text
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereCostAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereDoneAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereFromMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereToMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereTx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Withdraw whereWalletAddress($value)
 * @mixin \Eloquent
 */
class Withdraw extends Model
{
    const STATUS_PROCESSING = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_REJECTION = 2;
    const UPDATED_AT = null;

    protected $dates = [
        'created_at',
        'done_at',
    ];

    protected $fillable = [
        'user_id',
        'from_method',
        'to_method',
        'amount',
        'cost_amount',
        'status',
        'done_at',
        'wallet_address',
        'tx',
    ];

    protected $casts = [
        'amount' => 'double',
        'cost_amount' => 'double'
    ];

    protected $appends = [
        'status_text',
        'link_tx',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        return trans('unify/personal-office/status.withdraw.'.$this->status);
    }

    public function getLinkTxAttribute()
    {
        if ($this->to_method == 'BTC') {
            return 'https://blockchain.info/tx/'.$this->tx;
        }

        if ($this->to_method == 'VMC') {
            return 'https://vmcblockchain.info/tx/'.$this->tx;
        }
    }
}
