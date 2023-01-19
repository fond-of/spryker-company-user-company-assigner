<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssignerInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilter;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapper;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapper;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRole;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRoleInterface;
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
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRoleInterface
     */
    public function createCompanyRole(): CompanyRoleInterface
    {
        return new CompanyRole(
            $this->getCompanyFacade(),
            $this->getCompanyRoleFacade(),
            $this->getCompanyTypeFacade(),
            $this->createCompanyUser(),
            $this->getCompanyUserFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssignerInterface
     */
    public function createManufacturerUserAssigner(): ManufacturerUserAssignerInterface
    {
        return new ManufacturerUserAssigner(
            $this->createCompanyRoleNameMapper(),
            $this->createCompanyUserMapper(),
            $this->getRepository(),
            $this->getCompanyTypeFacade(),
            $this->getCompanyUserFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface
     */
    protected function createCompanyRoleNameMapper(): CompanyRoleNameMapperInterface
    {
        return new CompanyRoleNameMapper(
            $this->createCompanyRoleNameFilter(),
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter\CompanyRoleNameFilterInterface
     */
    protected function createCompanyRoleNameFilter(): CompanyRoleNameFilterInterface
    {
        return new CompanyRoleNameFilter(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface
     */
    protected function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
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
