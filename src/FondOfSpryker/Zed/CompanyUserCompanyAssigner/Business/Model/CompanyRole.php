<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRole implements CompanyRoleInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser
     */
    protected $companyUser;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacade;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $config;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repository;

    /**
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser $companyUser
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig $config
     * @param \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     */
    public function __construct(
        CompanyUserCompanyAssignerToCompanyFacadeInterface $companyFacade,
        CompanyUserCompanyAssignerToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUser $companyUser,
        CompanyUserCompanyAssignerToCompanyUserFacadeInterface $companyUserFacade,
        CompanyUserCompanyAssignerConfig $config,
        CompanyUserCompanyAssignerRepositoryInterface $repository
    ) {
        $this->companyFacade = $companyFacade;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->companyUser = $companyUser;
        $this->companyUserFacade = $companyUserFacade;
        $this->config = $config;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    public function getCompanyUserRoleCollection(
        CompanyUserTransfer $companyUserTransfer
    ): CompanyRoleCollectionTransfer {
         return $this->companyRoleFacade
             ->getCompanyRoleCollection(
                 (new CompanyRoleCriteriaFilterTransfer())
                     ->setIdCompanyUser($companyUserTransfer->getIdCompanyUser())
             );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerCompanyUserTransfer
     *
     * @return void
     */
    public function updateNonManufacturerUsersCompanyRole(CompanyUserTransfer $companyUserTransfer): void
    {
        $companyUserTransfer = $this->hydrateCompanyRoles($companyUserTransfer);
        $companyUserCollectionTransfer = $this
            ->findCompanyUsersWithDiffCompanyRolesAsManufacturer($companyUserTransfer);

        if (count($companyUserCollectionTransfer) === 0) {
            return ;
        }

        $this->saveCompanyUsers(
            $companyUserCollectionTransfer,
            $companyUserTransfer
        );

    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    protected function hydrateCompanyRoles(CompanyUserTransfer $companyUserTransfer): CompanyUserTransfer
    {
        foreach ($companyUserTransfer->getCompanyRoleCollection()->getRoles() as $companyRoleTransfer) {
            $transfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
            $companyRoleTransfer->fromArray($transfer->toArray(), true);
        }

        return $companyUserTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCollectionTransfer $companyUserCollection
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerCompanyUserTransfer
     * @param int[] $manufacturerCompanyTypeIds
     *
     * @return void
     */
    protected function saveCompanyUsers(
        array $companyUserCollection,
        CompanyUserTransfer $companyUserTransfer,
    ): void {
        foreach ($companyUserCollection as $companyUser) {
            $companyUserTransfer = (new CompanyUserTransfer())
                ->setIdCompanyUser($companyUser['id_company_user'])
                ->setCompanyRoleCollection(
                    $this->createCompanyUserCompanyRoleCollection(
                        $companyUserTransfer,
                        $companyUser
                    )
                );

            $this->companyRoleFacade->saveCompanyUser($companyUserTransfer);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerCompanyUserTransfer
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     */
    protected function createCompanyUserCompanyRoleCollection(
        CompanyUserTransfer $manufacturerCompanyUserTransfer,
        array $companyUser
    ): CompanyRoleCollectionTransfer {
        $newCompanyRoleCollectionTransfer = new CompanyRoleCollectionTransfer();
        $companyRoleCollectionTransfer = $this->repository
            ->getCompanyRoleCollectionByCompanyId($companyUser["id_company"]);

        foreach ($manufacturerCompanyUserTransfer->getCompanyRoleCollection()->getRoles() as $roleTransfer) {
            $role = (new CompanyRoleTransfer())
                ->setIdCompanyRole($this
                    ->mapManufacturerCompanyRoleIdToCompanyRoleId($roleTransfer, $companyRoleCollectionTransfer)
                )->setName($roleTransfer->getName())
                ->setFkCompany($companyUser["id_company"]);

            $newCompanyRoleCollectionTransfer->addRole($role);
        }

        return $newCompanyRoleCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $manufacturerCompanyRoleTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return int|null
     */
    protected function mapManufacturerCompanyRoleIdToCompanyRoleId(
        CompanyRoleTransfer $manufacturerCompanyRoleTransfer,
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
    ): ?int {
        $mapping = $this->config->getManufacturerCompanyTypeRoleMapping();
        $companyRoleName = (isset($mapping[$manufacturerCompanyRoleTransfer->getName()]))
            ? $mapping[$manufacturerCompanyRoleTransfer->getName()]
            : $manufacturerCompanyRoleTransfer->getName();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            if ($companyRoleTransfer->getName() !== $companyRoleName) {
                continue;
            }

            return $companyRoleTransfer->getIdCompanyRole();
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array
     */
    public function findCompanyUsersWithDiffCompanyRolesAsManufacturer(
        CompanyUserTransfer $companyUserTransfer
    ): array {
        $roles = $this->mapManufacturerCompanyRoleNameToCompanyRoleName(
            $companyUserTransfer->getCompanyRoleCollection()
        );

        $companyIds = $this->repository->findManufacturerCompanyIdsByCustomerId(
            $companyUserTransfer->getFkCustomer(),
            $this->companyTypeFacade->getCompanyTypeManufacturer()->getIdCompanyType()
        );

        $companyUserCollection = $this->repository->findCompanyUserswithDiffCompanyRolesAsManufacturer(
            $companyUserTransfer->getFkCustomer(),
            $roles,
            $companyIds
        );

        return $companyUserCollection;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     *
     * @return string[]
     */
    protected function mapManufacturerCompanyRoleNameToCompanyRoleName(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
    ): array {
        $roles = [];
        $mapping = $this->config->getManufacturerCompanyTypeRoleMapping();

        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $roles[] = $this->getCompanyRoleName($companyRoleTransfer, $mapping);
        }

        return $roles;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @param array $mapping
     *
     * @return string
     */
    protected function getCompanyRoleName(
        CompanyRoleTransfer $companyRoleTransfer,
        array $mapping,
    ): string
    {
        if (!$companyRoleTransfer->getName()) {
            $companyRoleTransfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);
        }

        return (isset($mapping[$companyRoleTransfer->getName()]))
            ? $mapping[$companyRoleTransfer->getName()]
            : $companyRoleTransfer->getName();
    }

}
