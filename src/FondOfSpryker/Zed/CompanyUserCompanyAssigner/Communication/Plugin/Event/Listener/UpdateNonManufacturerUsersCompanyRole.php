<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 */
class UpdateNonManufacturerUsersCompanyRole extends AbstractPlugin implements EventHandlerInterface
{
    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $transfer
     * @param string $eventName
     *
     * @return void
     */
    public function handle(TransferInterface $transfer, $eventName): void
    {
        if (
            !($transfer instanceof CompanyUserTransfer)
            || $eventName !== CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE
        ) {
            return;
        }

        $this->getFacade()->updateCompanyRolesOfNonManufacturerUsers($transfer);
    }
}
