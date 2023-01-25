<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Manager;

use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRoleManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateCompanyRolesOfNonManufacturerUsers(
        CompanyUserTransfer $companyUserTransfer
    ): void;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array<int, array<string, mixed>>
     */
    public function findCompanyUsersWithOldCompanyRoles(
        CompanyUserTransfer $companyUserTransfer
    ): array;
}
