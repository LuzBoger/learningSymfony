<?php
namespace App\DataFixtures\Provider;

use App\Enum\MediaStatusEnum;

class MediaStatusProvider
{
    public function mediaStatus(string $status): MediaStatusEnum
    {
        return MediaStatusEnum::from($status);
    }
}
