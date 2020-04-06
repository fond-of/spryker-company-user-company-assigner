<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;

class CompanyUserCompanyAssignerFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $companyUserCompanyAssignerFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory
     */
    protected $companyUserCompanyAssignerBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUserInterface
     */
    protected $companyUserInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected $companyResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserCompanyAssignerBusinessFactoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserInterfaceMock = $this->getMockBuilder(CompanyUserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyResponseTransferMock = $this->getMockBuilder(CompanyResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerFacade = new CompanyUserCompanyAssignerFacade();
        $this->companyUserCompanyAssignerFacade->setFactory($this->companyUserCompanyAssignerBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddManufacturerUserToCompanies(): void
    {
        $this->companyUserCompanyAssignerBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserInterfaceMock);

        $this->companyUserInterfaceMock->expects($this->atLeastOnce())
            ->method('addManufacturerUserToCompanies')
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserCompanyAssignerFacade->addManufacturerUserToCompanies(
                $this->companyUserResponseTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testAddManufacturerToCompany(): void
    {
        $this->companyUserCompanyAssignerBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCompanyUser')
            ->willReturn($this->companyUserInterfaceMock);

        $this->companyUserInterfaceMock->expects($this->atLeastOnce())
            ->method('addManufacturerUsersToCompany')
            ->willReturn($this->companyResponseTransferMock);

        $this->assertInstanceOf(
            CompanyResponseTransfer::class,
            $this->companyUserCompanyAssignerFacade->addManufacturerUsersToCompany(
                $this->companyResponseTransferMock
            )
        );
    }
}
