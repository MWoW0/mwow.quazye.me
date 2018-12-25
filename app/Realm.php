<?php

namespace App;

use App\Concerns\connectsToEmulator;
use Illuminate\Database\Eloquent\Model;

class Realm extends Model
{
    use connectsToEmulator;

    /**
     * Map of game build version to expansion name
     * 
     * @var array
     */
    public static $expansions = [
        12340 => 'wotlk',
        15595 => 'cataclysm'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

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
    protected $table = 'realmlist';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'realmbuilds' => 'integer'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getExpansionAttribute()
    {
        return self::$expansions[$this->realmbuilds] ?? 'unknown';
    }
}
