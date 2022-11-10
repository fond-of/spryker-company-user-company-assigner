<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\AssignManufacturerUserToNonManufacturerCompaniesListener;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyUserCompanyAssignerEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
 /**
  * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
  *
  * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
  */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        return $eventCollection->addListenerQueued(
            CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
            new AssignManufacturerUserToNonManufacturerCompaniesListener(),
        );
    }
}