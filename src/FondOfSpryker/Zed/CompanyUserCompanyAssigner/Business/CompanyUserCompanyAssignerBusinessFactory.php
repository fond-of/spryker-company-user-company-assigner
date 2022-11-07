<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
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
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected function getCompanyTypeFacade(): CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected function getCompanyFacade(): CompanyUserCompanyAssignerToCompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CompanyUserCompanyAssignerToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER);
    }
}
