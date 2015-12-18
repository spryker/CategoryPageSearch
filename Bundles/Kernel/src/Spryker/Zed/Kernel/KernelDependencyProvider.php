<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Kernel;

class KernelDependencyProvider extends AbstractBundleDependencyProvider
{

    const FACADE_MESSENGER = 'messenger facade';

    /**
     * @param Container $container
     *
     * @return Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::FACADE_MESSENGER] = function (Container $container) {
            return $container->getLocator()->messenger()->facade();
        };

        return $container;
    }

}