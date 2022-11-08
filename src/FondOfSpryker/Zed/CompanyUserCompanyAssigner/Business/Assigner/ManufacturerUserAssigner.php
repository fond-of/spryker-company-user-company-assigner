<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class ManufacturerUserAssigner implements ManufacturerUserAssignerInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface
     */
    protected $companyRoleNameMapper;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $config;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface
     */
    protected $companyUserMapper;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface $companyRoleNameMapper
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyUserMapperInterface $companyUserMapper
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
     */
    public function __construct(
        CompanyRoleNameMapperInterface $companyRoleNameMapper,
        CompanyUserMapperInterface $companyUserMapper,
        CompanyUserCompanyAssignerRepositoryInterface $repository,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
    ) {
        $this->companyRoleNameMapper = $companyRoleNameMapper;
        $this->companyUserMapper = $companyUserMapper;
        $this->repository = $repository;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyUserFacade = $companyUserFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignToNonManufacturerCompanies(CompanyUserTransfer $manufacturerUserTransfer): void
    {
        $idCompanyUser = $manufacturerUserTransfer->getIdCompanyUser();
        $idCustomer = $manufacturerUserTransfer->getFkCustomer();

        if ($idCompanyUser === null || $idCustomer === null) {
            return;
        }

        $companyTypeName = $this->repository->findCompanyTypeNameByIdCompanyUser($idCompanyUser);
        $companyTypeNameForManufacturer = $this->companyTypeFacade->getCompanyTypeManufacturerName();

        if ($companyTypeName !== $companyTypeNameForManufacturer) {
            return;
        }

        $companyRoleName = $this->companyRoleNameMapper->fromManufacturerUser($manufacturerUserTransfer);

        if ($companyRoleName === null) {
            return;
        }

        $nonManufacturerData = $this->repository->findNonManufacturerData($companyTypeNameForManufacturer, $companyRoleName);
        $companyUserTransfers = $this->companyUserMapper->fromNonManufacturerData($nonManufacturerData);

        foreach ($companyUserTransfers as $companyUserTransfer) {
            $companyUserTransfer = $companyUserTransfer->setFkCustomer($idCustomer)
                ->setCustomer($manufacturerUserTransfer->getCustomer());

            $this->companyUserFacade->create($companyUserTransfer);
        }
    }
}
