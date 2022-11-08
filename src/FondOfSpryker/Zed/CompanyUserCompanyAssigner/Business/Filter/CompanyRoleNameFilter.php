<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Filter;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleNameFilter implements CompanyRoleNameFilterInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     */
    public function __construct(CompanyUserCompanyAssignerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return string|null
     */
    public function filterFromCompanyUser(CompanyUserTransfer $companyUserTransfer): ?string
    {
        $companyRoleCollectionTransfer = $companyUserTransfer->getCompanyRoleCollection();

        if ($companyRoleCollectionTransfer === null || $companyRoleCollectionTransfer->getRoles()->count() !== 1) {
            return null;
        }

        /** @var \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer */
        $companyRoleTransfer = $companyRoleCollectionTransfer->getRoles()
            ->offsetGet(0);

        $companyRoleName = $companyRoleTransfer->getName();
        $idCompanyRole = $companyRoleTransfer->getIdCompanyRole();

        if ($companyRoleName === null && $idCompanyRole === null) {
            return null;
        }

        if ($companyRoleName !== null) {
            return $companyRoleName;
        }

        return $this->repository->findCompanyRoleNameByIdCompanyRole($idCompanyRole);
    }
}
