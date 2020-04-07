<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository getRepository()
 */
class CompanyUserCompanyAssignerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface
     */
    public function createCompanyUser(): CompanyUserInterface
    {
        return new CompanyUser(
            $this->getConfig(),
            $this->getRepository(),
            $this->getCompanyUserFacade(),
            $this->getCompanyFacade(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyBusinessUnitFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUserCompanyAssignerToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUserCompanyAssignerToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER);
    }
}
