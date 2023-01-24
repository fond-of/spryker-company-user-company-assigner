<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyType implements CompanyTypeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
    ) {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeManufacturer(): CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeManufacturer();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $com
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
    }
}
