<?php
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class Voter implements \Symfony\Component\Security\Core\Authorization\Voter\VoterInterface
{
    /**
     * Checks if the voter supports the given attribute.
     *
     * @param string $attribute An attribute
     *
     * @return Boolean true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        // TODO: Implement supportsAttribute() method.
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        // TODO: Implement supportsClass() method.
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token      A TokenInterface instance
     * @param object         $object     The object to secure
     * @param array          $attributes An array of attributes associated with the method being invoked
     *
     * @return integer either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $permissions = $this->getPermissions($token, $object);

        foreach ($attributes as $attribute) {
            if (in_array($attribute, $permissions)) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }

    public function getPermissions($token, $object)
    {
        $name = get_class($object);
        $permissions = array();

        foreach ($token->getReachableRoles() as $role) {
            $permissions = array_merge($permissions, $permissions[$role]['PRIVILEGES']);
            foreach ($permissions[$role]['entityPrivileges'][$this->getName($object)] as $expression => $permissions) {
                $expression = $this->getChecker($expression);

                if ($expression->check($token, $object)) {
                    $permissions = array_merge($permissions, $permissions);
                }
            }
        }

        return $permissions;
    }
}
