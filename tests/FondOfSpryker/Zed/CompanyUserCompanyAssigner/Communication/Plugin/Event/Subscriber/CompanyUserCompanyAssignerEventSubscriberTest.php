<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\AssignManufacturerUserToNonManufacturerCompaniesListener;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class CompanyUserCompanyAssignerEventSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventCollectionMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber\CompanyUserCompanyAssignerEventSubscriber
     */
    protected $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new CompanyUserCompanyAssignerEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock->expects(static::atLeastOnce())
            ->method('addListenerQueued')
            ->with(
                CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
                static::callback(
                    static function(EventBaseHandlerInterface $eventBaseHandler) {
                        return $eventBaseHandler instanceof AssignManufacturerUserToNonManufacturerCompaniesListener;
                    }
                ),
                0,
                null,
                null
            )->willReturn($this->eventCollectionMock);

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock)
        );
    }
}
