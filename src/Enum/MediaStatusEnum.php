<?php

namespace App\Enum;

enum MediaStatusEnum:string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
    case COMING_SOON = 'coming_soon';
    case REMOVED = 'removed';
    case IN_PROGRESS = 'in_progress';
}
