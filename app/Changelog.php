<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Changelog
 *
 * @property int $id
 * @property string $status
 * @property array $main_text
 * @property string|null $footer_text
 * @property bool $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereFooterText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereMainText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Changelog extends Model
{

    protected $table = 'changelogs';
    protected $fillable = [
        'status',
        'main_text',
        'footer_text',
        'active',
    ];

    protected $casts = [
        'main_text' => 'array',
        'active'    => 'boolean',
    ];
}
