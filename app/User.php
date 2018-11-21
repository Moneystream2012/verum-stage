<?php

namespace App;

use App\Notifications\Users\ResetPassword as ResetPasswordNotification;
use App\Traits\UserSettingsTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Keygen\Keygen;

/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property int $plan
 * @property string|null $address
 * @property float $balance
 * @property int $sponsor_id
 * @property bool $leg
 * @property bool $side_leg
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_number
 * @property string $country
 * @property string|null $avatar
 * @property string $password
 * @property string|null $transaction_password
 * @property bool $verified_email
 * @property string|null $token_email
 * @property array $settings
 * @property \Carbon\Carbon|null $last_login_at
 * @property bool $active
 * @property \Carbon\Carbon|null $active_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $remember_token
 * @property float $mining_balance
 * @property float $binary_total
 * @property string|null $rank
 * @property float $btc_balance
 * @property float $btc_mining_balance
 * @property float $vmc_balance
 * @property bool $old
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Compute[] $computes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Deposit[] $deposits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exchange[] $exchanges
 * @property-read mixed $active_year
 * @property-read mixed $all_bonus
 * @property-read mixed $avatar_url
 * @property-read mixed $binary_bonus
 * @property-read mixed $binary_lower_branch
 * @property-read mixed $binary_points
 * @property-read mixed $binary_week
 * @property-read mixed $blocked
 * @property-read mixed $country_name
 * @property-read mixed $direct_bonus
 * @property-read mixed $full_name
 * @property-read mixed $matching_bonus
 * @property-read mixed $mobile_number_format
 * @property-read mixed $premium_rank_bonus
 * @property-read mixed $product
 * @property-read mixed $rank_text
 * @property-read mixed $sponsor_username
 * @property-read mixed $team_developer
 * @property-read mixed $unread_post_count
 * @property-read mixed $verified
 * @property-read mixed $verified_status_text
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transfer[] $have_transfers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\History[] $histories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\InitialCoinOffering[] $initial_coin_offerings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Issue[] $issues
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PremiumRank[] $premium_rank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Replenishment[] $replenishments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reward[] $rewards
 * @property-read \App\SocialAccount $social_account
 * @property-read \App\User $sponsor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $sponsors
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Trading[] $tradings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transfer[] $transfers
 * @property-read \App\Turnover2 $turnover2s
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Turnover[] $turnovers
 * @property-read \App\UnreadUserPost $unread_user_posts
 * @property-read \App\Verification $verification
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Withdraw[] $withdraws
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User nameOrId($user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User sponsorPlan($plan)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBinaryTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBtcBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBtcMiningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLeg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMiningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSideLeg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTokenEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTransactionPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerifiedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVmcBalance($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, UserSettingsTrait;

    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'country',
        'email',
        'mobile_number',
        'balance',
        'mining_balance',
        'password',
        'transaction_password',
        'username',
        'sponsor_id',
        'leg',
        'plan',
        'active_at',
        'address',
        'side_leg',
        'active',
        'settings',
        'token_email',
        'binary_total',
        'rank',
        'old',
    ];

    public $incrementing = false;

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login_at',
        'active_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'transaction_password',
    ];

    protected $casts = [
        'balance'        => 'double',
        'mining_balance' => 'double',
        'binary_week'    => 'double',
        'binary_total'   => 'double',
        'active'         => 'boolean',
        'old'            => 'boolean',
        'settings'       => 'array',
        'blocked'        => 'boolean',
        'team_developer' => 'boolean'
    ];

    protected $appends = [
        'full_name',
        'blocked',
        'team_developer',
    ];

    /**
     * @param array $data
     * @return \App\User
     */
    public static function createUser(array $data): User
    {
        $id = $data['id'] ?? self::generateID();
        try {
            $address = \RpcClient::getaccountaddress([(string) $id]);
        } catch (\Exception $exception) {
            $address = null;
        }
        $user = self::create([
            'id'                   => $data['id'] ?? $id,
            'sponsor_id'           => $data['sponsor_id'],
            'username'             => $data['username'],
            'email'                => $data['email'],
            'mobile_number'        => $data['mobile_number'],
            'password'             => bcrypt($data['password']),
            'transaction_password' => bcrypt($data['transaction_password']),
            'leg'                  => $data['leg'],
            'first_name'           => $data['first_name'],
            'last_name'            => $data['last_name'],
            'country'              => $data['country'],
            'token_email'          => str_random(30),
            'address'              => $address,
            'side_leg'             => $data['side_leg'],
            'balance'              => $data['balance'] ?? 0,
            'mining_balance'       => $data['mining_balance'] ?? 0,
        ]);

        return $user;
    }

    public static function generateNumericKey()
    {
        // prefixes the key with a random integer between 1 - 9 (inclusive)
        return Keygen::numeric(7)->prefix(mt_rand(1, 9))->generate(true);
    }

    public static function generateID()
    {
        $id = self::generateNumericKey();

        // Ensure ID does not exist
        // Generate new one if ID already exists
        while (self::whereId($id)->count() > 0) {
            $id = self::generateNumericKey();
        }

        return $id;
    }

    public function investBalance($type, float $amount)
    {
        if ($type == 'cold_balance'){
            return Amount::typeIncrement($type.'_'.$this->id, $amount);
        }elseif ($type == 'mining_balance'){
            $amount = USDtoVMC($amount);
        }
        $this->attributes[$type] += $amount;
        $this->save();
    }

    public function payBalance($type, float $amount)
    {
        if ($type == 'cold_balance'){
            return Amount::typeDecrement($type.'_'.$this->id, $amount);
        }elseif ($type == 'mining_balance'){
            $amount = USDtoVMC($amount);
        }
        $this->attributes[$type] -= $amount;
        $this->save();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sponsor()
    {
        return $this->hasOne(self::class, 'id', 'sponsor_id');
    }

    public function social_account()
    {
        return $this->hasOne(SocialAccount::class);
    }

    public function sponsors()
    {
        return $this->hasMany(self::class, 'sponsor_id');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function turnovers()
    {
        return $this->hasMany(Turnover::class);
    }

    public function turnover2s()
    {
        return $this->hasOne(Turnover2::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function have_transfers()
    {
        return $this->hasMany(Transfer::class, 'to_id');
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }

    public function replenishments()
    {
        return $this->hasMany(Replenishment::class);
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function computes()
    {
        return $this->hasMany(Compute::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }

    public function premium_rank()
    {
        return $this->hasMany(PremiumRank::class);
    }

    public function initial_coin_offerings()
    {
        return $this->hasMany(InitialCoinOffering::class);
    }

    public function unread_user_posts()
    {
        return $this->hasOne(UnreadUserPost::class, 'user_id', 'id');
    }

    public function verification()
    {
        return $this->hasOne(Verification::class, 'user_id', 'id');
    }

    public function tradings()
    {
        return $this->hasMany(Trading::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function getAvatarUrlAttribute()
    {
        return \Storage::disk('avatars')
            ->url($this->attributes['avatar'] ?? 'default.png');
    }

    public function getProductAttribute(): array
    {
        $deposit = new Deposit();
        $deposit->plan = $this->plan;

        return $deposit->product;
    }

    public function getBinaryWeekAttribute(): float
    {
        return 0;
        $binary_points = $this->binary_points;
        $binary_week = $binary_points->left_week > $binary_points->right_week
            ? $binary_points->right_week
            : $binary_points->left_week;

        return round($binary_week * $this->product['mlm_binary_bonus'], 2);
    }

    public function getBinaryLowerBranchAttribute()
    {
        $binary_points = $this->binary_points;

        return $binary_points->left_total > $binary_points->right_total
            ? $binary_points->right_total
            : $binary_points->left_total;
    }

    public function getBinaryPointsAttribute(): \stdClass
    {
        return Binary::getPointsByUserId($this->id);
    }

    public function getCountryNameAttribute()
    {
        return \Countries::getOne($this->country, \App::getLocale());
    }

    public function getMobileNumberFormatAttribute()
    {
        try {
            return phone($this->mobile_number, $this->country);
        }catch (\Exception $exception){
            return $this->mobile_number;
        }
    }

    public function getActiveYearAttribute()
    {
        if (empty($this->active_at)) {
            return false;
        }
        if (Carbon::now() > $this->active_at) {
            return false;
        }

        return true;
    }

    public function getBlockedAttribute()
    {
        return $this->hasSetting('blocked');
    }

    public function getTeamDeveloperAttribute()
    {
        return $this->hasSetting('team_developer');
    }

    public function getRankAttribute()
    {
        if ($this->attributes['rank'] == null) {
            return $this->attributes['rank'] = '0';
        }

        return $this->attributes['rank'];
    }

    public function getRankTextAttribute()
    {
        $this->attributes['rank'] = $this->attributes['rank'] == null ? '0' : $this->attributes['rank'];

        return trans('rank.'.(string) $this->attributes['rank']);
    }

    public function getMatchingBonusAttribute(): float
    {
        $amount = 0;
        if ($this->team_developer) {
            $amount = $this->computes()->matching()->remember(60)->sum('amount') ?? 0;
        }

        return $amount;
    }

    public function getPremiumRankBonusAttribute(): float
    {
        $amount = 0;
        if ($this->rank > 1) {
            $amount = $this->premium_rank()->sum('amount') ?? 0;
        }

        return $amount;
    }

    public function getDirectBonusAttribute(): float
    {
        $amount = $this->turnover2s()->value('direct_total') ?? 0;

        return $amount;
    }

    public function getBinaryBonusAttribute(): float
    {
        $amount = $this->binary_total ?? 0;

        return $amount;
    }

    public function getAllBonusAttribute(): float
    {
        $amount = $this->premium_rank_bonus
            + $this->direct_bonus
            + $this->binary_bonus
            + $this->matching_bonus;

        return $amount;
    }

    public function getUnreadPostCountAttribute()
    {
        $count = $this->unread_user_posts()->value('unread');

        return $count > 0 ? $count : false;
    }

    public function getSponsorUsernameAttribute()
    {
       return $this->sponsor()->value('username') ?? '-';
    }

    public function getVerifiedAttribute(): bool
    {
       return $this->hasSetting('verified');
    }

    public function getVerifiedStatusTextAttribute(): string
    {
        return $this->verification()->select('status')->first()->status_text
        ?? trans('unify/personal-office/status.verification.'.Verification::NOT_VERIFIED);
    }

    public function getColdBalanceAttribute(): float
    {
        return Amount::typeGetAmount('cold_balance_'. $this->id) ?? 0.00;
    }
    public function getIsInvestorAttribute(): bool
    {
        $deposits = $this->deposits()->select('active')->where('active', true)->exists();
        $tradings = $this->tradings()->select('status')->where('status', Trading::ACTIVE)->exists();

        return $deposits || $tradings;
    }

    public function scopeNameOrId($query, $user)
    {
        if (ctype_digit($user)) {
            return $query->where('id', str_limit($user, 8, ''));
        }

        return $query->where('username', $user);
    }

    public function scopeSponsorPlan($query, $plan)
    {
        return $query->where('plan', '>=', $plan)
            ->select(['id', 'sponsor_id', 'plan', 'leg']);
    }
}
