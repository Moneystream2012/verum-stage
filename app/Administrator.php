<?php

namespace App;

use App\Notifications\Administrator\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Administrator.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Issue[] $issues
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Administrator whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Administrator extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function issues()
    {
        return $this->hasMany(Issue::class, 'support_id', 'id');
    }
}
