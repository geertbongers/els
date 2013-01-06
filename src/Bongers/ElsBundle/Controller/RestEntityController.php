<?php
namespace Bongers\ElsBundle\Controller;

use FOS\Rest\Util\Codes;
use Bongers\ElsBundle\Rest\RestResource;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @RouteResource("User")
 */
abstract class RestEntityController extends BaseController
{
    /**
     * Read
     *
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function cgetAction($limit = 25, $offset = 0)
    {
        $resource = $this->getResource();
        if (!$this->getSecurityContext()->isGranted(\Privileges::ENTITY_LIST, $resource)) {
            throw new AccessDeniedException();
        }

        // Always use @View and groups with group collection, and query params
        // In routing only display routing specific parameters, rest are query ones, if validation
        // is needed add @QueryParam Validation also determined on type
        $queryBuilder = $this
            ->getRepository()
            ->findAll($limit, $offset, true);

        $queryBuilder = $this
            ->getRepository()
            ->query()
            ->selectOrganisation()
            ->filterByOrganisation($organisation)
            ->orderByOrganisationName('ASC')
            ->applyAclMask(MaskBuilder::MASK_VIEW)
            ->applyLimitAndOffset($limit, $offset)
            ->getIds()
            ->selectPersonOrganisationPart($queryBuilder);

        $queryBuilder
            ->getEntityManager()
            ->createPersonCollectionQuery()
            ->filterByOrganisationAndMaskView($organisation, 'ASC', 25)
            ->getEntities();

        $queryBuilder
            ->getEntityManager()
            ->createPersonCollectionQuery()
            ->select()
            ->filterByIdAndMaskView($id)
            ->getEntity();

        $count = $this
            ->getRepository()
            ->findAllBy($mask)
            ->count();

        return array('entities' => $entities, 'count' => $count);
    }

    /**
     * Read
     *
     * @param Resource $resource
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return array
     */
    public function getAction(RestResource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(\Privileges::ENTITY_CREATE, $resource)) {
            throw new AccessDeniedException();
        }

        return array('entity' => $resource);
    }

    /**
     * Create new
     *
     * @param Resource $resource
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return array
     */
    public function postAction(RestResource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(\Privileges::ENTITY_CREATE, $resource)) {
            throw new AccessDeniedException();
        }

        if ($this->getSecurityContext()->isGranted(\Privileges::INVITE, $resource)) {
            $showInviteLink = '';
        }

        $return = $this->_processForm($resource);

        if ($this->getEntityManager()->isInserted($resource)) {
            $this->setStatusCode(Codes::HTTP_CREATED);
        }

        return $return;
    }

    /**
     * Edit/update
     *
     * @param Resource $resource
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @return array
     */
    public function putAction(RestResource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(\Privileges::ENTITY_UPDATE, $resource)) {
            throw new AccessDeniedException();
        }

        $return = $this->_processForm($resource);

        return $return;
    }

    /**
     * @param $resource
     *
     * @throws Exception
     * @return array
     */
    public function _processForm($resource)
    {
        $form = $this->createForm($this->getForm(), $resource);

        if ($form->isValid()) {
            $this->getEntityManager()->beginTransaction();
            try {
                $this->getEntityManager()->flush();
                $this->getEntityManager()->commit();
                $success = true;
                $message = '';
            } catch (Exception $e) {
                $this->getEntityManager()->rollback();

                throw new Exception(
                    sprintf(
                        'Failed to remove resource %s with id %s.',
                        get_class($resource),
                        $resource->getId()
                    )
                );
            }
        } else {
            $success = false;
            $message = $this->getFormErrors($form);
        }

        return array('message' => $message, 'status' => $success);
    }

    /**
     * Delete
     *
     * @param Resource $resource
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws Exception
     * @return array
     */
    public function deleteAction(RestResource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(\Privileges::ENTITY_DELETE, $resource)) {
            throw new AccessDeniedException();
        }

        $this->getEntityManager()->beginTransaction();
        try {
            $this->getEntityManager()->remove($resource);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();
            $message = null;
            $success = true;
        } catch (Exception $e) {
            $this->getEntityManager()->rollback();

            throw new Exception(
                sprintf(
                    'Failed to remove resource %s with id %s.',
                    get_class($resource),
                    $resource->getId()
                )
            );
        }

        return array('message' => $message, 'status' => $success);
    }

    public function patchAction()
    {

    }

    public function optionAction()
    {

    }

    public function getRestResource()
    {
    }
}