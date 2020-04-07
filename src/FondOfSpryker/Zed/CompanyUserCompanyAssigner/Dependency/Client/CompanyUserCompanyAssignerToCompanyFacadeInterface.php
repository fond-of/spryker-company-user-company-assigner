<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use Generated\Shared\Transfer\CompanyTransfer;

interface CompanyUserCompanyAssignerToCompanyFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer|int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function findCompanyById(int $idCompany): ?CompanyTransfer;
}
