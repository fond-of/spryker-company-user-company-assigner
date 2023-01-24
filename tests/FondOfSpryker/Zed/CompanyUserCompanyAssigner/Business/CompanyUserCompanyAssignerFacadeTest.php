<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRole;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserCompanyAssignerFacadeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface
     */
    protected $companyUserMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Assigner\ManufacturerUserAssigner|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $manufacturerUserAssignerMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRoleInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $facade;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserMock = $this->getMockBuilder(CompanyUserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manufacturerUserAssignerMock = $this->getMockBuilder(ManufacturerUserAssigner::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleMock = $this->getMockBuilder(CompanyRole::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new CompanyUserCompanyAssignerFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompanies(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUserToCompanies')
            ->willReturn($this->companyUserResponseTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->facade->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerToCompany(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUsersToCompany')
            ->willReturn($this->companyResponseTransferMock);

        static::assertEquals(
            $this->companyResponseTransferMock,
            $this->facade->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerUsersToCompanyBusinessUnit(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserMock);

        $this->companyUserMock->expects(static::atLeastOnce())
            ->method('addManufacturerUsersToCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertEquals(
            $this->companyBusinessUnitTransferMock,
            $this->facade->addManufacturerUsersToCompanyBusinessUnit(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testAssignManufacturerUserNonManufacturerCompanies(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createManufacturerUserAssigner')
            ->willReturn($this->manufacturerUserAssignerMock);

        $this->manufacturerUserAssignerMock->expects(static::atLeastOnce())
            ->method('assignToNonManufacturerCompanies')
            ->with($this->companyUserTransferMock);

        $this->facade->assignManufacturerUserNonManufacturerCompanies(
            $this->companyUserTransferMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateNonManufacturerUsersCompanyRole(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyRole')
            ->willReturn($this->companyRoleMock);

        $this->companyRoleMock->expects(static::atLeastOnce())
            ->method('updateNonManufacturerUsersCompanyRole');

        $this->facade->updateNonManufacturerUsersCompanyRole($this->companyUserTransferMock);
    }

    /**
     * @return void
     */
    public function testGetCompanyUserRoleCollection(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createCompanyRole')
            ->willReturn($this->companyRoleMock);

        $this->companyRoleMock->expects(static::atLeastOnce())
            ->method('getCompanyUserRoleCollection')
            ->with($this->companyUserTransferMock)
            ->willReturn($this->companyRoleCollectionTransferMock);

        static::assertEquals(
             $this->companyRoleCollectionTransferMock,
             $this->facade->getCompanyUserRoleCollection(
                 $this->companyUserTransferMock,
             ),
        );
    }
}
