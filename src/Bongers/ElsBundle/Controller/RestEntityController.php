<?php
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @RouteResource("User")
 */
class RestEntityController extends BaseController
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
            ->createPersonCollection()
            ->selectAndFilterByOrganisationAndMaskView($organisation, 'ASC', 25)
            ->getEntity();

        $queryBuilder
            ->getEntityManager()
            ->createPersonCollection()
            ->selectDetailsAndFilterByIdAndMaskView($id)
            ->getEntity();

        $count = $this
            ->getRepository()
            ->findAllBy($mask)
            ->count();

        $test = new \Doctrine\ORM\QueryBuilder('');
        $test->getQuery()->getResult();
//        $test->getResult();

        return array('entities' => $entities, 'count' => $count);
    }

    /**
     * Read
     *
     * @param $resource
     *
     * @return array
     */
    public function getAction(Resource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(MaskBuilder::MASK_VIEW, $resource)) {
            throw new AccessDeniedException();
        }
        return array('entity' => $resource);
    }

    /**
     * Create new
     *
     * @param $resource
     *
     * @return array
     */
    public function postAction(Resource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(MaskBuilder::MASK_CREATE, $resource)) {
            throw new AccessDeniedException();
        }
        return $this->_processForm($resource);
    }

    /**
     * Edit
     *
     * @param $resource
     * @return array
     */
    public function putAction(Resource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(MaskBuilder::MASK_EDIT, $resource)) {
            throw new AccessDeniedException();
        }

        return $this->_processForm($resource);
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

        return $this->view(array('message' => $message, 'status' => $success));
    }

    /**
     * Delete
     *
     * @param Resource $resource
     *
     * @throws Exception
     * @return array
     */
    public function deleteAction(Resource $resource)
    {
        if (!$this->getSecurityContext()->isGranted(MaskBuilder::MASK_DELETE, $resource)) {
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
}