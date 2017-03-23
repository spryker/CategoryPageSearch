<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductRelation;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ProductRelation\KeyBuilder\ProductRelationKeyBuilder;
use Spryker\Client\ProductRelation\Storage\ProductRelationStorage;

class ProductRelationFactory extends AbstractFactory
{

    /**
     * @param string $localeName
     *
     * @return \Spryker\Client\ProductRelation\Storage\ProductRelationStorageInterface
     */
    public function createProductRelationStorage($localeName)
    {
        return new ProductRelationStorage(
            $this->getStorage(),
            $this->createProductRelationKeyBuilder(),
            $localeName
        );
    }

    /**
     * @return \Spryker\Shared\KeyBuilder\KeyBuilderInterface
     */
    protected function createProductRelationKeyBuilder()
    {
        return new ProductRelationKeyBuilder();
    }

    /**
     * @return \Spryker\Client\ProductRelation\Dependency\Client\ProductRelationToStorageInterface
     */
    protected function getStorage()
    {
        return $this->getProvidedDependency(ProductRelationDependencyProvider::KV_STORAGE);
    }

    /**
     * @return \Spryker\Client\ProductRelation\Dependency\Client\ProductRelationToLocaleClientInterface
     */
    public function getLocaleClient()
    {
        return $this->getProvidedDependency(ProductRelationDependencyProvider::CLIENT_LOCALE);
    }

}
