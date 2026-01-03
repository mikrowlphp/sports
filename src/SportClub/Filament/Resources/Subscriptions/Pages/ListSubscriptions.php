<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages;

use App\Library\Extensions\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\SubscriptionResource;

class ListSubscriptions extends ListRecords
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
