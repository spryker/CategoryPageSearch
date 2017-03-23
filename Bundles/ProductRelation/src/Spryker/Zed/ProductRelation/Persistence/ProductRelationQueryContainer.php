<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductRelation\Persistence;

use Generated\Shared\Transfer\ProductRelationTransfer;
use Orm\Zed\Category\Persistence\Map\SpyCategoryAttributeTableMap;
use Orm\Zed\Price\Persistence\Map\SpyPriceProductTableMap;
use Orm\Zed\ProductCategory\Persistence\Map\SpyProductCategoryTableMap;
use Orm\Zed\ProductRelation\Persistence\Map\SpyProductRelationTableMap;
use Orm\Zed\ProductRelation\Persistence\Map\SpyProductRelationTypeTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractLocalizedAttributesTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Spryker\Zed\ProductRelation\Persistence\ProductRelationPersistenceFactory getFactory()
 */
class ProductRelationQueryContainer extends AbstractQueryContainer implements ProductRelationQueryContainerInterface
{

    const COL_ASSIGNED_CATEGORIES = 'assignedCategories';
    const COL_NUMBER_OF_RELATED_PRODUCTS = 'numberOfRelatedProducts';

    /**
     * @api
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationTypeQuery
     */
    public function queryProductRelationType()
    {
        return $this->getFactory()
            ->createProductRelationTypeQuery();
    }

    /**
     * @api
     *
     * @param string $key
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationTypeQuery
     */
    public function queryProductRelationTypeByKey($key)
    {
        return $this->getFactory()
            ->createProductRelationTypeQuery()
            ->filterByKey($key);
    }

    /**
     * @api
     *
     * @param int $idProductRelation
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery
     */
    public function queryProductRelationByIdProductRelation($idProductRelation)
    {
        return $this->getFactory()
            ->createProductRelationQuery()
            ->filterByIdProductRelation($idProductRelation);
    }

    /**
     * @api
     *
     * @param int $idProductRelationType
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery
     */
    public function queryProductRelationByIdRelationType($idProductRelationType)
    {
        return $this->getFactory()
            ->createProductRelationQuery()
            ->filterByFkProductRelationType($idProductRelationType);
    }

    /**
     * @api
     *
     * @param int $idProductAbstract
     * @param string $relationKey
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery
     */
    public function queryProductRelationByIdProductAbstractAndRelationKey($idProductAbstract, $relationKey)
    {
        return $this->getFactory()
            ->createProductRelationQuery()
            ->useSpyProductRelationTypeQuery()
                ->filterByKey($relationKey)
            ->endUse()
            ->filterByFkProductAbstract($idProductAbstract);
    }

    /**
     * @api
     *
     * @param int $idProductRelation
     * @param int $idProductAbstract
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationProductAbstractQuery
     */
    public function queryProductRelationProductAbstractByIdRelationAndIdProduct($idProductRelation, $idProductAbstract)
    {
        return $this->getFactory()
            ->createProductRelationProductAbstractQuery()
            ->filterByFkProductRelation($idProductRelation)
            ->filterByFkProductAbstract($idProductAbstract);
    }

    /**
     * @api
     *
     * @param int $idProductRelation
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationProductAbstractQuery
     */
    public function queryProductRelationProductAbstractByIdProductRelation($idProductRelation)
    {
        return $this->getFactory()
            ->createProductRelationProductAbstractQuery()
            ->filterByFkProductRelation($idProductRelation);
    }

    /**
     * @api
     *
     * @param int $idLocale
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractQuery
     */
    public function queryProductsWithCategoriesByFkLocale($idLocale)
    {
        return $this->getFactory()
            ->getProductQueryContainer()
            ->queryProductAbstract()
            ->select([
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
                SpyProductAbstractTableMap::COL_SKU,
                SpyProductAbstractLocalizedAttributesTableMap::COL_NAME,
                SpyProductAbstractLocalizedAttributesTableMap::COL_DESCRIPTION,
                SpyPriceProductTableMap::COL_PRICE,
            ])
            ->withColumn(sprintf('GROUP_CONCAT(%s)', SpyCategoryAttributeTableMap::COL_NAME), static::COL_ASSIGNED_CATEGORIES)
            ->joinPriceProduct()
            ->useSpyProductAbstractLocalizedAttributesQuery()
              ->filterByFkLocale($idLocale)
            ->endUse()
            ->joinSpyProductCategory()
            ->addJoin(
                SpyProductCategoryTableMap::COL_FK_CATEGORY,
                SpyCategoryAttributeTableMap::COL_FK_CATEGORY
            )
            ->addGroupByColumn(SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT)
            ->addGroupByColumn(SpyProductAbstractLocalizedAttributesTableMap::COL_NAME)
            ->addGroupByColumn(SpyPriceProductTableMap::COL_PRICE);
    }

    /**
     * @api
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery
     */
    public function queryProductRelationsWithProductCount()
    {
        return $this->getFactory()
            ->createProductRelationQuery()
            ->select([
                SpyProductRelationTableMap::COL_ID_PRODUCT_RELATION,
                SpyProductAbstractTableMap::COL_SKU,
                SpyProductRelationTypeTableMap::COL_KEY,
                SpyProductRelationTableMap::COL_IS_ACTIVE,
                SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT,
            ])
            ->joinSpyProductAbstract()
            ->joinSpyProductRelationProductAbstract('num_alias')
            ->withColumn('COUNT(num_alias)', static::COL_NUMBER_OF_RELATED_PRODUCTS)
            ->joinSpyProductRelationType()
            ->groupByIdProductRelation();
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductRelationTransfer $productRelationTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function getRulePropelQuery(ProductRelationTransfer $productRelationTransfer)
    {
        return $this->getFactory()
            ->createCatalogPriceRuleQueryCreator()
            ->createQuery($productRelationTransfer);
    }

    /**
     * @api
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationQuery
     */
    public function queryActiveProductRelations()
    {
        return $this->getFactory()
            ->createProductRelationQuery()
            ->filterByIsActive(true);
    }

    /**
     * @api
     *
     * @return \Orm\Zed\ProductRelation\Persistence\SpyProductRelationProductAbstractQuery
     */
    public function queryActiveProductRelationProductAbstract()
    {
        return $this->getFactory()
            ->createProductRelationProductAbstractQuery()
            ->joinSpyProductAbstract()
            ->useSpyProductRelationQuery()
              ->filterByIsActive(true)
            ->endUse();
    }

    /**
     * @api
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAttributeKeyQuery
     */
    public function queryProductAttributeKey()
    {
        return $this->getFactory()
           ->getProductQueryContainer()
           ->queryProductAttributeKey();
    }

}
