<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUser\Dependency\CompanyUserEvents;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostSavePluginInterface;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyUserPostSavePlugin extends AbstractPlugin implements CompanyUserPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postSave(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null
            || $companyUserResponseTransfer->getIsSuccessful() !== true
            || !$this->isCompanyTypeManufacturer($companyUserTransfer)
            || !$this->hasDiffCompanyUserRoles($companyUserTransfer)
        ) {
            return $companyUserResponseTransfer;
        }

        $this->getFactory()
            ->getEventFacade()
            ->trigger(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE,
                $companyUserTransfer,
            );

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function isCompanyTypeManufacturer(CompanyUserTransfer $companyUserTransfer): bool
    {
        $companyTypeManufacturerTransfer = $this->getFacade()->getCompanyTypeManufacturer();
        $companyTypeTransfer = $this->getFacade()->getCompanyTypeByCompany(
            (new CompanyTransfer())->setIdCompany($companyUserTransfer->getFkCompany())
        );

        return ($companyTypeTransfer->getName() === $companyTypeManufacturerTransfer->getName());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function hasDiffCompanyUserRoles(CompanyUserTransfer $companyUserTransfer): bool
    {
        $companyUserCollectionTransfer = $this->getFacade()
            ->findCompanyUsersWithDiffCompanyRolesAsManufacturer($companyUserTransfer);

        return (count($companyUserCollectionTransfer) > 0);
    }

}
