<?php
namespace Bongers\ElsBundle\Service;

use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Bongers\ElsBundle\Entity\User;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

class AclService
{
    const ROLE_ENTITY_EMAIL_TEMPLATE = 'roleEntityEmailTemplate';
    const ROLE_ENTITY_EMAIL_CONTENT = 'roleEntityEmailTemplate';

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext()
    {

    }

    public function buildAcl()
    {
        $userRole = new RoleSecurityIdentity(self::ROLE_ENTITY_EMAIL_TEMPLATE);
        $managerRole = UserSecurityIdentity::fromToken('ROLE_USER');

        $user = new User();
        $objectClassIdentity = new ObjectIdentity('class', get_class($user));
        $acl = $this->getAclProvider()->createAcl($objectClassIdentity);

        $acl->insertClassAce($userRole, MaskBuilder::MASK_VIEW);
        $acl->insertClassAce($userRole, MaskBuilder::MASK_EDIT);
        $acl->insertClassAce($managerRole, MaskBuilder::MASK_MANAGER);

    }

    /**
     * @return \Bongers\ElsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->getSecurityContext()->getToken()->getUser();
    }

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

    public function addRoleTo($object, $role, $mask)
    {
        // EmailTemplate class, ROLE_ENTITY_EMAIL_TEMPLATE
        $objectClassIdentity = new ClassId;

        $acl = $this->getAclProvider()->createAcl($objectClassIdentity);

        // EmailContent class ROLE_ENTITY_EMAIL_CONTENT
        $roleEntityEmailTemplate = new RoleSecurityIdentity(self::ROLE_ENTITY_EMAIL_TEMPLATE);

        $acl->insertClassAce($roleEntityEmailTemplate, MaskBuilder::MASK_MASTER);
    }

    public function addEntity($object)
    {
        // EmailTemplate class, ROLE_ENTITY_EMAIL_TEMPLATE
        $objectClassIdentity = new ObjectIdentity('class', get_class($object));
        // EmailContent class ROLE_ENTITY_EMAIL_CONTENT
        $roleEntityEmailTemplate = new RoleSecurityIdentity(self::ROLE_ENTITY_EMAIL_TEMPLATE);

        $acl = $this->getAclProvider()->createAcl($objectClassIdentity);
        $acl->insertClassAce($roleEntityEmailTemplate, MaskBuilder::MASK_MASTER);
    }

    public function initAcl()
    {
        $this->addEntity(new EmailTemplate());
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
