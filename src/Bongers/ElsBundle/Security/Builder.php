<?php
namespace Bongers\ElsBundle\Security;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class AclBuilder
{
    /**
     * @return \Symfony\Component\Security\Acl\Model\MutableAclProviderInterface
     */
    protected function getAclProvider()
    {

    }

    protected function getUserSecurityIdentity()
    {
        return UserSecurityIdentity::fromAccount($this->getUser());
    }


}
