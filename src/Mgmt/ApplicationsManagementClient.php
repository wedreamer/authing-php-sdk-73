<?php

namespace Authing\Mgmt;

use Authing\Mgmt\ManagementClient;
use Authing\Mgmt\Acl\AclManagementClient;
use Authing\Mgmt\AgreementManagementClient;
use Authing\Mgmt\Roles\RolesManagementClient;

class ApplicationsManagementClient
{
    /**
     * @var mixed[]
     */
    private $options;

    /**
     * @var ManagementClient
     */
    private $client;

    /**
     * @var AclManagementClient
     */
    private $acl;

    /**
     * @var RolesManagementClient
     */
    private $roles;

    /**
     * @var AgreementManagementClient
     */
    private $agreements;

    public function __construct(ManagementClient $client)
    {
        $this->client = $client;
        $this->acl = new AclManagementClient($client);
        $this->roles = new RolesManagementClient($client);
        $this->agreements = new AgreementManagementClient($client);
    }

    public function list(array $params = [])
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;
        $data = $this->client->httpGet("/api/v2/applications?page=$page&limit=$limit");
        return $data;
    }

    public function findById(string $id)
    {
        $data = $this->client->httpGet("/api/v2/applications/$id");
        return $data;
    }

    public function create(array $options)
    {
        $res = $this->client->httpPost('/api/v2/applications', (object)$options);
        return $res;
    }

    public function delete(string $appId)
    {
        $this->client->httpDelete("/api/v2/applications/$appId");
        return true;
    }

    public function activeUsers(string $appId, int $page = 1, int $limit = 10)
    {
        $res = $this->client->httpGet("/api/v2/applications/$appId/active-users?page=$page&limit=$limit");
        return $res;
    }

    public function refreshApplicationSecret(string $appId)
    {
        $res = $this->client->httpPatch("/api/v2/application/$appId/refresh-secret");
        return $res;
    }

    public function listResources(array $options)
    {
        $args = func_get_args();
        return $this->acl->getResources(...$args);
    }

    public function createResource(array $options)
    {
        $args = func_get_args();
        return $this->acl->createResource(...$args);
    }

    public function updateResource(string $code, array $options)
    {
        $args = func_get_args();
        return $this->acl->updateResource(...$args);
    }

    public function deleteResource(string $code, string $namespaceCode)
    {
        $args = func_get_args();
        return $this->acl->deleteResource(...$args);
    }

    public function getAccessPolicies(array $options)
    {
        $args = func_get_args();
        return $this->acl->getAccessPolicies(...$args);
    }

    public function enableAccessPolicy(array $options)
    {
        $args = func_get_args();
        return $this->acl->enableAccessPolicy(...$args);
    }

    public function disableAccessPolicy(array $options)
    {
        $args = func_get_args();
        return $this->acl->disableAccessPolicy(...$args);
    }

    public function deleteAccessPolicy(array $options)
    {
        $args = func_get_args();
        return $this->acl->deleteAccessPolicy(...$args);
    }

    public function allowAccess(array $options)
    {
        $args = func_get_args();
        return $this->acl->allowAccess(...$args);
    }

    public function denyAccess(array $options)
    {
        $args = func_get_args();
        return $this->acl->denyAccess(...$args);
    }

    public function updateDefaultAccessPolicy(array $options)
    {
        $args = func_get_args();
        return $this->acl->updateDefaultAccessPolicy(...$args);
    }

    public function createRole($code, $description = null, $parentCode = null)
    {
        $args = func_get_args();
        return $this->roles->create(...$args);
    }

    public function findRole($code)
    {
        $args = func_get_args();
        return $this->roles->detail(...$args);
    }

    public function updateRole($code, $description = null, $newCode = null)
    {
        $args = func_get_args();
        return $this->roles->update(...$args);
    }

    public function deleteRole($code)
    {
        $args = func_get_args();
        return $this->roles->delete(...$args);
    }

    public function getRoles($page = 1, $limit = 10)
    {
        $args = func_get_args();
        return $this->roles->paginate(...$args);
    }

    public function getUsersByRoleCode($code)
    {
        $args = func_get_args();
        return $this->roles->listUsers(...$args);
    }

    public function addUsersToRole($code, $userIds)
    {
        $args = func_get_args();
        return $this->roles->addUsers(...$args);
    }

    public function removeUsersFromRole($code, $userIds)
    {
        $args = func_get_args();
        return $this->roles->removeUsers(...$args);
    }

    public function listAuthorizedResourcesByRole($roleCode, $namespace, $opts = [])
    {
        $args = func_get_args();
        return $this->roles->listAuthorizedResources(...$args);
    }

    public function listAgreement(string $appId)
    {
        $args = func_get_args();
        return $this->agreements->list(...$args);
    }

    public function createAgreement(string $appId, array $agreement)
    {
        $args = func_get_args();
        return $this->agreements->create(...$args);
    }

    public function deleteAgreement(string $appId, int $agreementId)
    {
        $args = func_get_args();
        return $this->agreements->delete(...$args);
    }

    public function modifyAgreement(string $appId, int $agreementId, array $updates)
    {
        $args = func_get_args();
        return $this->agreements->modify(...$args);
    }

    public function sortAgreement(string $appId, array $order)
    {
         $args = func_get_args();
        return $this->agreements->sort(...$args);
    }
}
