<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerPersistenceFactory getFactory()
 */
class CompanyUserCompanyAssignerRepository extends AbstractRepository implements CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @param int $idCompany
     * @param string $name
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findCompanyRoleTransferByIdCompanyAndName(int $idCompany, string $name): ?CompanyRoleTransfer
    {

        $companyRoleEntity = $this->getFactory()
            ->getCompanyRoleQuery()
                ->filterByFkCompany($idCompany)
            ->_and()
                ->filterByName($name)
            ->findOne();

        if ($companyRoleEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyRoleMapper()
            ->mapEntityToTransfer($companyRoleEntity, new CompanyRoleTransfer());
    }
}
