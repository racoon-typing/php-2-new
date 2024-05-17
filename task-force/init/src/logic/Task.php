<?php

namespace PHP2\logic;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'proceed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';

    const ACTION_RESPONSE = 'act_response';
    const ACTION_CANCEL = 'act_cancel';
    const ACTION_DENY = 'act_deny';
    const ACTION_COMPLETE = 'act_complete';

    const ROLE_PERFORMER = 'performer';
    const ROLE_CLIENT = 'customer';

    private int|null $performerId;
    private int $clientId;

    private string $status;

    /**
     * Task constructor
     * @param string $status
     * @param int $clientId
     * @param ?int|null $performerId
     */
    public function __construct(string $status, int $clientId, ?int $performerId = null)
    {
        $this->setStatus($status);

        $this->clientId = $clientId;
        $this->performerId = $performerId;
    }


    /**
     * Возвращает карту статусов
     * 
     * @return string[]
     */
    public function getStatusesMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }

    /**
     * Возвращает карту действий
     * 
     * @return string[]
     */
    public function getActionsMap(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPONSE => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_DENY => 'Отказаться',
        ];
    }

    /**
     * Возвращает статус задачи после совершения действия
     * 
     * @param string $action
     * @return string|null
     */
    public function getNextStatus(string $action): ?string
    {
        $map = [
            self::ACTION_COMPLETE => self::STATUS_COMPLETE,
            self::ACTION_CANCEL => self::STATUS_CANCEL,
            self::ACTION_DENY => self::STATUS_CANCEL,
        ];

        return $map[$action] ?? null;
    }

    /**
     * Устанавливает текущий статус
     * 
     * @param string $status
     * @return void
     */
    private function setStatus(string $status): void
    {
        $availableStatuses = [
            self::STATUS_NEW,
            self::STATUS_CANCEL,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETE,
            self::STATUS_EXPIRED
        ];

        if (in_array($status, $availableStatuses)) {
            $this->status = $status;
        }
    }

    /**
     * Возвращает список возможных дейтсивй для указанного статуса
     * 
     * @param string $status
     * @return array
     */
    public function statusAllowedActions(string $status): array
    {
        $map = [
            self::STATUS_IN_PROGRESS => [self::ACTION_COMPLETE, self::ACTION_DENY],
            self::STATUS_NEW => [self::ACTION_CANCEL, self::ACTION_RESPONSE],
        ];

        return $map[$status] ?? [];
    }
}



// $task = new Task('new', 1);
// $result = $task->getStatusesMap();
// $result = $task->getActionsMap();
// $result = $task->getNextStatus('act_cancel');
// $result = $task->statusAllowedActions('new');

// assert($task->getNextStatus('act_complete') == Task::STATUS_CANCEL, 'cancel action');


// print_r($result);
