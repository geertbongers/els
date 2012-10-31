<?php
namespace Bongers\ElsBundle\Security;

/**
 * Responsible for building the access control list tree, which roles have which permissions. Some
 * permissions depend on a expression. If the verification expression true, those permissions are
 * also added.
 *
 * The expressions are evaluated by an expression manager.
 */
class AclProvider
{
    protected $privileges;
    protected $resourcePrivileges;
    /**
     * @var \Bongers\ElsBundle\Security\ExpressionManager
     */
    protected $expressionManager;
    /**
     * @var \Symfony\Component\Security\Core\Role\RoleHierarchyInterface
     */
    protected $roleHierarchy;

    /**
     * @param $token
     *
     * @return \Symfony\Component\Security\Core\Role\Role[]
     */
    protected function getReachableRoles($token)
    {
        return $this->roleHierarchy->getReachableRoles($token->getRoles());
    }

    protected function getResourceName($resource)
    {
        return get_class($resource);
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed                                                                $resource
     *
     * @param                                                                      $privilege
     *
     * @return array
     */
    protected function getExpressionsForPrivilege($token, $resource, $privilege)
    {
        $expressions = array();
        $resourceName = $this->getResourceName($resource);
        foreach ($this->getReachableRoles($token) as $role) {
            foreach ($this->resourcePrivileges[$role][$resourceName][$privilege] as $resourceExpression) {
                $expressions[$resourceExpression] = $resourceExpression;
            }
        }

        return array_values($expressions);
    }


    /**
     * @param string $expression
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $resource
     *
     * @return bool
     */
    public function evaluateExpression($expression, $token, $resource)
    {
        return $this->expressionManager->evaluateExpression($expression, $token, $resource);
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $privilege
     *
     * @return bool
     */
    public function roleHasPrivilege($token, $privilege)
    {
        foreach ($this->getReachableRoles($token) as $role) {
            if (isset($this->privileges[$role][$privilege])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed                                                                $resource
     *
     * @param string                                                               $privilege
     *
     * @return array
     */
    public function hasPrivilege($token, $resource, $privilege)
    {
        if ($this->roleHasPrivilege($token, $privilege)) {
            return true;
        }

        foreach ($this->getExpressionsForPrivilege($token, $resource, $privilege) as $expression) {
            if ($this->evaluateExpression($expression, $token, $resource)) {
                return true;
            }
        }

        return false;
    }
}
