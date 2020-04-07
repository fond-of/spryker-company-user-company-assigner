<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyUserCompanyAssignerToCompanyTypeFacadeBridge implements CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param int $idCompanyType
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeById(int $idCompanyType): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeById($idCompanyType);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getCompanyTypes(): CompanyTypeCollectionTransfer
    {
        return $this->companyTypeFacade->getCompanyTypes();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): ?CompanyCollectionTransfer {
        return $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);
    }

    /**
     * @return string|null
     */
    public function getCompanyTypeManufacturerName(): ?string
    {
        return $this->companyTypeFacade->getCompanyTypeManufacturerName();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeByName(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeByName($companyTypeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeById($companyTypeTransfer);
    }
}
