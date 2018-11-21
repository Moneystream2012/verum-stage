<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\History.
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property int $category
 * @property array $data
 * @property \Carbon\Carbon|null $created_at
 * @property-read mixed $body
 * @property-read mixed $icon
 * @property-read mixed $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\History whereUserId($value)
 * @mixin \Eloquent
 */
class History extends Model
{
    public $timestamps = false;

    protected $dates = [
        'created_at',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'category',
        'data',
        'created_at',
    ];

    protected $appends = [
        'title',
        'body',
        'icon',
    ];

    public $categories = [
        'payments'  => 1,
        'transfers' => 2,
        'profits'   => 3,
        'requests'  => 4,
    ];

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = $this->categories[$value];
    }

    public function getCategoryAttribute($value)
    {
        return array_flip($this->categories)[$value];
    }

    public function setDataAttribute(array $value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getTitleAttribute()
    {
        return trans('histories.'.$this->category.'.'.$this->type.'.title');
    }

    public function getBodyAttribute()
    {
        return trans('histories.'.$this->category.'.'.$this->type.'.body', $this->data);
    }

    public function getIconAttribute()
    {
        return trans('histories.'.$this->category.'.'.$this->type.'.icon');
    }
}
