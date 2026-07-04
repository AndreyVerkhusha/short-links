<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTO\StoreLinkDto;
use App\Models\Link;
use App\Models\LinkClick;

class LinkRepository
{
    /**
     * @param StoreLinkDto $dto
     * @param string $shortCode
     * @return Link
     */
    public function create(StoreLinkDto $dto, string $shortCode): Link
    {
        return Link::create([
            'user_id' => $dto->userId,
            'original_url' => $dto->originalUrl,
            'short_code' => $shortCode,
        ]);
    }

    /**
     * @param Link $link
     * @return void
     */
    public function incrementClicks(Link $link): void
    {
        LinkClick::create([
            'link_id' => $link->id,
            'ip_address' => request()->ip() ?? '',
        ]);
    }

    /**
     * @param string $shortCode
     * @return Link|null
     */
    public function findByShortCode(string $shortCode): ?Link
    {
        /** @var Link|null $link */
        $link = Link::query()
            ->where('short_code', $shortCode)
            ->first();

        return $link;
    }

    /**
     * @param string $shortCode
     * @return bool
     */
    public function existsByShortCode(string $shortCode): bool
    {
        return Link::query()
            ->where('short_code', $shortCode)
            ->exists();
    }
}