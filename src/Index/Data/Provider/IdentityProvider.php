<?php declare(strict_types=1);

namespace Neusta\ElasticIndexBundle\Index\Data\Provider;

/**
 * @template T of object
 *
 * This interface has to be implemented for your special source type of indexed data objects
 * to separate different instances of your object; e.g. for Pimcore one could use $myObject->getId() method.
 */
interface IdentityProvider
{
    /**
     * @param T $element
     */
    public function identify(object $element): string;
}
