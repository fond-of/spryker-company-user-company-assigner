<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyUserCompanyAssignerToCompanyTypeFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Client\CompanyUserCompanyAssignerToCompanyTypeFacadeBridge
     */
    protected $companyUserCompanyAssignerToCompanyTypeFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeInterfaceMock;

    /**
     * @var int
     */
    protected $idCompanyType;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeTransfer
     */
    protected $companyTypeTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    protected $companyTypeCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyCollectionTransfer
     */
    protected $companyCollectionTransferMock;

    /**
     * @var string
     */
    protected $manufacturerName;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTypeFacadeInterfaceMock = $this->getMockBuilder(CompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyType = 1;

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeCollectionTransferMock = $this->getMockBuilder(CompanyTypeCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyCollectionTransferMock = $this->getMockBuilder(CompanyCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->manufacturerName = 'manufacturer-name';

        $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge = new CompanyUserCompanyAssignerToCompanyTypeFacadeBridge(
            $this->companyTypeFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindCompanyTypeById(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompanyTypeById')
            ->with($this->idCompanyType)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertInstanceOf(
            CompanyTypeTransfer::class,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->findCompanyTypeById(
                $this->idCompanyType
            )
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypes(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyTypes')
            ->willReturn($this->companyTypeCollectionTransferMock);

        $this->assertInstanceOf(
            CompanyTypeCollectionTransfer::class,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->getCompanyTypes()
        );
    }

    /**
     * @return void
     */
    public function testFindCompaniesByCompanyTypeIds(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findCompaniesByCompanyTypeIds')
            ->willReturn($this->companyCollectionTransferMock);

        $this->assertInstanceOf(
            CompanyCollectionTransfer::class,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->findCompaniesByCompanyTypeIds(
                $this->companyTypeCollectionTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeManufacturerName(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeManufacturerName')
            ->willReturn($this->manufacturerName);

        $this->assertSame(
            $this->manufacturerName,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->getCompanyTypeManufacturerName()
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeByName(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeByName')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertInstanceOf(
            CompanyTypeTransfer::class,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->getCompanyTypeByName(
                $this->companyTypeTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testGetCompanyTypeById(): void
    {
        $this->companyTypeFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getCompanyTypeById')
            ->with($this->companyTypeTransferMock)
            ->willReturn($this->companyTypeTransferMock);

        $this->assertInstanceOf(
            CompanyTypeTransfer::class,
            $this->companyUserCompanyAssignerToCompanyTypeFacadeBridge->getCompanyTypeById(
                $this->companyTypeTransferMock
            )
        );
    }
}
