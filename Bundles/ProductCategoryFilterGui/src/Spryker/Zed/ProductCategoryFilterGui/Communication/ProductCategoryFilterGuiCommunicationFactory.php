<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductCategoryFilterGui\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\ProductCategoryFilterGui\Communication\Form\DataProvider\ProductCategoryFilterDataProvider;
use Spryker\Zed\ProductCategoryFilterGui\Communication\Form\ProductCategoryFilterForm;
use Spryker\Zed\ProductCategoryFilterGui\Communication\Table\CategoryRootNodeTable;
use Spryker\Zed\ProductCategoryFilterGui\ProductCategoryFilterGuiDependencyProvider;

/**
 * @method \Spryker\Zed\ProductCategoryFilterGui\Dependency\QueryContainer\ProductCategoryFilterGuiToCategoryInterface getQueryContainer()
 * @method \Spryker\Zed\ProductCategoryFilterGui\ProductCategoryFilterGuiConfig getConfig()
 */
class ProductCategoryFilterGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Facade\ProductCategoryFilterGuiToProductCategoryFilterInterface
     */
    public function getProductCategoryFilterFacade()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::FACADE_PRODUCT_CATEGORY_FILTER);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Facade\ProductCategoryFilterGuiToLocaleInterface
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @param int $idLocale
     *
     * @return \Spryker\Zed\ProductCategoryFilterGui\Communication\Table\CategoryRootNodeTable
     */
    public function createCategoryRootNodeTable($idLocale)
    {
        return new CategoryRootNodeTable($this->getCategoryQueryContainer(), $idLocale);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Facade\ProductCategoryFilterGuiToCategoryInterface
     */
    public function getCategoryFacade()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::FACADE_CATEGORY);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\QueryContainer\ProductCategoryFilterGuiToCategoryInterface
     */
    public function getCategoryQueryContainer()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::QUERY_CONTAINER_CATEGORY);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Facade\ProductCategoryFilterGuiToProductSearchInterface
     */
    public function getProductSearchFacade()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::FACADE_PRODUCT_SEARCH);
    }

    /**
     * @param array|null $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductCategoryFilterForm($data = null, array $options = [])
    {
        $form = new ProductCategoryFilterForm();
        return $this->getFormFactory()->create($form, $data, $options);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Communication\Form\DataProvider\ProductCategoryFilterDataProvider
     */
    public function createProductCategoryFilterDataProvider()
    {
        return new ProductCategoryFilterDataProvider($this->getProductCategoryFilterFacade());
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Client\ProductCategoryFilterGuiToCatalogInterface
     */
    public function getCatalogClient()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::CLIENT_CATALOG);
    }

    /**
     * @return \Spryker\Zed\ProductCategoryFilterGui\Dependency\Client\ProductCategoryFilterGuiToProductCategoryFilterInterface
     */
    public function getProductCategoyFilterClient()
    {
        return $this->getProvidedDependency(ProductCategoryFilterGuiDependencyProvider::CLIENT_PRODUCT_CATEGORY_FILTER);
    }
}
