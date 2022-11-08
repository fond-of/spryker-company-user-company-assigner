<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostCreatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class CompanyUserCompanyAssignerCompanyUserPostCreatePlugin extends AbstractPlugin implements CompanyUserPostCreatePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postCreate(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $companyUserResponseTransfer->getIsSuccessful() !== true) {
            return $companyUserResponseTransfer;
        }

        $this->getFacade()->assignManufacturerUserNonManufacturerCompanies($companyUserTransfer);

        return $companyUserResponseTransfer;
    }
}
