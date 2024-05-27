<?php

namespace Taskforce\logic\actions;

class CancelAction extends BaseAction {
    const ACTION_CANCEL = 'act_cancel';

    public function getName()
    {
        return 'Отменить';
    }

    public function getInternalName()
    {
        return self::ACTION_CANCEL;
    }

    public function check($userId, $performerId)
    {
        return $userId === $performerId;
    }
}