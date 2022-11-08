<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserCompanyAssignerCompanyUserPostCreatePluginInterfaceTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerFacade
     */
    protected $facadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    protected $companyUserResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyUserTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\CompanyUserExtension\CompanyUserCompanyAssignerCompanyUserPostCreatePlugin
     */
    protected $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserResponseTransferMock = $this->getMockBuilder(CompanyUserResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyUserCompanyAssignerCompanyUserPostCreatePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostCreate(): void
    {
        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getIsSuccessful')
            ->willReturn(true);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('assignManufacturerUserNonManufacturerCompanies')
            ->with($this->companyUserTransferMock);

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postCreate(
                $this->companyUserResponseTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testPostCreateWithoutCompanyUser(): void
    {
        $this->companyUserResponseTransferMock->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn(null);

        $this->companyUserResponseTransferMock->expects(static::never())
            ->method('getIsSuccessful');

        $this->facadeMock->expects(static::never())
            ->method('assignManufacturerUserNonManufacturerCompanies');

        static::assertEquals(
            $this->companyUserResponseTransferMock,
            $this->plugin->postCreate(
                $this->companyUserResponseTransferMock,
            ),
        );
    }
}
