<?php

namespace Taskforce\logic\actions;

class ResponseAction extends BaseAction {
    const ACTION_RESPONSE = 'act_response';

    public function getName()
    {
        return 'Откликнуться';
    }

    public function getInternalName()
    {
        return self::ACTION_RESPONSE;
    }

    public function check($userId, $performerId)
    {
        return $userId === $performerId;
    }
}