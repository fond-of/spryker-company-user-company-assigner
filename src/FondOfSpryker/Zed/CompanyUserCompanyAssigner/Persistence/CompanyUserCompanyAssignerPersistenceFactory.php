<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapper;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper\CompanyRoleMapperInterface;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

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
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }

}
