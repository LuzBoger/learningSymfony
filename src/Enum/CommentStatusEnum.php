<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    case PUBLISH = "publish";
    case PENDING = "pending";
    case REJECTED = "rejected";
}
