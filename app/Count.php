<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Count.
 *
 * @property int $id
 * @property string $type
 * @property int $count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Count whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Count whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Count whereType($value)
 * @mixin \Eloquent
 */
class Count extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'count',
    ];

    /**
     * @param string $type
     */
    public static function typeGetCount($type = 'shares')
    {
        return static::where('type', $type)->value('count');
    }

    /**
     * @param string $type
     * @param int    $count
     */
    public static function typeSetCount($type = 'shares', $count = 0)
    {
        static::getType($type)->update(['count' => $count]);
    }

    /**
     * @param string $type
     * @param int    $count
     */
    public static function typeIncrement($type = 'shares', $count = 0)
    {
        static::getType($type)->increment('count', $count);
    }

    /**
     * @param string $type
     * @param int    $count
     */
    public static function typeDecrement($type = 'shares', $count = 0)
    {
        static::getType($type)->decrement('count', $count);
    }

    public static function getType($type)
    {
        return self::firstOrCreate(['type' => $type]);
    }
}
