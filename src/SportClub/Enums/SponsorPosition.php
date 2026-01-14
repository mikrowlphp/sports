<?php

namespace Packages\Sports\SportClub\Enums;

enum SponsorPosition: string
{
    case TopLeft = 'top_left';
    case TopCenter = 'top_center';
    case TopRight = 'top_right';
    case BottomLeft = 'bottom_left';
    case BottomCenter = 'bottom_center';
    case BottomRight = 'bottom_right';

    public function label(): string
    {
        return __($this->value);
    }

    /**
     * CSS classes for positioning in the video player overlay
     */
    public function cssClasses(): string
    {
        return match ($this) {
            self::TopLeft => 'top-0 left-0',
            self::TopCenter => 'top-0 left-1/2 -translate-x-1/2',
            self::TopRight => 'top-0 right-0',
            self::BottomLeft => 'bottom-0 left-0',
            self::BottomCenter => 'bottom-0 left-1/2 -translate-x-1/2',
            self::BottomRight => 'bottom-0 right-0',
        };
    }
}
