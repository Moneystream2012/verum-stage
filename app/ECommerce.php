<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ECommerce
 *
 * @property int $id
 * @property int $replenishment_id
 * @property string $txid
 * @property string $category
 * @property string $address
 * @property float $amountUSD
 * @property float $amountVMC
 * @property bool $paid
 * @property int $confirmations
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Replenishment $replenishment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereAmountUSD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereAmountVMC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereReplenishmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereTxid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ECommerce whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ECommerce extends Model
{
    protected $table = 'ecommerces';

    protected $fillable = [
        'replenishment_id',
        'txid',
        'category',
        'address',
        'amountUSD',
        'amountVMC',
    ];

    public function replenishment()
    {
        return $this->hasOne(Replenishment::class, 'id', 'replenishment_id');
    }
}
