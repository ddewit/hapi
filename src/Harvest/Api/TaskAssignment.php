<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class TaskAssignment extends AbstractApi
{
    
    public function allForProject($project_id, $updated_since = null)
    {
        $url = "/projects/$project_id/task_assignments";
        $this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    public function getForProject($task_assignment_id, $project_id)
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";
        return $this->performGet($url, false);
    }
    
    public function assignToProject($task_id, $project_id)
    {
        $url = "project/$project_id/task_assignments";
        return $this->performPost($url, "<task><id>$task_id</id></task>");
    }

    public function createAndAssignToProject(Model\TaskAssignment $task_assignment, $project_id)
    {
        $url = "projects/$project_id/task_assignments/add_with_create_new_task";
        return $this->performPost($url, $task_assignment->toXml());
    }

    public function update(Model\TaskAssignment $task_assignment)
    {
        $url = sprintf("projects/%s/task_assignments/%s", $task_assignment->get('project-id'), $task_assignment->get('id'));
        return $this->performPut($url, $task_assignment->toXml());
    }

    public function delete($task_assignment_id, $project_id)
    {
        $url = "projects/$project_id/task_assignments/$task_assignment_id";
        return $this->performDelete($url);
    }
}