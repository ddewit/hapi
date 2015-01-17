<?php

namespace Harvest\Api;

use \Harvest\Api\AbstractApi;
use \Harvest\Model;

class Project extends AbstractApi
{

    /**
     * get all projects
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getProjects();
     * if ($result->isSuccess()) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param  mixed  $updated_since DateTime
     * @return Result
     */
    public function all($updated_since = null)
    {
        $url = "projects".$this->appendUpdatedSinceParam($updated_since);
        return $this->performGet($url, true);
    }

    /**
     * get all projects of a client
     *
     * <code>
     * $api = new HarvestApi();
     *
     * $result = $api->getClientProjects();
     * if ($result->isSuccess()) {
     *     $projects = $result->data;
     * }
     * </code>
     *
     * @param  int    $client_id Client Identifier
     * @return Result
     */
    public function getProjectsForClient($client_id)
    {
        $url = "projects?client=$client_id";
        return $this->performGet($url, true);
    }

    /**
     * get a single project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->getProject($project_id);
     * if ($result->isSuccess()) {
     *     $project = $result->data;
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function get($project_id)
    {
        $url = "projects/$project_id";
        return $this->performGet($url, false);
    }

    /**
     * create new project
     *
     * <code>
     * $project = new Project();
     * $project->set("name", "New Project");
     * $project->set("client-id", 11111);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->createProject($project);
     * if ($result->isSuccess()) {
     *     // get id of created project
     *     $project_id = $result->data;
     * }
     * </code>
     *
     * @param  Project $project Project
     * @return Result
     */
    public function create(Model\Project $project)
    {
        $url = "projects";
        return $this->performPost($url, $project->toXml());
    }

    /**
     * update a Project
     *
     * <code>
     * $project = new Project();
     * $project->set("id", 12345);
     * $project->set("name", "New Project");
     * $project->set("client-id", 11111);
     *
     * $api = new HarvestApi();
     *
     * $result = $api->updateProject($project);
     * if ($result->isSuccess()) {
     *     // additional logic
     * }
     * </code>
     *
     * @param  Project $project Project
     * @return Result
     */
    public function update(Model\Project $project)
    {
        $url = "projects/$project->id";
        return $this->performPut($url, $project->toXml());
    }

    /**
     * activate / deactivate a project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->toggleProject($project_id);
     * if ($result->isSuccess()) {
     *     // addtional logic
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function toggle($project_id)
    {
        $url = "projects/$project_id/toggle";
        return $this->performPut($url, "");
    }

    /**
     * delete a project
     *
     * <code>
     * $project_id = 11111;
     * $api = new HarvestApi();
     *
     * $result = $api->deleteProject($project_id);
     * if ($result->isSuccess()) {
     *      // additional logic
     * }
     * </code>
     *
     * @param  int    $project_id Project Identifier
     * @return Result
     */
    public function delete($project_id)
    {
        $url = "projects/$project_id";
        return $this->performDelete($url);
    }
}
