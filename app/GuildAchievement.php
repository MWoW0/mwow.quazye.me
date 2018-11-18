<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class GuildAchievement extends Model
{
    use EmulatorDatabases;

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
    protected $connection = 'characters';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'guild_achievement';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guildid';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
