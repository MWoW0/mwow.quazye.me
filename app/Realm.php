<?php

namespace App;

use App\Concerns\connectsToEmulator;
use Illuminate\Database\Eloquent\Model;

class Realm extends Model
{
    use connectsToEmulator;

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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
