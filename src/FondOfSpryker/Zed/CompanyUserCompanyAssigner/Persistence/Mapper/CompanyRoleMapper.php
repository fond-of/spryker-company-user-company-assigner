<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\Mapper;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRole;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RoleTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRole;
use Orm\Zed\CompanyUser\Persistence\Map\SpyCompanyUserTableMap;
use Propel\Runtime\Collection\ArrayCollection;
use Propel\Runtime\Collection\ObjectCollection;

class CompanyRoleMapper implements CompanyRoleMapperInterface
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
    ): CompanyRoleTransfer {
        return $companyRoleTransfer->fromArray(
            $spyCompanyRole->toArray(),
            true,
        );
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $collection
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function mapObjectCollectionToCompanyRoleCollectionTransfer(
        ObjectCollection $collection,
    ): CompanyRoleCollectionTransfer {
        $companyRoleCollectionTransfer = new CompanyRoleCollectionTransfer();
        foreach ($collection->toArray() as $item) {
            $companyRoleCollectionTransfer->addRole(
                (new CompanyRoleTransfer())->fromArray($item, true)
            );
        }

        return $companyRoleCollectionTransfer;
    }
}
