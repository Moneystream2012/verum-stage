<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Turnover2
 *
 * @property-read \App\User $user
 * @mixin \Eloquent
 * @property int $user_id
 * @property float $direct_total
 * @property float $direct_week
 * @property float $direct_all
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereBinaryTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereDirectAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereDirectTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereDirectWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereUserId($value)
 * @property \Carbon\Carbon|null $calculate_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Turnover2 whereCalculateAt($value)
 */
class Turnover2 extends Model
{
    public $timestamps = false;

    public $primaryKey = 'user_id';

    protected $casts = [
        'direct_total' => 'double',
        'direct_week'  => 'double',
        'direct_all'   => 'double',
    ];

    protected $dates = ['calculate_at'];

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'direct_all',
        'direct_week',
        'direct_total',
        'calculate_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
