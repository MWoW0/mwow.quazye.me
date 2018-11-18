<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;

class MailItem extends Model
{
    use EmulatorDatabases;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
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
    protected $table = 'mail_items';

    /**
     * The mail containing the item(s)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mail()
    {
        return $this->belongsTo(Mail::class, 'mail_id');
    }
}
