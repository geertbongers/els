<?php
use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController
{
    /**
     * @return \Bongers\ElsBundle\Entity\User
     */
    public function getUser()
    {

    }

    /**
     * @return \Bongers\ElsBundle\Service\AclService
     */
    public function getAclService()
    {

    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext()
    {

    }
}
