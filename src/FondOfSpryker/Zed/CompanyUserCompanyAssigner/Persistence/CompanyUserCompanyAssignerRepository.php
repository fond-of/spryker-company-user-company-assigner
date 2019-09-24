<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\BrandCollectionTransfer;
use Generated\Shared\Transfer\BrandProductAbstractRelationTransfer;
use Generated\Shared\Transfer\BrandTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRole\Business\Model\CompanyRole;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerPersistenceFactory getFactory()
 */
class CompanyUserCompanyAssignerRepository extends AbstractRepository implements CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @param int $idCompany
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     *
     * @throws
     */
    public function findCompanyRoleNameByIdCompanyAndName(int $idCompany, string $name): CompanyRoleTransfer
    {
        $companyRoleEntity = $this->getFactory()
            ->getCompanyRoleQuery()
                ->filterByFkCompany($idCompany)
            ->_and()
                ->filterByName($name)
            ->findOne();

        return $this->getFactory()
            ->createCompanyRoleMapper()
            ->mapEntityToTransfer($companyRoleEntity, new CompanyRoleTransfer());


    }
}
