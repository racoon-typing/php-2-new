<?php

namespace Taskforce\logic\actions;

class CompleteAction extends BaseAction {
    const ACTION_COMPLETE = 'act_complete';

    public function getName()
    {
        return 'Выполнено';
    }

    public function getInternalName()
    {
        return self::ACTION_COMPLETE;
    }

    public function check($userId, $performerId)
    {
        return $userId === $performerId;
    }
}