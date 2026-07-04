<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $link_id
 * @property string $ip_address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class LinkClick extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'link_id',
        'ip_address',
    ];

    /**
     * @return BelongsTo
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}