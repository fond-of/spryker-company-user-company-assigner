<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use FondOfSpryker\Zed\Company\Business\CompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyType\CompanyTypeConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Yaf\Exception;


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

    public function __construct(
        CompanyUserCompanyAssignerConfig $companyUserCompanyAssignerConfig,
        CompanyUserCompanyAssignerRepository $companyUserCompanyAssignerRepository,
        CompanyUserFacadeInterface $companyUserFacade,
        CompanyFacadeInterface $companyFacade,
        CompanyTypeFacadeInterface $companyTypeFacade,
        CompanyRoleFacadeInterface $companyRoleFacade,
        CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
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
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer
    {
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

        if ($companyTypeCollectionTransfer === null) {
            return $companyUserResponseTransfer;
        }

        $companyTypeCollectionTransfer = $this->getNoneManufacturerIdCompanyTypes($companyTypeCollectionTransfer);
        $companyCollectionTransfer = $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);

        if ($companyCollectionTransfer === null) {
            return $companyUserResponseTransfer;
        }

        foreach ($companyCollectionTransfer->getCompanies() as $noneManufacturerCompanyTransfer) {
            $this->addCompanyUsersToCompany(
                $noneManufacturerCompanyTransfer,
                $companyTypeTransfer,
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
    ): CompanyResponseTransfer
    {
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

        foreach ($companyCollectionTransfer->getCompanies() as $manufacturerCompanyTransfer)
        {
            $manufacturerCmpanyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())->setIdCompany($manufacturerCompanyTransfer->getIdCompany());
            $manufacturerCompanyUserCollectionTransfer = $this->companyUserFacade->getCompanyUserCollection($manufacturerCmpanyUserCriteriaFilterTransfer);

            foreach ($manufacturerCompanyUserCollectionTransfer->getCompanyUsers() as $manufacturerCompanyUserTransfer) {
                $this->addCompanyUsersToCompany(
                    $companyTransfer,
                    $companyTypeTransfer,
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
     * @return array
     */
    private function getNoneManufacturerIdCompanyTypes(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): CompanyTypeCollectionTransfer {
        $noneManufacturerCompanyTypeCollectionTransfer = new CompanyTypeCollectionTransfer();
        foreach ($companyTypeCollectionTransfer->getCompanyTypes() as $companyTypeTransfer)
        {
            if ($this->isCompanyTypeManufacturer($companyTypeTransfer) === false) {
                $noneManufacturerCompanyTypeCollectionTransfer->addCompanyType($companyTypeTransfer);
            }
        }

        return $noneManufacturerCompanyTypeCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @param \ArrayObject $companyRoleCollectionTransfer
     */
    private function addCompanyUsersToCompany(
        CompanyTransfer $companyTransfer,
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyUserTransfer $companyUserTransfer,
        ArrayObject $companyRoleCollectionTransfer
    ): void
    {
        foreach ($companyRoleCollectionTransfer as $companyRoleTransfer) {
            $this->createCompanyUser(
                $companyUserTransfer,
                $companyTransfer,
                $companyTypeTransfer,
                $companyRoleTransfer
            );
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    private function createCompanyUser(
        CompanyUserTransfer $companyUserTransfer,
        CompanyTransfer $companyTransfer,
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): CompanyUserResponseTransfer
    {
        $companyRoleTransfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
        $companyRoleName = $this->companyUserCompanyAssignerConfig->getManufacturerCompanyTypeRoleMapping()[$companyRoleTransfer->getName()];
        $companyRoleTransfer = $this->companyUserCompanyAssignerRepository
            ->findCompanyRoleNameByIdCompanyAndName($companyTransfer->getIdCompany(), $companyRoleName);
        $companyRoleCollectionTransfer = (new CompanyRoleCollectionTransfer())->addRole($companyRoleTransfer);

        $newCompanyUserTransfer = new CompanyUserTransfer();
        $newCompanyUserTransfer->setCustomer($companyUserTransfer->getCustomer());
        $newCompanyUserTransfer->setFkCustomer($companyUserTransfer->getFkCustomer());
        $newCompanyUserTransfer->setFkCompany($companyTransfer->getIdCompany());
        $newCompanyUserTransfer->setCompanyRoleCollection($companyRoleCollectionTransfer);

        return $this->companyUserFacade->create($newCompanyUserTransfer);
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
