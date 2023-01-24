<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory getFactory()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface getRepository()
 */
class CompanyUserCompanyAssignerFacade extends AbstractFacade implements CompanyUserCompanyAssignerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUserToCompanies($companyUserResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateNonManufacturerUsersCompanyRole(
        CompanyUserTransfer $companyUserTransfer
    ): void {
        $this->getFactory()
            ->createCompanyRole()
            ->updateNonManufacturerUsersCompanyRole($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUsersToCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUsersToCompany($companyResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function addManufacturerUsersToCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUsersToCompanyBusinessUnit($companyBusinessUnitTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignManufacturerUserNonManufacturerCompanies(CompanyUserTransfer $manufacturerUserTransfer): void
    {
        $this->getFactory()
            ->createManufacturerUserAssigner()
            ->assignToNonManufacturerCompanies($manufacturerUserTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeManufacturer(): CompanyTypeTransfer
    {
        return $this->getFactory()
            ->createCompanyType()
            ->getCompanyTypeManufacturer();
    }

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer
    {
        return $this
            ->getFactory()
            ->createCompanyType()
            ->getCompanyTypeByCompany($companyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array<int, array<string, mixed>>
     */
    public function findCompanyUsersWithDiffCompanyRolesAsManufacturer(
        CompanyUserTransfer $companyUserTransfer
    ): array {
        return $this->getFactory()
            ->createCompanyRole()
            ->findCompanyUsersWithDiffCompanyRolesAsManufacturer($companyUserTransfer);
    }
}
