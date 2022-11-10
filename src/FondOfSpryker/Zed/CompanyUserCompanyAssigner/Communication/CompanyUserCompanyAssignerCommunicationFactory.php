<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Communication;

use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerDependencyProvider;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyUserCompanyAssignerCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeInterface
     */
    public function getEventFacade(): CompanyUserCompanyAssignerToEventFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCompanyAssignerDependencyProvider::FACADE_EVENT);
    }
}
