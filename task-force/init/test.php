<?php

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

    private int $performerId;
    private int $clientId;

    private string $status;

    /**
     * Task constructor
     * @param string $status
     * @param int $clientId
     * @param ?int $performerId
     */
    public function __construct(string $status, int $clientId, ?int $performerId)
    {
        $this->setStatus($status);

        $this->performerId = $performerId;
        $this->clientId = $clientId;
    }

    public function getStatusesMap()
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCEL => 'Отменено',
            self::STATUS_IN_PROGRESS => 'В работе',
            self::STATUS_COMPLETE => 'Выполнено',
            self::STATUS_EXPIRED => 'Провалено',
        ];
    }
    
    public function getActionsMap()
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPONSE => 'Откликнуться',
            self::ACTION_COMPLETE => 'Выполнено',
            self::ACTION_DENY => 'Отказаться',
        ];
    }

    public function setStatus($status) {

    }

    public function getNextAction($action)
    {
        switch ($action) {
            case self::ACTION_CANCELED:
                return [];
                break;

            case self::ACTION_RESPOND:
                return [self::STATUS_PROGRESS];
                break;

            case self::ACTION_CANCELED:
                return [self::STATUS_PROGRESS];
                break;

            default:
                # code...
                break;
        }
    }

    public function getAvailableActions()
    {
    }
}
