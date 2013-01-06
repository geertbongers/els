<?php
namespace Bongers\ElsBundle\Security;

/**
 *
 */
class ExpressionManager
{
    /**
     * @var \Bongers\ElsBundle\Security\VerificationInterface[]
     */
    protected $verifications;

    /**
     * @param \Bongers\ElsBundle\Security\VerificationInterface $verification
     * @param string $alias
     *
     * @return \Bongers\ElsBundle\Security\ExpressionManager
     */
    public function addVerification($verification, $alias)
    {
        $this->verifications[$alias] = $verification;

        return $this;
    }

    /**
     * @param $alias
     *
     * @return VerificationInterface
     */
    public function getVerification($alias)
    {
        return $this->verifications[$alias];
    }

    /**
     * @param $expression
     *
     * @return \Bongers\ElsBundle\Security\ExpressionManager
     */
    protected function replaceVerifications($expression)
    {
        foreach ($this->verifications as $alias => $verification) {
            if (strpos($expression, $alias) !== false) {
                $result = '$this->verifyByAlias(\'' . $alias . '\', $token, $resource)';

                str_replace($alias, $result, $expression);
            }
        }

        return $this;
    }

    /**
     * @param string $expression
     *
     * @return string
     */
    protected function replaceLogicalOperators($expression)
    {
        return str_replace(
            array('and', 'or', 'not'),
            array('&&', '||', '!'),
            $expression
        );
    }

    /**
     * @param string $expression
     *
     * @return \Bongers\ElsBundle\Security\ExpressionManager
     */
    protected function compile($expression)
    {
        $expression = $this->replaceLogicalOperators($expression);
        $expression = $this->replaceVerifications($expression);

        return $expression;
    }

    /**
     * @param string $alias
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $recource
     *
     * @return bool
     */
    protected function verifyByAlias($alias, $token, $recource)
    {
        return $this->getVerification($alias)->verify($token, $recource);
    }

    /**
     * @param string $expression
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param mixed $object
     *
     * @return bool
     */
    public function evaluateExpression($expression, $token, $object)
    {
        $expression = $this->compile($expression);

        return eval($expression);
    }
}
