<?php

namespace Taskforce\logic\actions;

class CompleteAction extends AbstractAction {
    public static function getLabel()
    {
        return 'Выполнено';
    }

    public static function getInternalName()
    {
        return 'act_complete';
    }

    public static function checkRights($userId, $performerId, $clientId)
    {
        return $userId == $clientId;
    }
}