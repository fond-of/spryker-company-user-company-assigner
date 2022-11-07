<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository;
use Spryker\Zed\Kernel\Container;

class CompanyUserCompanyAssignerBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory
     */
    protected $companyUserCompanyAssignerBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepository
     */
    protected $companyUserCompanyAssignerRepositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig
     */
    protected $companyUserCompanyAssignerConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyUserFacadeInterface
     */
    protected $companyUserFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyFacadeInterface
     */
    protected $companyFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerConfigMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerRepositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserFacadeInterfaceMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyUserFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyFacadeInterfaceMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeInterfaceMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeInterfaceMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitFacadeInterfaceMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyBusinessUnitFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerBusinessFactory = new CompanyUserCompanyAssignerBusinessFactory();
        $this->companyUserCompanyAssignerBusinessFactory->setRepository($this->companyUserCompanyAssignerRepositoryMock);
        $this->companyUserCompanyAssignerBusinessFactory->setConfig($this->companyUserCompanyAssignerConfigMock);
        $this->companyUserCompanyAssignerBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyUser(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_USER],
                [CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY],
                [CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_TYPE],
                [CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_ROLE],
                [CompanyUserCompanyAssignerDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT],
            )->willReturnOnConsecutiveCalls(
                $this->companyUserFacadeInterfaceMock,
                $this->companyFacadeInterfaceMock,
                $this->companyTypeFacadeInterfaceMock,
                $this->companyRoleFacadeInterfaceMock,
                $this->companyBusinessUnitFacadeInterfaceMock,
            );

        $this->assertInstanceOf(
            CompanyUser::class,
            $this->companyUserCompanyAssignerBusinessFactory->createCompanyUser(),
        );
    }
}
