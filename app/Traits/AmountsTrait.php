<?php

namespace App\Traits;

use App\Amount;

trait AmountsTrait
{
    /**
     * @return float
     */
    public static function getAmount():float
    {
        return Amount::typeGetAmount(self::TABLE_AMOUNT);
    }

    /**
     * @param float $amount
     */
    public static function setAmount($amount = 0.00)
    {
        Amount::typeSetAmount(self::TABLE_AMOUNT, $amount);
    }

    /**
     * @param float $amount
     */
    public static function incrementAmount($amount = 0.00)
    {
        Amount::typeIncrement(self::TABLE_AMOUNT, $amount);
    }

    /**
     * @param float $amount
     */
    public static function decrementAmount($amount = 0.00)
    {
        Amount::typeDecrement(self::TABLE_AMOUNT, $amount);
    }
}
