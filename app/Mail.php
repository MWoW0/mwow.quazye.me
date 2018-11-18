<?php

namespace App;

use App\Concerns\EmulatorDatabases;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Mail extends Model
{
    const STATIONERY_NORMAL = 41;
    const STATIONERY_GM = 61;
    const STATIONERY_AUCTION = 62;

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
    protected $table = 'mail';

    /**
     * Send the items to the recipient character by in-game mail(s).
     *
     * @param string $recipientCharacterGuid
     * @param array $items
     * @param int $perMail
     *
     * @return \Illuminate\Support\Collection
     */
    public static function sendItems($recipientCharacterGuid, $items, $perMail = 8)
    {
        return Collection::wrap($items)
            ->chunk($perMail)
            ->map(function ($chunk) use ($recipientCharacterGuid) {
                $mail = Mail::templateForSendingItems($recipientCharacterGuid);

                foreach ($chunk as $item) {
                    $mail->items()->create([
                        'mail_id' => $mail,
                        'receiver' => $recipientCharacterGuid,
                        'item_guid' => $item
                    ]);
                }

                return $mail;
            })->each->saveOrFail();
    }

    /**
     * Fill the template for sending items by in-game mail
     *
     * @param string $recipientCharacterGuid
     * @return Mail
     */
    public static function templateForSendingItems($recipientCharacterGuid)
    {
        return new static([
            'id' => static::query()->max('id') + 1,
            'receiver' => $recipientCharacterGuid,
            'subject' => trans('ingame_mails.items.subject'),
            'body' => trans('ingame_mails.items.body'),
            'stationery' => self::STATIONERY_GM,
            'has_items' => true,

            'expire_time' => now()->addWeeks(2)->getTimestamp(),
            'deliver_time' => now()->getTimestamp(),
        ]);
    }

    /**
     * The items attached to the mail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(MailItem::class, 'mail_id');
    }

    /**
     * The mail recipient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Character::class, 'receiver');
    }

    /**
     * The mail sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Character::class, 'sender');
    }
}
