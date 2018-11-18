<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Comment extends Model implements AuditableContract
{
    use Auditable, SoftDeletes;

    protected $fillable = [
        'author_id',
        'commentable_type',
        'commentable_id',
        'title',
        'body'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo('commentable');
    }
}
