<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function index($category = 0, $date = null)
    {
        $histories = auth()->user()->histories()->latest();
        if ($category) {
            $histories->where('category', $category);
        }
        if ($date) {
            $dates = null;
            switch ($date) {
                case 'yesterday':
                    $dates = [
                        Carbon::yesterday()->startOfDay()->toDateTimeString(),
                        Carbon::yesterday()->endOfDay()->toDateTimeString(),
                    ];
                    break;
                case 'today':
                    $dates = [
                        Carbon::today()->startOfDay()->toDateTimeString(),
                        Carbon::today()->endOfDay()->toDateTimeString(),
                    ];
                    break;
                case 'week':
                    $dates = [
                        Carbon::now()->startOfWeek()->toDateTimeString(),
                        Carbon::now()->endOfWeek()->toDateTimeString(),
                    ];
                    break;
                case 'month':
                    $dates = [
                        Carbon::now()->startOfMonth()->toDateTimeString(),
                        Carbon::now()->endOfMonth()->toDateTimeString(),
                    ];
                    break;
            }
            if ($dates) {
                $histories = $histories->whereBetween('created_at', $dates);
            }
        }

        $data = $histories->orderBy('id', 'desc')->paginate(4);

        return view('unify.personal-office.history')->with([
            'data'     => $data,
            'category' => $category,
            'date'     => $date,
        ]);
    }
}
