<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\SubscriptionResource;

class EditSubscription extends EditRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
