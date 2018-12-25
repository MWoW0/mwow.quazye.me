<?php

namespace App;

use App\Concerns\connectsToEmulator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use function blank;

/**
 * Class Account
 * @package App
 *
 * @method static Builder online()
 * @method static Builder active()
 * @method static Builder inactive()
 * @method static Builder recentlyCreated()
 */
class Account extends Model
{
    use connectsToEmulator;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'realmd';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'account';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Account $account) {
            // Some databases force fills an invalid default date, this avoids query exceptions on that regard.
            if (blank($account->last_login)) {
                $account->last_login = $account->freshTimestampString();
            }
        });
    }

    /**
     * Find the account(s) for given User
     *
     * @param User|integer $user
     * @return Account|Collection
     */
    public static function forUser($user)
    {
        $user = ($user instanceof User) ? $user : User::query()->findOrFail($user);

        // return static::query()->where('username', $user->account_name);
        return static::query()->find($user->gameAccounts()->pluck('account_id'));
    }

    /**
     * Query the online accounts
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnline($query)
    {
        return $query->where('online', '>', 0);
    }

    /**
     * Query the active accounts
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('last_login', '>', $this->freshTimestamp()->subMonths(6)->format('Y-m-d'));
    }

    /**
     * Query the inactive accounts
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('last_login', '<=', $this->freshTimestamp()->subMonths(6)->format('Y-m-d'));
    }

    /**
     * Query the most recent accounts
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecentlyCreated($query)
    {
        return $query->where('joindate', '>=', $this->freshTimestamp()->subMonth()->format('Y-m-d'));
    }
}
