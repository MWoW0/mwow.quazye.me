<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class Realm extends Model
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
    protected $connection = 'auth';

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
