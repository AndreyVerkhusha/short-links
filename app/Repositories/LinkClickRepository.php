<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Link;
use App\Models\LinkClick;

class LinkClickRepository
{
    public function create(Link $link, string $ipAddress): LinkClick
    {
        return LinkClick::create([
            'link_id' => $link->id,
            'ip_address' => $ipAddress,
        ]);
    }
}
