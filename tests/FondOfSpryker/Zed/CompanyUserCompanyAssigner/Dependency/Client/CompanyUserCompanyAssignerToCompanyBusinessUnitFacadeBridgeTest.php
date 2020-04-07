<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;

class CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeInterfaceMock;

    /**
     * @var int
     */
    protected $idCompany;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyBusinessUnitFacadeInterfaceMock = $this->getMockBuilder(CompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompany = 1;

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge = new CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge(
            $this->companyBusinessUnitFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindDefaultBusinessUnitByCompanyId(): void
    {
        $this->companyBusinessUnitFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findDefaultBusinessUnitByCompanyId')
            ->with($this->idCompany)
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyUserCompanyAssignerToCompanyBusinessUnitFacadeBridge->findDefaultBusinessUnitByCompanyId(
                $this->idCompany
            )
        );
    }
}
