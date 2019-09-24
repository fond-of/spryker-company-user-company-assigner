<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence;

use Generated\Shared\Transfer\CompanyRoleTransfer;

interface CompanyUserCompanyAssignerRepositoryInterface
{
    /**
     * @param int $idCompany
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function findCompanyRoleNameByIdCompanyAndName(int $idCompany, string $name): CompanyRoleTransfer;
}
