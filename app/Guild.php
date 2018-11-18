<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Guild extends Model
{
    use EmulatorDatabases, Searchable;

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
    protected $table = 'guild';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guildid';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the guilds with rank
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRank($query)
    {
        return $query->withCount('achievements as rank');
    }

    public function scopeRecent($query)
    {
        return $query
            ->whereDate('updatedDate', '=', $this->freshTimestamp()->toDateString())
            ->whereTime('updatedDate', '>=', $this->freshTimestamp()->subMinutes(15));
    }

    /**
     * The guilds achievements
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function achievements()
    {
        return $this->hasMany(GuildAchievement::class, 'guildid');
    }

    /**
     * The guild leader
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function leader()
    {
        return $this->belongsTo(Character::class, 'leaderguid');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $leader = $this->leader;
        /** @var Character $leader */
        $leader = optional($leader);

        $realmCharacter = $leader->realmCharacter;
        $realm = optional($realmCharacter)->realm;

        $reputation = $leader->reputation()->first();
        $faction = optional($reputation)->faction;

        return [
            'name' => $this->name,
            'link' => url('guilds', $this),
            'leader' => $leader->name,
            'faction' => $faction,
            'faction_banner_url' => Storage::url("factions/{$faction}.png"),
            'realm' => $realm ? $realm->name : 'Unknown',
            'level' => $this->level,
            'rank' => $this->rank,
            'info' => $this->info,
            'created_at' => $this->createdate,
            'updated_at' => Carbon::parse($this->updatedDate)->getTimestamp()
        ];
    }
}
