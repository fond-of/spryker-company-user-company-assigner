<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUser implements CompanyUserInterface
{
    /**
     * @var \FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $companyUserCompanyAssignerConfig;

    /**
     * @var \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository
     */
    protected $companyUserCompanyAssignerRepository;

    /**
     * @var \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $companyUserCompanyAssignerRepository
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(
        CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig,
        CompanyUserCompanyAssignerRepositoryInterface $companyUserCompanyAssignerRepository,
        CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
    ) {
        $this->companyFacade = $companyFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyUserCompanyAssignerConfig = $companyUserCompanyAssignerConfig;
        $this->companyUserFacade = $companyUserFacade;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
        $this->companyUserCompanyAssignerRepository = $companyUserCompanyAssignerRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer {

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || $companyUserTransfer->getFkCompany() === null) {
            return $companyUserResponseTransfer;
        }

        $companyTransfer = $this->companyFacade->findCompanyById($companyUserTransfer->getFkCompany());

        if ($companyTransfer === null) {
            return $companyUserResponseTransfer;
        }
        $companyTypeTransfer = $this->companyTypeFacade->findCompanyTypeById($companyTransfer->getFkCompanyType());

        if ($companyTypeTransfer === null) {
            return $companyUserResponseTransfer;
        }

        if ($this->isCompanyTypeManufacturer($companyTypeTransfer) === false) {
            return $companyUserResponseTransfer;
        }

        $companyTypeCollectionTransfer = $this->companyTypeFacade->getCompanyTypes();
        $companyTypeCollectionTransfer = $this->getNoneManufacturerIdCompanyTypes($companyTypeCollectionTransfer);
        $companyCollectionTransfer = $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);

        if ($companyCollectionTransfer === null) {
            return $companyUserResponseTransfer;
        }

        foreach ($companyCollectionTransfer->getCompanies() as $noneManufacturerCompanyTransfer) {
            $this->addCompanyUsersToCompany(
                $noneManufacturerCompanyTransfer,
                $companyUserTransfer,
                $companyUserTransfer->getCompanyRoleCollection()->getRoles()
            );
        }

        return $companyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUsersToCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();
        $companyTypeTransfer = $companyTransfer->getCompanyType();

        if ($companyTypeTransfer === null) {
            $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTransfer->getFkCompanyType());
            $companyTypeTransfer = $this->companyTypeFacade->getCompanyTypeById($companyTypeTransfer);
        }

        if ($this->isCompanyTypeManufacturer($companyTypeTransfer)) {
            return $companyResponseTransfer;
        }

        $companyCollectionTransfer = $this->getCompanyCollectionByCompanyTypeName(
            $this->companyTypeFacade->getCompanyTypeManufacturerName()
        );

        if ($companyCollectionTransfer === null) {
            return $companyResponseTransfer;
        }

        foreach ($companyCollectionTransfer->getCompanies() as $manufacturerCompanyTransfer) {
            $manufacturerCompanyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())->setIdCompany($manufacturerCompanyTransfer->getIdCompany());
            $manufacturerCompanyUserCollectionTransfer = $this->companyUserFacade->getCompanyUserCollection($manufacturerCompanyUserCriteriaFilterTransfer);

            foreach ($manufacturerCompanyUserCollectionTransfer->getCompanyUsers() as $manufacturerCompanyUserTransfer) {
                $this->addCompanyUsersToCompany(
                    $companyTransfer,
                    $manufacturerCompanyUserTransfer,
                    $manufacturerCompanyUserTransfer->getCompanyRoleCollection()->getRoles()
                );
            }
        }

        return $companyResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    private function getNoneManufacturerIdCompanyTypes(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): CompanyTypeCollectionTransfer {
        $noneManufacturerCompanyTypeCollectionTransfer = new CompanyTypeCollectionTransfer();
        foreach ($companyTypeCollectionTransfer->getCompanyTypes() as $companyTypeTransfer) {
            if ($this->isCompanyTypeManufacturer($companyTypeTransfer) === false) {
                $noneManufacturerCompanyTypeCollectionTransfer->addCompanyType($companyTypeTransfer);
            }
        }

        return $noneManufacturerCompanyTypeCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \ArrayObject $companyRoleCollection
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    private function addCompanyUsersToCompany(
        CompanyTransfer $companyTransfer,
        CompanyUserTransfer $companyUserTransfer,
        ArrayObject $companyRoleCollection
    ): CompanyUserResponseTransfer {

        return $this->createCompanyUser(
            $companyUserTransfer,
            $companyTransfer,
            $companyRoleCollection
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \ArrayObject $companyRoleCollection
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    private function createCompanyUser(
        CompanyUserTransfer $companyUserTransfer,
        CompanyTransfer $companyTransfer,
        ArrayObject $companyRoleCollection
    ): CompanyUserResponseTransfer {
        $companyBusinessUnitTransfer =
            $this->companyBusinessUnitFacade->findDefaultBusinessUnitByCompanyId($companyTransfer->getIdCompany());

        $newCompanyUserTransfer = new CompanyUserTransfer();
        $newCompanyUserTransfer->setCustomer($companyUserTransfer->getCustomer());
        $newCompanyUserTransfer->setFkCustomer($companyUserTransfer->getFkCustomer());
        $newCompanyUserTransfer->setFkCompany($companyTransfer->getIdCompany());
        $newCompanyUserTransfer->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());
        $newCompanyUserTransfer->setCompanyRoleCollection(
            $this->createCompanyRoleCollectionTransfer(
                $companyTransfer,
                $companyRoleCollection
            )
        );

        return $this->companyUserFacade->create($newCompanyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \ArrayObject $companyRoleCollection
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function createCompanyRoleCollectionTransfer(
        CompanyTransfer $companyTransfer,
        ArrayObject $companyRoleCollection
    ): CompanyRoleCollectionTransfer {
        $companyRoleCollectionTransfer = (new CompanyRoleCollectionTransfer());

        foreach ($companyRoleCollection as $companyRoleTransfer) {
            $companyRoleTransfer = $this->findCompanyRoleTransferByIdCompanyAndName(
                $companyTransfer,
                $companyRoleTransfer
            );

            if ($companyRoleTransfer === null) {
                continue;
            }

            $companyRoleCollectionTransfer->addRole($companyRoleTransfer);
        }

        return $companyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer|null
     */
    protected function findCompanyRoleTransferByIdCompanyAndName(
        CompanyTransfer $companyTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): ?CompanyRoleTransfer {
        $companyRoleTransfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
        $companyRoleName = $this->companyUserCompanyAssignerConfig
            ->getManufacturerCompanyTypeRoleMapping()[$companyRoleTransfer->getName()];

        return $this->companyUserCompanyAssignerRepository
            ->findCompanyRoleTransferByIdCompanyAndName($companyTransfer->getIdCompany(), $companyRoleName);
    }

    /**
     * @param string $companyTypeName
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    private function getCompanyCollectionByCompanyTypeName(string $companyTypeName): ?CompanyCollectionTransfer
    {
        $companyTypeTransfer = (new CompanyTypeTransfer())->setName($companyTypeName);
        $companyTypeTransfer = $this->companyTypeFacade->getCompanyTypeByName($companyTypeTransfer);

        if ($companyTypeTransfer === null) {
            return null;
        }

        $companyTypeTransfer = (new CompanyTypeTransfer())->setIdCompanyType($companyTypeTransfer->getIdCompanyType());
        $companyTypeCollectionTransfer = (new CompanyTypeCollectionTransfer())->addCompanyType($companyTypeTransfer);
        $companyCollectionTransfer = $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);

        return $companyCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return bool
     */
    private function isCompanyTypeManufacturer(CompanyTypeTransfer $companyTypeTransfer): bool
    {
        return $companyTypeTransfer->getName() === $this->companyTypeFacade->getCompanyTypeManufacturerName();
    }
}
