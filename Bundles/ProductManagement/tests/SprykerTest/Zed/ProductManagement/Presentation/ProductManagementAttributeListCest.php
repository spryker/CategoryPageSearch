<?php

/**
 * Copyright © 2017-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductManagement\Presentation;

use SprykerTest\Zed\ProductManagement\PageObject\ProductManagementAttributeListPage;
use SprykerTest\Zed\ProductManagement\PresentationTester;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Zed
 * @group ProductManagement
 * @group Presentation
 * @group ProductManagementAttributeListCest
 * Add your own group annotations below this line
 */
class ProductManagementAttributeListCest
{

    /**
     * @param \SprykerTest\Zed\ProductManagement\PresentationTester $i
     *
     * @return void
     */
    public function breadcrumbIsVisible(PresentationTester $i)
    {
        $i->amOnPage(ProductManagementAttributeListPage::URL);
        $i->seeBreadcrumbNavigation('Dashboard / Products / Attributes');
    }

}