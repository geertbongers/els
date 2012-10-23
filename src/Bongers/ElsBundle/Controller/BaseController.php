<?php
namespace Bongers\ElsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class BaseController extends FOSRestController
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext()
    {

    }

    /**
     * @return \Bongers\ElsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->getSecurityContext()->getToken()->getUser();
    }

    /**
     * @return \Bongers\ElsBundle\Service\AclService
     */
    public function getAclService()
    {

    }



    /**
     * @param int $statusCode
     *
     * @return BaseController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


}