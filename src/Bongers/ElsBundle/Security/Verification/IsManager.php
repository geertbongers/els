<?php
namespace Bongers\ElsBundle\Security\Verification;

use Bongers\ElsBundle\Security\VerificationInterface;

class IsManager implements VerificationInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $resource
     *
     * @return bool
     */
    public function verify($token, $resource)
    {
        $user = $token->getUser();
        if ($resource instanceof OrgansationPartInterface
            && $resource->getOrganisationPart()->isManager($user)
        ) {
            return true;
        } else {
            return false;
        }
    }
}
