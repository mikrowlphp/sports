<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum SubscriptionStatus: string implements HasLabel
{
    case Active = 'active';
    case Expired = 'expired';
    case Cancelled = 'cancelled';
    case Suspended = 'suspended';

    public function getLabel(): string
    {
        return __('sports::enums.subscription_status.' . $this->value);
    }
}
