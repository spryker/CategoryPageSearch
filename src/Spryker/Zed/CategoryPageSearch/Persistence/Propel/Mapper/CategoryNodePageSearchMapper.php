<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryPageSearch\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CategoryNodePageSearchTransfer;
use Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch;
use Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingInterface;

class CategoryNodePageSearchMapper
{
    /**
     * @var \Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Zed\CategoryPageSearch\Dependency\Service\CategoryPageSearchToUtilEncodingInterface $utilEncodingService
     */
    public function __construct(CategoryPageSearchToUtilEncodingInterface $utilEncodingService)
    {
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodePageSearchTransfer $categoryNodePageSearchTransfer
     * @param \Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch $categoryNodePageSearchEntity
     *
     * @return \Orm\Zed\CategoryPageSearch\Persistence\SpyCategoryNodePageSearch
     */
    public function mapCategoryNodePageSearchTransferToCategoryNodePageSearchEntity(
        CategoryNodePageSearchTransfer $categoryNodePageSearchTransfer,
        SpyCategoryNodePageSearch $categoryNodePageSearchEntity
    ): SpyCategoryNodePageSearch {
        $categoryNodePageSearchEntity->fromArray($categoryNodePageSearchTransfer->toArray());

        $categoryNodePageSearchEntity->setFkCategoryNode($categoryNodePageSearchTransfer->getIdCategoryNodeOrFail());
        $structuredData = $this->utilEncodingService->encodeJson($categoryNodePageSearchTransfer->getNodeOrFail()->toArray()) ?? '';
        $categoryNodePageSearchEntity->setStructuredData($structuredData);

        return $categoryNodePageSearchEntity;
    }
}
