<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class Gear extends Model
{
    use EmulatorDatabases;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'world';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_template';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'entry';

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
}
