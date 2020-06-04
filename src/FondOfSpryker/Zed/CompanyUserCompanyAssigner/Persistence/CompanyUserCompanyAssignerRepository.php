<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
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
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
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

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function findCompanyUserByIdCompanyAndIdCustomer(
        CompanyTransfer $companyTransfer,
        CustomerTransfer $customerTransfer
    ): ?CompanyUserTransfer {
        $companyTransfer->requireIdCompany();
        $customerTransfer->requireIdCustomer();

        $companyUserEntity = $this->getFactory()
            ->getCompanyUserQuery()
            ->filterByFkCompany($companyTransfer->getIdCompany())
            ->filterByFkCustomer($customerTransfer->getIdCustomer())
            ->findOne();

        if ($companyUserEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyUserMapper()
            ->mapEntityToTransfer($companyUserEntity, new CompanyUserTransfer());
    }
}
