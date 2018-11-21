<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InitialCoinOffering
 *
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $method
 * @property string $ico_type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereIcoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InitialCoinOffering whereUserId($value)
 * @mixin \Eloquent
 */
class InitialCoinOffering extends Model
{
    protected $fillable = [
        'ico_type',
        'method',
        'amount',
    ];
}
