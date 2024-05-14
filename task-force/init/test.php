<?php

class Task {
    protected const STATUS_NEW = 'new';
    protected const STATUS_CANCELED = 'canceled';
    protected const STATUS_PROGRESS = 'progress';
    protected const STATUS_DONE = 'done';
    protected const STATUS_FAILED = 'failed';
    
    protected const ACTION_CANCELED = 'cancel';
    protected const ACTION_RESPOND = 'respond';
    protected const ACTION_DONE = 'done';
    protected const ACTION_REFUSE = 'refuse';

    private $clientId = null;
    private $customerId = null;

    public function __construct(int $clientId, int $customerId) {
        $this->clientId = $clientId;
        $this->customerId = $customerId;
    }

    public function getMap() {
        return array(
            self::STATUS_NEW => 'новое',
            self::STATUS_CANCELED => 'отменено',
            self::STATUS_PROGRESS => 'в работе',
            self::STATUS_DONE => 'выполнено',
            self::STATUS_FAILED => 'провалено',
        );
    }

    public function getNextAction($action) {
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

    public function getAvailableActions() {

    }

}