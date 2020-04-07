<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function getCompanyRoleById(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleTransfer;
}
