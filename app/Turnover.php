<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Turnover.
 *
 * @property int $id
 * @property int $user_id
 * @property int $level
 * @property float $total_left
 * @property float $total_right
 * @property float $total
 * @property float $total_week_left
 * @property float $total_week_right
 * @property float $total_week
 * @property \Carbon\Carbon|null $calculate_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover calculate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereCalculateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotalLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotalRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotalWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotalWeekLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereTotalWeekRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereUserId($value)
 * @mixin \Eloquent
 * @property float $binary_total
 * @property float $direct_total
 * @property float $direct_week
 * @property float $direct_all
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereBinaryTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereDirectAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereDirectTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover whereDirectWeek($value)
 */
class Turnover extends Model
{
    public $timestamps = false;
    //protected $connection = 'pgsql-prod';

    protected $fillable = [
        'user_id',
        'level',
    ];

    protected $dates = ['calculate_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * cleanTotalWeek.
     */
    public function cleanTotalWeek()
    {
        $this->total_week_left = 0;
        $this->total_week_right = 0;
        $this->total_week = 0;
        $this->calculate_at = Carbon::now();
        $this->save();
    }

    public static function getAllByUser(User $user)
    {
        $turnovers = $user->turnovers()->select('level', 'total_left', 'total_right')->oldest('level')->get()->toArray();

        $turnovers = array_combine(array_map(function ($item) {
            return $item['level'];
        }, $turnovers), $turnovers);

        $turnovers = array_replace_recursive([
            1 => [
                'level'       => 1,
                'total_left'  => 0.00,
                'total_right' => 0.00,
                'total'       => 0.00,
            ],
            2 => [
                'level'       => 2,
                'total_left'  => 0.00,
                'total_right' => 0.00,
                'total'       => 0.00,
            ],
            3 => [
                'level'       => 3,
                'total_left'  => 0.00,
                'total_right' => 0.00,
                'total'       => 0.00,
            ],
            4 => [
                'level'       => 4,
                'total_left'  => 0.00,
                'total_right' => 0.00,
                'total'       => 0.00,
            ],
            5 => [
                'level'       => 5,
                'total_left'  => 0.00,
                'total_right' => 0.00,
                'total'       => 0.00,
            ],
        ], $turnovers);

        return $turnovers;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCalculate($query)
    {
        return $query->where('total_week', '>', 0.00);
    }
}
