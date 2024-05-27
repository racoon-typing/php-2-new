<?php

namespace Taskforce\logic\actions;

class DenyAction extends BaseAction {
    const ACTION_DENY = 'act_deny';

    public function getName(): string
    {
        return 'Отказаться';
    }

    public function getInternalName(): string
    {
        return self::ACTION_DENY;
    }

    public function check($userId, $performerId)
    {
        return $userId === $performerId;
    }
}