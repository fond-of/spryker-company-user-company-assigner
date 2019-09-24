<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class CompanyUserCompanyAssignerToCompanyRoleFacadeBridge implements CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
{
    /**
     * @var \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(CompanyRoleFacadeInterface $companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    public function findCompanyRoleByName(string $name): ?CompanyRoleTransfer
    {
        return $this->getRe
    }
}
