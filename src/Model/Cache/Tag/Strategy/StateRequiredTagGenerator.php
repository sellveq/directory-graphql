<?php

/**
 * @category    ScandiPWA
 * @package     ScandiPWA_DirectoryGraphQl
 * @copyright   Copyright 2023 Adobe. All Rights Reserved.
 * @copyright   Modifications © Selveq. All rights reserved.
 * @license     OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace ScandiPWA\DirectoryGraphQl\Model\Cache\Tag\Strategy;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\DirectoryGraphQl\Model\Resolver\Country\Identity;
use Magento\Framework\App\Config\Value;
use Magento\Framework\App\Config\ValueInterface;
use Magento\Store\Model\Config\Cache\Tag\Strategy\TagGeneratorInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class StateRequiredTagGenerator implements TagGeneratorInterface
{
    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        private readonly StoreManagerInterface $storeManager
    ) {}

    /**
     * {@inheritdoc}
     */
    public function generateTags(ValueInterface $config): array
    {
        // core's CountryTagGenerator ignores this path; getPath is Value's magic getter, not ValueInterface's
        if (!$config instanceof Value || $config->getPath() !== DirectoryHelper::XML_PATH_STATES_REQUIRED) {
            return [];
        }

        $tags = [];
        foreach ($this->storeIdsInScope($config) as $storeId) {
            $tags[] = sprintf('%s_%s', Identity::CACHE_TAG, $storeId);
        }

        return $tags;
    }

    /**
     * the store views a saved config value applies to
     * @param Value $config
     * @return int[]
     */
    private function storeIdsInScope(Value $config): array
    {
        if ($config->getScope() === ScopeInterface::SCOPE_STORES) {
            return [(int)$config->getScopeId()];
        }

        $websiteId = $config->getScope() === ScopeInterface::SCOPE_WEBSITES ? (int)$config->getScopeId() : null;
        $storeIds = [];

        foreach ($this->storeManager->getStores() as $store) {
            if ($websiteId === null || (int)$store->getWebsiteId() === $websiteId) {
                $storeIds[] = (int)$store->getId();
            }
        }

        return $storeIds;
    }
}
