<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Eloquent;
use App\Traits\HasWallet;
use App\Constants\UserFiles;
use App\Traits\HasWithdraws;
use Laravel\Cashier\Billable;
use App\Models\Finance\Wallet;
use Illuminate\Support\Carbon;
use App\Traits\HasTransactions;
use App\Models\Finance\Withdraw;
use Laravel\Cashier\Subscription;
use Database\Factories\UserFactory;
use App\Contracts\HasWithdrawContract;
use App\Contracts\WalletHolderContract;
use Laravel\Sanctum\PersonalAccessToken;
use App\Services\Settings\SettingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Filesystem\FilesystemService;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotificationCollection;
use App\Http\Resources\User\Billing\PaymentMethodTransformer;
use Stripe\StripeClient;
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $user_type
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read UserCompany|null $company
 * @property-read Collection<int, Coupon> $coupons
 * @property-read int|null $coupons_count
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUserType($value)
 * @property float $cp_token_balance
 * @property float $usd_balance
 * @method static Builder|User whereCpTokenBalance($value)
 * @method static Builder|User whereUsdBalance($value)
 * @property-read Collection<int, Wallet> $wallets
 * @property-read int|null $wallets_count
 * @property string $phone_number
 * @method static Builder|User wherePhoneNumber($value)
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read Collection<int, Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read Collection<int, Transaction> $transactions
 * @property-read int|null $transactions_count
 * @method static Builder|User hasExpiredGenericTrial()
 * @method static Builder|User onGenericTrial()
 * @method static Builder|User wherePmLastFour($value)
 * @method static Builder|User wherePmType($value)
 * @method static Builder|User whereStripeId($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @property-read string $avatar
 * @property-read Collection<int, Withdraw> $withdraws
 * @property-read int|null $withdraws_count
 * @property string|null $avatar_version
 * @method static Builder|User whereAvatarVersion($value)
 * @property-read Collection<int, Coupon> $boughtCoupons
 * @property-read int|null $bought_coupons_count
 * @property-read Collection<int, FakeCards> $fakeCards
 * @property-read int|null $fake_cards_count
 * @property-read UserBank|null $bank
 * @property int|null $invited_by
 * @property string|null $invite_code
 * @method static Builder|User whereInviteCode($value)
 * @method static Builder|User whereInvitedBy($value)
 * @property-read User|null $invitedBy
 * @property-read Collection<int, User> $invitedUsers
 * @property-read int|null $invited_users_count
 * @property string|null $test_stripe_id
 * @method static Builder|User whereTestStripeId($value)
 * @property string|null $live_stripe_id
 * @method static Builder|User whereLiveStripeId($value)
 * @property-read Collection<int, Coupon> $favouriteCoupons
 * @property-read int|null $favourite_coupons_count
 * @property-read Shop|null $shop
 * @property Carbon|null $deleted_at
 * @property Carbon|null $last_login
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereLastLogin($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin Eloquent
 */
final class User extends Authenticatable implements WalletHolderContract, HasWithdrawContract
{
    use HasApiTokens, HasFactory, Notifiable, HasWallet, Billable, HasTransactions, HasWithdraws, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'created_by',
        'referral_code',
        'line_id',
        'difficulty',
    ];
    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login'        => 'datetime',
        'password'          => 'hashed',
    ];

    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    public function company(): HasOne
    {
        return $this->hasOne(UserCompany::class);
    }

    public function getAvatarAttribute(): string
    {
        $objFilesystem = FilesystemService::factory();

        $avatarPath = sprintf(
            UserFiles::USER_AVATAR_FULL_NAME,
            $this->id,
            $this->avatar_version ?? time()
        );

        if ($objFilesystem->exists($avatarPath)) {
            return $objFilesystem->url($avatarPath) . "?nocache=" . time();
        }

        return UserFiles::DEFAULT_AVATAR;
    }

    public function boughtCoupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, "users_coupons")->using(UsersCoupons::class);
    }

    public function favouriteCoupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class, "users_favourite_coupons");
    }

    public function fakeCards(): HasMany
    {
        return $this->hasMany(FakeCards::class);
    }

    public function bank(): HasOne
    {
        return $this->hasOne(UserBank::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function invitedUsers(): HasMany
    {
        return $this->hasMany(User::class, 'invited_by');
    }

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    public function getStripeIdAttribute()
    {
        /** @var SettingService $systemSettings */
        $systemSettings = resolve(SettingService::class);
        $stripeSettings = $systemSettings->all();

        if ($stripeSettings->isPaymentLive) {
            return $this->live_stripe_id;
        }

        return $this->test_stripe_id;
    }

    public function setStripeIdAttribute(string $value)
    {
        /** @var SettingService $systemSettings */
        $systemSettings = resolve(SettingService::class);
        $stripeSettings = $systemSettings->all();

        if ($stripeSettings->isPaymentLive) {
            $this->live_stripe_id = $value;
        } else {
            $this->test_stripe_id = $value;
        }
    }
    public function createOrGetStripeCustomer()
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        if (!$this->stripe_id) {
            $customer = $stripe->customers->create([
                'email' => $this->email,
                'name' => $this->name,
            ]);

            $this->stripe_id = $customer->id;
            $this->save();
        }

        return $stripe->customers->retrieve($this->stripe_id);
    }
}
