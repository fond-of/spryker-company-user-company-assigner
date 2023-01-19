<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getCompanyUserCollection(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyRoleCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateNonManufacturerUsersCompanyRole(
        CompanyUserTransfer $companyUserTransfer
    ): void;
}
