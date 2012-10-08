<?php
namespace Bongers\ElsBundle\Service;

use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class AclService
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


    public function onUpdate($entity)
    {
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $acl = $this->getAclProvider()->createAcl($objectIdentity);

        $acl->insertObjectAce($this->getUserSecurityIdentity(), MaskBuilder::MASK_OWNER);
    }

    public function onPersist()
    {

    }

    public function onRemove()
    {

    }
}
