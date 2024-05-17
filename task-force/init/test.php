<?php
require_once "vendor/autoload.php";

use PHP2\logic\Task;



$task = new Task('new', 1);
$result = $task->getStatusesMap();
// $result = $task->getActionsMap();
// $result = $task->getNextStatus('act_cancel');
// $result = $task->statusAllowedActions('new');

// assert($task->getNextStatus('act_complete') == Task::STATUS_CANCEL, 'cancel action');


print_r($result);
