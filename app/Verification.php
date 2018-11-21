<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * App\Verification
 *
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property string $email
 * @property string $country
 * @property string|null $doc_img
 * @property string|null $avatar
 * @property bool $status
 * @property \Carbon\Carbon|null $verification_at
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereDocImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Verification whereVerificationAt($value)
 * @mixin \Eloquent
 * @property-read mixed $avatar_url
 * @property-read mixed $doc_img_url
 * @property-read mixed $input_disable
 * @property-read mixed $country_name
 * @property-read mixed $mobile_number_format
 * @property-read mixed $status_processing
 * @property-read \App\User $user
 */
class Verification extends Model
{
    const NOT_VERIFIED = 0;
    const PROCESSING = 1;
    const VERIFIED = 2;
    const CREATED_AT = 'verification_at';
    const UPDATED_AT = 'verification_at';
    public $incrementing = false;
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'country',
        'doc_img',
        'avatar',
        'status'
    ];

    protected $dates = [
        'verification_at',
    ];

    protected $casts = [
        'status_processing' => 'boolean'
    ];

    protected $appends = [
        'status_text',
        'status_processing',
        'country_name',
        'avatar_url',
        'doc_img_url',
        'mobile_number_format'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFirstNameAttribute()
    {
        return $this->attributes['first_name'] ?? user()->first_name;
    }

    public function getLastNameAttribute()
    {
        return $this->attributes['last_name'] ?? user()->last_name;
    }

    public function getMobileNumberAttribute()
    {
        return $this->attributes['mobile_number'] ?? user()->mobile_number;
    }

    public function getCountryAttribute()
    {
        return $this->attributes['country'] ?? user()->country;
    }

    public function getCountryNameAttribute()
    {
        return \Countries::getOne($this->country, \App::getLocale());
    }

    public function getMobileNumberFormatAttribute()
    {
        try {
            return phone($this->mobile_number, $this->country);
        } catch (\Exception $exception) {
            return $this->mobile_number;
        }
    }

    public function getEmailAttribute()
    {
        return $this->attributes['email'] ?? user()->email;
    }

    public function getStatusTextAttribute()
    {
        return trans('unify/personal-office/status.verification.' . ($this->attributes['status'] ?? self::NOT_VERIFIED));
    }

    public function getStatusProcessingAttribute()
    {
        return ($this->attributes['status'] ?? self::NOT_VERIFIED) == self::PROCESSING;
    }

    public function getAvatarUrlAttribute()
    {
        return Storage::disk('verifications')->url($this->attributes['avatar']);
    }

    public function getDocImgUrlAttribute()
    {
        return Storage::disk('verifications')->url($this->attributes['doc_img']);
    }
}
