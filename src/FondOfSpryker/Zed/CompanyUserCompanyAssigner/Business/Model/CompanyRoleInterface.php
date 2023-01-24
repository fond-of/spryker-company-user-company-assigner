<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getCompanyUserRoleCollection(
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

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array
     */
    public function findCompanyUsersWithDiffCompanyRolesAsManufacturer(
        CompanyUserTransfer $companyUserTransfer
    ): array;
}
