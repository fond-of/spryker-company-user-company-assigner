<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class CompanyUserCompanyAssignerDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider
     */
    protected $companyUserCompanyAssignerDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserCompanyAssignerDependencyProvider = new CompanyUserCompanyAssignerDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserCompanyAssignerDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testProvidePersistenceLayerDependencies(): void
    {
        $this->assertInstanceOf(
            Container::class,
            $this->companyUserCompanyAssignerDependencyProvider->providePersistenceLayerDependencies(
                $this->containerMock,
            ),
        );
    }
}
