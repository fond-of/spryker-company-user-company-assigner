<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner;

use FondOfSpryker\Shared\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class CompanyUserCompanyAssignerConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getManufacturerCompanyTypeRoleMapping()
    {
        return $this->get(CompanyUserCompanyAssignerConstants::MANUFACTURER_COMPANY_TYPE_ROLE_MAPPING, []);
    }

}