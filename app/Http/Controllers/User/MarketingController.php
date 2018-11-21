<?php

namespace App\Http\Controllers\User;

use App\Deposit;
use App\Http\Controllers\Controller;

class MarketingController extends Controller
{
    public function index()
    {
        $products = [
            1 => [
                'name'             => '100 USD',
                'price'            => 100,
                'payout_count'     => 11,
                'percent'          => 15,
                'payout'           => 65,
                'between_payments' => 31,
                'plan'             => 1,
                'mlm_direct_bonus' => 0.05,
                'mlm_binary_bonus' => 0.05,
            ],
            2 => [
                'name'             => '500 USD',
                'price'            => 500,
                'payout_count'     => 11,
                'percent'          => 16,
                'payout'           => 380,
                'between_payments' => 31,
                'plan'             => 2,
                'mlm_direct_bonus' => 0.05,
                'mlm_binary_bonus' => 0.05,
            ],
            3 => [
                'name'             => '1 000 USD',
                'price'            => 1000,
                'payout_count'     => 11,
                'percent'          => 17,
                'payout'           => 870,
                'between_payments' => 31,
                'plan'             => 3,
                'mlm_direct_bonus' => 0.05,
                'mlm_binary_bonus' => 0.05,
            ],
            4 => [
                'name'             => '3 000 USD',
                'price'            => 3000,
                'payout_count'     => 12,
                'percent'          => 18,
                'payout'           => 3480,
                'between_payments' => 31,
                'plan'             => 4,
                'mlm_direct_bonus' => 0.05,
                'mlm_binary_bonus' => 0.05,
            ],
            5 => [
                'name'             => '5 000 USD',
                'price'            => 5000,
                'payout_count'     => 12,
                'percent'          => 19,
                'payout'           => 6400,
                'between_payments' => 31,
                'plan'             => 5,
                'mlm_direct_bonus' => 0.06,
                'mlm_binary_bonus' => 0.06,
            ],
            6 => [
                'name'             => '10 000 USD',
                'price'            => 10000,
                'payout_count'     => 12,
                'percent'          => 20,
                'payout'           => 14000,
                'between_payments' => 31,
                'plan'             => 6,
                'mlm_direct_bonus' => 0.06,
                'mlm_binary_bonus' => 0.06,
            ],
            7 => [
                'name'             => '20 000 USD',
                'price'            => 20000,
                'payout_count'     => 13,
                'percent'          => 21,
                'payout'           => 34600,
                'between_payments' => 31,
                'plan'             => 7,
                'mlm_direct_bonus' => 0.07,
                'mlm_binary_bonus' => 0.07,
            ],
            8 => [
                'name'             => '50 000 USD',
                'price'            => 50000,
                'payout_count'     => 13,
                'percent'          => 22,
                'payout'           => 93000,
                'between_payments' => 31,
                'plan'             => 8,
                'mlm_direct_bonus' => 0.08,
                'mlm_binary_bonus' => 0.08,
            ],
        ];

        return view('personal-office.marketing', ['products' => $products]);
    }
}
