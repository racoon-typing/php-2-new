<?php
require_once "vendor/autoload.php";

use Taskforce\logic\actions\CancelAction;
use Taskforce\logic\actions\CompleteAction;
use Taskforce\logic\actions\DenyAction;
use Taskforce\logic\actions\ResponseAction;
use Taskforce\logic\Task;


$task = new Task(
    Task::STATUS_NEW, 
    1, 
    new CancelAction(),
    new CompleteAction(),
    new DenyAction(),
    new ResponseAction(),
    null
);
// $result = $task->getStatusesMap();
// $result = $task->getActionsMap();
// $result = $task->getNextStatus('act_cancel');
$result = $task->statusAllowedActions(Task::STATUS_NEW);

// assert($task->getNextStatus('act_complete') == Task::STATUS_CANCEL, 'cancel action');


print_r($result);
