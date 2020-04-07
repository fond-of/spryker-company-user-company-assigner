<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

interface CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
{
    /**
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function findDefaultBusinessUnitByCompanyId(int $idCompany): CompanyBusinessUnitTransfer;
}
