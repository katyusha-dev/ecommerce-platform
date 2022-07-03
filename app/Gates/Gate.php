<?php

namespace App\Gates;

use App\Models\User;

abstract class Gate
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    abstract public static function canCreate(User $user): bool;

    abstract public function canModifyOrDelete(): bool;

    abstract public function canView(): bool;
}
