<?php

/**
 * @category    ScandiPWA
 * @package     ScandiPWA_DirectoryGraphQl
 * @copyright   Copyright © 2021 Scandiweb, Ltd (https://scandiweb.com)
 * @copyright   Modifications © Selveq. All rights reserved.
 * @license     OSL-3.0 (Open Software License ("OSL") v. 3.0)
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace ScandiPWA\DirectoryGraphQl\Model\Resolver\Country;

use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class IsStateRequired implements ResolverInterface
{
    /**
     * @param DirectoryHelper $directoryHelper
     */
    public function __construct(
        private readonly DirectoryHelper $directoryHelper
    ) {}

    /**
     * {@inheritdoc}
     * @throws LocalizedException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ) {
        if (!isset($value['id'])) {
            throw new LocalizedException(__('"id" value should be specified'));
        }

        // the helper reads general/region/state_required in store scope, so the answer follows the Store header
        return in_array($value['id'], $this->directoryHelper->getCountriesWithStatesRequired(), true);
    }
}
