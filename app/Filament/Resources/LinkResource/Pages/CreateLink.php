<?php

declare(strict_types=1);

namespace App\Filament\Resources\LinkResource\Pages;

use App\DTO\StoreLinkDto;
use App\Filament\Resources\LinkResource;
use App\Services\LinkService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        /** @var LinkService $linkService */
        $linkService = app(LinkService::class);

        $link = $linkService->create(
            new StoreLinkDto(
                userId: auth()->id(),
                originalUrl: $data['original_url'],
            ),
        );

        Notification::make()
            ->title('Ссылка создана')
            ->body(sprintf(
                'Короткая ссылка: %s/%s',
                config('app.url'),
                $link->short_code,
            ))
            ->success()
            ->send();

        return $link;
    }

    protected function getRedirectUrl(): string
    {
        return LinkResource::getUrl();
    }
}
