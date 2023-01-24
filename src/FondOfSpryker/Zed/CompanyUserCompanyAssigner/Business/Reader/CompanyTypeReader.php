<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Reader;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeReader implements CompanyTypeReaderInterface
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
    public function getManufacturerCompanyType(): CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getManufacturerCompanyType();
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
