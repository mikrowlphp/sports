<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages;

use App\Library\Extensions\Pages\CreateRecord;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\SubscriptionResource;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;
}
