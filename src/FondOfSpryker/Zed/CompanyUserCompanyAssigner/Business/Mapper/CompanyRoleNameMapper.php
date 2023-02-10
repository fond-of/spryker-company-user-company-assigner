<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleNameMapper implements CompanyRoleNameMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface
     */
    protected $companyRoleNameFilter;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $config;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface $companyRoleNameFilter
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $config
     */
    public function __construct(
        CompanyRoleNameFilterInterface $companyRoleNameFilter,
        CompanyUserCompanyAssignerConfig $config
    ) {
        $this->companyRoleNameFilter = $companyRoleNameFilter;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return string|null
     */
    public function fromManufacturerUser(CompanyUserTransfer $manufacturerUserTransfer): ?string
    {
        $currentManufacturerRoleName = $this->companyRoleNameFilter->filterFromCompanyUser($manufacturerUserTransfer);

        if ($currentManufacturerRoleName === null) {
            return null;
        }

        $manufacturerCompanyTypeRoleMapping = $this->config->getManufacturerCompanyTypeRoleMapping();

        if (!isset($manufacturerCompanyTypeRoleMapping[$currentManufacturerRoleName])) {
            return $currentManufacturerRoleName;
        }

        return $manufacturerCompanyTypeRoleMapping[$currentManufacturerRoleName];
    }
}
