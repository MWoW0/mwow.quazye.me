<?php

namespace App;

use App\Billing\PaymentGatewayManager;
use App\Concerns\Commentable;
use App\Contracts\PaymentGateway;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Transaction extends Model implements AuditableContract
{
    use Auditable, Commentable, SoftDeletes;

    protected $fillable = [
        'creator_id',
        'type',
        'provider',
        'provider_id',
        'status',
        'amount'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function getProvider(): PaymentGateway
    {
        return resolve(PaymentGatewayManager::class)->driver($this->provider);
    }
}
