<?php
namespace Bongers\ElsBundle\Entity\Base;

use FOS\UserBundle\Entity\User as FOSUser;

class BaseUser extends FOSUser
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @param int $id
     *
     * @return BaseUser
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}