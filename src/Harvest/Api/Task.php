<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Task extends AbstractApi
{
    
    public function all($updated_since = null)
    {
        $url = "tasks";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function get($task_id)
    {
        $url = "tasks/$task_id";
        return $this->performGet($url, false);
    }

    public function create(Model\Task $task)
    {
        $url = "tasks";
        return $this->performPost($url, $task->toXml());
    }

    public function update(Model\Task $task)
    {
        $url = "tasks/$task->id";
        return $this->performPut($url, $task->toXml());
    }
    
    public function activate($task_id)
    {
        $url = "tasks/$task_id/activate";
        return $this->performPost($url, "");
    }

    public function delete($task_id)
    {
        $url = "tasks/$task_id";
        return $this->performDelete($url);
    }
}