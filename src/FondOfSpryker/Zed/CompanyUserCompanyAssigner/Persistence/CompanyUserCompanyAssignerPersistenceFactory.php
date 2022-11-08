<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapper;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapperInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapper;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapperInterface;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyType\Persistence\Base\FosCompanyTypeQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface getRepository()
 */
class CompanyUserCompanyAssignerPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapperInterface
     */
    public function createCompanyRoleMapper(): CompanyRoleMapperInterface
    {
        return new CompanyRoleMapper();
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyUserMapperInterface
     */
    public function createCompanyUserMapper(): CompanyUserMapperInterface
    {
        return new CompanyUserMapper();
    }

    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY);
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }

    /**
     * @return \Orm\Zed\CompanyType\Persistence\Base\FosCompanyTypeQuery
     */
    public function getCompanyTypeQuery(): FosCompanyTypeQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_TYPE);
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_USER);
    }
}
