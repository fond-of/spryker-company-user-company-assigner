<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Company\Persistence\Map\SpyCompanyTableMap;
use Orm\Zed\CompanyBusinessUnit\Persistence\Map\SpyCompanyBusinessUnitTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyType\Persistence\Map\FosCompanyTypeTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerPersistenceFactory getFactory()
 */
class CompanyUserCompanyAssignerRepository extends AbstractRepository implements CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @param int $idCompany
     * @param string $companyRoleName
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    public function findCompanyRoleTransferByIdCompanyAndCompanyRoleName(int $idCompany, string $companyRoleName): ?CompanyRoleTransfer
    {
        $companyRoleEntity = $this->getFactory()
            ->getCompanyRoleQuery()
            ->clear()
            ->filterByFkCompany($idCompany)
            ->_and()
            ->filterByName($companyRoleName)
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
            ->clear()
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

    /**
     * @param int $idCompanyUser
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompanyUser(int $idCompanyUser): ?string
    {
        return $this->getFactory()
            ->getCompanyTypeQuery()
            ->clear()
            ->useSpyCompanyQuery()
                ->useCompanyUserQuery()
                    ->filterByIdCompanyUser($idCompanyUser)
                ->endUse()
            ->endUse()
            ->select([FosCompanyTypeTableMap::COL_NAME])
            ->findOne();
    }

    /**
     * @param int $idCompany
     *
     * @return string|null
     */
    public function findCompanyTypeNameByIdCompany(int $idCompany): ?string
    {
        return $this->getFactory()
            ->getCompanyTypeQuery()
            ->clear()
            ->useSpyCompanyQuery()
                ->filterByIdCompany($idCompany)
            ->endUse()
            ->select([FosCompanyTypeTableMap::COL_NAME])
            ->findOne();
    }

    /**
     * @param string $companyTypeNameForManufacturer
     * @param string $companyRoleName
     *
     * @return array<int, array<string, int>>
     */
    public function findNonManufacturerData(
        string $companyTypeNameForManufacturer,
        string $companyRoleName
    ): array {
        return $this->getFactory()
            ->getCompanyQuery()
            ->clear()
            ->useFosCompanyTypeQuery()
                ->filterByName($companyTypeNameForManufacturer, Criteria::NOT_EQUAL)
            ->endUse()
            ->useCompanyRoleQuery()
                ->filterByName($companyRoleName)
                ->withColumn(SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE, 'id_company_role')
            ->endUse()
            ->useCompanyBusinessUnitQuery()
                ->withColumn(SpyCompanyBusinessUnitTableMap::COL_ID_COMPANY_BUSINESS_UNIT, 'id_company_business_unit')
            ->endUse()
            ->withColumn(SpyCompanyTableMap::COL_ID_COMPANY, 'id_company')
            ->select(
                [
                    'id_company',
                    'id_company_business_unit',
                    'id_company_role',
                ],
            )->find()
            ->toArray();
    }

    /**
     * @param int $idCompanyRole
     *
     * @return string|null
     */
    public function findCompanyRoleNameByIdCompanyRole(int $idCompanyRole): ?string
    {
        return $this->getFactory()
            ->getCompanyRoleQuery()
            ->clear()
            ->filterByIdCompanyRole($idCompanyRole)
            ->select([SpyCompanyRoleTableMap::COL_NAME])
            ->findOne();
    }
}
