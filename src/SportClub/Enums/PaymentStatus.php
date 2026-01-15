<?php

namespace Packages\Sports\SportClub\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Refunded = 'refunded';

    public function getLabel(): string
    {
        return __('sports::enums.payment_status.' . $this->value);
    }
}
