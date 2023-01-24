<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper;

use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;
use Propel\Runtime\Collection\ArrayCollection;
use Propel\Runtime\Collection\ObjectCollection;

interface CompanyRoleMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyRole\Persistence\SpyCompanyRole $spyCompanyRole
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function mapEntityToTransfer(
        SpyCompanyRole $spyCompanyRole,
        CompanyRoleTransfer $companyRoleTransfer
    ): CompanyRoleTransfer;

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $collection
     * 
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function mapObjectCollectionToCompanyRoleCollectionTransfer(
        ObjectCollection $collection,
    ): CompanyRoleCollectionTransfer;
}
