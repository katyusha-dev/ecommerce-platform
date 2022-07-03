<?php

namespace App\Gates;

use App\Models\User;

class AdminGate extends Gate
{
    public static function canViewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public static function canCreate(User $user): bool
    {
        return $user->isAdmin();
    }

    public function canModifyOrDelete(): bool
    {
        return $this->canView();
    }

    public function canView(): bool
    {
        return self::canCreate($this->user);
    }
}
