<?php

namespace App\Traits;

use App\Count;

trait CountsTrait
{
    public static function getCount()
    {
        return Count::typeGetCount(self::TABLE_COUNT);
    }

    public static function setCount($count)
    {
        return Count::typeSetCount(self::TABLE_COUNT, $count);
    }

    public static function incrementCount($count = 0)
    {
        Count::typeIncrement(self::TABLE_COUNT, $count);
    }

    public static function decrementCount($count = 0)
    {
        Count::typeDecrement(self::TABLE_COUNT, $count);
    }
}
