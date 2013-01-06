<?php
namespace Bongers\ElsBundle\Listener;

use Bongers\ElsBundle\Security\Privileges;

class FormListener
{
    public function onEvent($event)
    {
        $form = '';
        $objects = $this->getEntitiesFromForm($form);

        foreach ($objects as $object) {
            if (($this->isPersistent($object)
                    && !$this->getSecurityContext()->isGranted(Privileges::OBJECT_UPDATE, $object)
                )
                || (!$this->isPersistent($object)
                    && !$this->getSecurityContext()->isGranted(Privileges::OBJECT_CREATE, $object)
                )
            ) {
                throw new AccessDeniedException();
            }
        }
    }

    public function isPersistent($object)
    {

    }

    protected function getEntitiesFromForm($form)
    {
        $entities = array();

        return $entities;
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContextInterface
     */
    public function getSecurityContext()
    {

    }
}
