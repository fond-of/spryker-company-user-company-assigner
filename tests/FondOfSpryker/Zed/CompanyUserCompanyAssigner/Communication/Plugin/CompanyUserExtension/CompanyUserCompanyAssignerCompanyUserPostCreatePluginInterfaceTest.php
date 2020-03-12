<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;

class CompanyUserCompanyAssignerCompanyUserPostCreatePluginInterfaceTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension\CompanyUserCompanyAssignerCompanyUserPostCreatePluginInterface
     */
    protected $companyUserCompanyAssignerCompanyUserPostCreatePluginInterface;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $companyUserCompanyAssignerFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyUserCompanyAssignerFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerCompanyUserPostCreatePluginInterface = new CompanyUserCompanyAssignerCompanyUserPostCreatePluginInterface();
        $this->companyUserCompanyAssignerCompanyUserPostCreatePluginInterface->setFacade($this->companyUserCompanyAssignerFacadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->companyUserCompanyAssignerFacadeMock->expects($this->atLeastOnce())
            ->method('addManufacturerUserToCompanies')
            ->with($this->companyUserResponseTransferMock)
            ->willReturn($this->companyUserResponseTransferMock);

        $this->assertInstanceOf(
            CompanyUserResponseTransfer::class,
            $this->companyUserCompanyAssignerCompanyUserPostCreatePluginInterface->postCreate(
                $this->companyUserResponseTransferMock
            )
        );
    }
}
