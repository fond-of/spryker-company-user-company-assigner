<?php

namespace FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyRoleTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyUser
     */
    protected $companyUser;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\CompanyUserCompanyAssignerConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface
     */
    protected $repositoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyUserCompanyAssigner\Business\Model\CompanyRoleInterface
     */
    protected $companyRole;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject|
     */
    protected $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTypeTransfer|\PHPUnit\Framework\MockObject\MockObject|
     */
    protected $companyTypeTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleCollectionTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyRoleTransfer|\PHPUnit\Framework\MockObject\MockObject|
     */
    protected $companyRoleTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->configMock = $this->getMockBuilder(CompanyUserCompanyAssignerConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleCollectionTransferMock = $this->getMockBuilder(CompanyRoleCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeTransferMock = $this->getMockBuilder(CompanyTypeTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeFacadeMock = $this->getMockBuilder(CompanyUserCompanyAssignerToCompanyTypeFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(CompanyUserCompanyAssignerRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRole = new CompanyRole(
            $this->companyRoleFacadeMock,
            $this->companyTypeFacadeMock,
            $this->configMock,
            $this->repositoryMock,
        );
    }

    /**
     * @return void
     */
    public function testUpdateNonManufacturerUsersCompanyRole(): void
    {
        $companyRoles = new ArrayObject();
        $companyRoles->append($this->companyRoleTransferMock);

        $companyUsers = [
            '1' => [
                'id_company_user' => 1,
                'id_company' => 1,
                'company_roles' => [],
            ],
        ];

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getRoles')
            ->willReturn($companyRoles);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleById')
            ->with($this->companyRoleTransferMock)
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('fromArray')
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollection')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->configMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyTypeRoleMapping')
            ->willReturn([]);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getName')
            ->willReturnOnConsecutiveCalls(
                '',
                'company-role',
                'company-role',
                'company-role',
                'company-role',
                'company-role',
            );

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('findManufacturerCompanyIdsByCustomerId')
            ->willReturn([1]);

        $this->companyUserTransferMock->expects($this->atLeastOnce())
            ->method('getFkCustomer')
            ->willReturn(1);

        $this->companyTypeFacadeMock->expects($this->atLeastOnce())
            ->method('getManufacturerCompanyType')
            ->willReturn($this->companyTypeTransferMock);

        $this->companyTypeTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyType')
            ->willReturn(1);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('findCompanyUserswithDiffCompanyRolesAsManufacturer')
            ->willReturn($companyUsers);

        $this->repositoryMock->expects($this->atLeastOnce())
            ->method('getCompanyRoleCollectionByCompanyId')
            ->willReturn($this->companyRoleCollectionTransferMock);

        $this->companyRoleTransferMock->expects($this->atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(1);

        $this->companyRoleFacadeMock->expects($this->atLeastOnce())
            ->method('saveCompanyUser');

        $this->companyRole->updateNonManufacturerUsersCompanyRole($this->companyUserTransferMock);
    }
}
