<?php
class Expression
{
    public function replaceChecks($expression)
    {
        foreach ($this->checks as $check => $checker) {
            if (strpos($expression, $check) !== false) {
                $result = $checker->compile();

                str_replace($check, $result, $expression);
            }
        }
    }

    public function replaceLogicalOperators($expression)
    {
        return str_replace(
            array('and', 'or', 'not'),
            array('&&', '||', '!'),
            $expression
        );
    }

    protected function compile($expression)
    {
        $expression = $this->replaceLogicalOperators($expression);
        $expression = $this->replaceChecks($expression);

        return $expression;
    }

    public function check($expression, $user, $object)
    {
        $expression = $this->compile($expression);

        return eval($expression);
    }
}
