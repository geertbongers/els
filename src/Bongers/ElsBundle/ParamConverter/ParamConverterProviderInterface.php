<?php
namespace Bongers\ElsBundle\ParamConverter;

interface ParamConverterProviderInterface
{
    /**
     * @param                     $controller
     * @param \ReflectionParameter $reflectedParameter
     * @param mixed               $value
     *
     * @return bool
     */
    function supports($controller, $reflectedParameter, $value);

    /**
     * @param                     $controller
     * @param \ReflectionParameter $reflectedParameter
     * @param mixed               $value
     *
     * @return mixed
     */
    function convert($controller, $reflectedParameter, $value);
}