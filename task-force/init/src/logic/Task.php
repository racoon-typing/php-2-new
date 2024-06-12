<?php

namespace Taskforce\logic;

use Taskforce\logic\actions\AbstractAction;
use Taskforce\logic\actions\CancelAction;
use Taskforce\logic\actions\CompleteAction;
use Taskforce\logic\actions\DenyAction;
use Taskforce\logic\actions\ResponseAction;

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


    public function getAvailableActions(string $role, int $id) {
        $statusActions = $this->statusAllowedActions($this->status);
        $roleActions = $this->roleAllowedActions($role);

        $allowedActions = array_intersect($statusActions, $roleActions);

        $allowedActions = array_filter($allowedActions, function ($action) use ($id) {
            return $action::checkRights($id, $this->performerId, $this->clientId);
        });

        // return array($statusActions, $roleActions);

        return array_values($allowedActions);
    }


    /**
     * Возвращает карту статусов
     * 
     * @return string[]
     */
    public function getStatusMap(): array
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
            CancelAction::getLabel(),
            CompleteAction::getLabel(),
            ResponseAction::getLabel(),
            DenyAction::getLabel(),
        ];
    }

    /**
     * Возвращает статус задачи после совершения действия
     * 
     * @param AbstractAction $action
     * @return string|null
     */
    public function getNextStatus(AbstractAction $action): ?string
    {
        $map = [
            CompleteAction::class => self::STATUS_COMPLETE,
            CancelAction::class => self::STATUS_CANCEL,
            DenyAction::class => self::STATUS_CANCEL,
        ];

        return $map[get_class($action)] ?? null;
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
     * @param string $role
     * @return array
     */
    public function roleAllowedActions(string $role): array
    {
        $map = [
            self::ROLE_CLIENT => [CompleteAction::class, CancelAction::class],
            self::ROLE_PERFORMER => [DenyAction::class, ResponseAction::class],
        ];

        return $map[$role] ?? [];
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
            self::STATUS_IN_PROGRESS => [CompleteAction::class, DenyAction::class],
            self::STATUS_NEW => [CancelAction::class, ResponseAction::class],
        ];

        return $map[$status] ?? [];
    }
}
