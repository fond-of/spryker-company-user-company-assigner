<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
{
    /**
     * Specification:
     * - Finds company role by name
     * - Returns null if company role does not exist.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    public function findCompanyRoleByName(string $name): ?CompanyRoleTransfer;
}
