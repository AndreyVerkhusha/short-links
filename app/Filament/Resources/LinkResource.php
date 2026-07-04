<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\RelationManagers\ClicksRelationManager;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = 'Ссылки';

    protected static ?string $modelLabel = 'Ссылка';

    protected static ?string $pluralModelLabel = 'Ссылки';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('original_url')
                ->label('Оригинальная ссылка')
                ->url()
                ->required()
                ->maxLength(2048),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\TextEntry::make('original_url')
                ->label('Оригинальная ссылка')
                ->url(fn (Link $record): string => $record->original_url)
                ->openUrlInNewTab()
                ->copyable()
                ->columnSpanFull(),

            Infolists\Components\TextEntry::make('short_code')
                ->label('Короткая ссылка')
                ->state(fn (Link $record): string => url($record->short_code))
                ->url(fn (Link $record): string => url($record->short_code))
                ->openUrlInNewTab()
                ->copyable()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('original_url')
                    ->label('Оригинальная ссылка')
                    ->searchable()
                    ->limit(65)
                    ->extraAttributes(fn (Link $record): array => [
                        'title' => $record->original_url,
                    ]),

                Tables\Columns\TextColumn::make('short_code')
                    ->label('Короткая ссылка')
                    ->url(fn (Link $record): string => url($record->short_code))
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('clicks_count')
                    ->label('Переходов')
                    ->counts('clicks'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создана')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Статистика'),
                Tables\Actions\DeleteAction::make()
                    ->label('Удалить'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Ссылок пока нет');
    }

    /**
     * @return array<int, string>
     */
    public static function getRelations(): array
    {
        return [
            ClicksRelationManager::class,
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'view' => Pages\ViewLink::route('/{record}'),
        ];
    }
}
