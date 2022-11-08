<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserCompanyAssignerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUsersToCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function addManufacturerUsersToCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignManufacturerUserNonManufacturerCompanies(
        CompanyUserTransfer $manufacturerUserTransfer
    ): void;
}
