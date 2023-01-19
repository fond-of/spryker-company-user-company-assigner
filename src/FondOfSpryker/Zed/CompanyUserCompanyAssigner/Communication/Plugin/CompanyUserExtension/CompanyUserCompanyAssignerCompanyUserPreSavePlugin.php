<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPreSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\CompanyUserCompanyAssignerCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyUserPreSavePlugin extends AbstractPlugin implements CompanyUserPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function preSave(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $companyUserResponseTransfer->getIsSuccessful() !== true) {
            return $companyUserResponseTransfer;
        }

        $companyUserRoleCollection = $this->getFacade()->getCompanyUserRoleCollection($companyUserTransfer);

        if (!$this->isCompanyUserRolesChanged($companyUserRoleCollection, $companyUserTransfer)) {
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
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyUserRoleCollectionTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function isCompanyUserRolesChanged(
        CompanyRoleCollectionTransfer $companyUserRoleCollectionTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): bool {
        $currentRoles = $this->getCompanyRoles($companyUserRoleCollectionTransfer);
        $newRoles = $this->getCompanyRoles($companyUserTransfer->getCompanyRoleCollection());

        if (!array_diff($currentRoles, $newRoles)) {
            return false;
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return array<int>
     */
    protected function getCompanyRoles(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
    ): array {
        $companyRoles = [];

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $companyRoles[] = $companyRoleTransfer->getIdCompanyRole();
        }

        return $companyRoles;
    }
}
