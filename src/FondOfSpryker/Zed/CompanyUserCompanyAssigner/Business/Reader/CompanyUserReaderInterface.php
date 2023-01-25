<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Reader;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return array<int, array<string, mixed>>
     */
    public function findWithInconsistentCompanyRolesByManufacturerUser(
        CompanyUserTransfer $manufacturerUserTransfer
    ): array;
}
