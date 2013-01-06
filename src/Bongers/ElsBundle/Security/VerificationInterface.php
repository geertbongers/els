<?php
namespace Bongers\ElsBundle\Security;

interface VerificationInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $resource
     *
     * @return bool
     */
    function verify($token, $resource);
}
