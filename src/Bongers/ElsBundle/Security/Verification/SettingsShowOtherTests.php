<?php
namespace Bongers\ElsBundle\Security\Verification;

use Bongers\ElsBundle\Security\VerificationInterface;

class SettingsShowOtherTests implements VerificationInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $resource
     *
     * @return bool
     */
    public function verify($token, $resource)
    {
        return $resource->getOrganisation()->getSettings()->managerCanSeeOtherTestsEarly();
    }
}
