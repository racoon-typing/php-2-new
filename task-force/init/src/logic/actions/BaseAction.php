<?php

namespace Taskforce\logic\actions;

abstract class BaseAction {
    abstract public function getName();

    abstract public function getInternalName();
    
    abstract public function check($userId, $performerId);
}
