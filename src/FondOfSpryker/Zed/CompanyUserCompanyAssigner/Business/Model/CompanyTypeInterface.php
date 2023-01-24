<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

interface CompanyTypeInterface
{
    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeManufacturer(): CompanyTypeTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * 
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer;
}
