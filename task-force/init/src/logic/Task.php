<?php

namespace Taskforce\logic;

use Taskforce\logic\actions\AbstractAction;
use Taskforce\logic\actions\CompleteAction;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'proceed';
    const STATUS_CANCEL = 'cancel';
    const STATUS_COMPLETE = 'complete';
    const STATUS_EXPIRED = 'expired';

    const ROLE_PERFORMER = 'performer';
    const ROLE_CLIENT = 'customer';

    private int|null $performerId;
    private int $clientId;

    private string $status;

    /**
     * Task constructor
     * @param string $status
     * @param int $clientId
     * @param BaseAction $cancelAction
     * @param ?int|null $performerId
     */
    public function __construct(string $status, int $clientId, ?int $performerId = null)
    {
        $this->setStatus($status);

        $this->clientId = $clientId;
        $this->performerId = $performerId;
    }


    public function getAvailableAction(string $role, int $id) {

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
    // public function getActionsMap(): array
    // {
    //     return [
    //         self::ACTION_CANCEL => 'Отменить',
    //         self::ACTION_RESPONSE => 'Откликнуться',
    //         self::ACTION_COMPLETE => 'Выполнено',
    //         self::ACTION_DENY => 'Отказаться',
    //     ];
    // }
    public function getActionsMap(): array
    {
        return [
            $this->cancelAction->getName(),
            $this->completeAction->getName(),
            $this->responseAction->getName(),
            $this->denyAction->getName(),
        ];
    }

    /**
     * Возвращает статус задачи после совершения действия
     * 
     * @param string $action
     * @return string|null
     */
    // public function getNextStatus(string $action): ?string
    // {
    //     $map = [
    //         self::ACTION_COMPLETE => self::STATUS_COMPLETE,
    //         self::ACTION_CANCEL => self::STATUS_CANCEL,
    //         self::ACTION_DENY => self::STATUS_CANCEL,
    //     ];

    //     return $map[$action] ?? null;
    // }

    public function getNextStatus(string $action): ?string
    {
        $map = [
            CompleteAction::class => self::STATUS_COMPLETE,
            $this->cancelAction->getName() => self::STATUS_CANCEL,
            $this->denyAction->getName() => self::STATUS_CANCEL,
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
            self::STATUS_IN_PROGRESS => [$this->completeAction, $this->denyAction],
            self::STATUS_NEW => [$this->cancelAction, $this->responseAction],
        ];

        return $map[$status] ?? [];
    }
}
