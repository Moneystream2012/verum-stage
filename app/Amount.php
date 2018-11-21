<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Amount.
 *
 * @property int $id
 * @property string $type
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Amount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Amount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Amount whereType($value)
 * @mixin \Eloquent
 */
class Amount extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'amount',
    ];

    /**
     * @param string $type
     *
     * @return float
     */
    public static function typeGetAmount($type = 'charities'):float
    {
        return static::where('type', $type)->value('amount') ?? 0;
    }

    public static function typeSetAmount($type = 'charities', $amount = 0.00)
    {
        return static::getType($type)->update(['amount' => $amount]);
    }

    public static function typeIncrement($type = 'charities', $amount = 0.00)
    {
        return static::getType($type)->increment('amount', $amount);
    }

    public static function typeDecrement($type = 'charities', $amount = 0.00)
    {
        return static::getType($type)->decrement('amount', $amount);
    }

    public static function getType($type)
    {
        return self::firstOrCreate(['type' => $type]);
    }
}
