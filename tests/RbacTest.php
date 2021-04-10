<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Semperton\Rbac\Exception\NotFoundException;
use Semperton\Rbac\Rbac;
use Semperton\Rbac\Role;

final class RbacTest extends TestCase
{
	public function testRoleName()
	{
		$role = new Role('guest');

		$this->assertEquals('guest', $role->getName());
	}

	public function testRolePermissions()
	{
		$role = new Role('guest');
		$role->addPermission('post.read');

		$this->assertTrue($role->hasPermission('post.read'));
		$this->assertFalse($role->hasPermission('post.create'));

		$role->addPermission('post.edit');

		$this->assertSame(['post.read', 'post.edit'], $role->getPermissions());
	}

	public function testRoleNotFound()
	{
		$this->expectException(NotFoundException::class);

		$rbac = new Rbac();
		$rbac->getRole('admin');
	}

	public function testRbac()
	{
		$rbac = new Rbac();

		$adminRole = $rbac->addNewRole('admin');
		$this->assertInstanceOf(Role::class, $adminRole);
		$this->assertTrue($rbac->hasRole('admin'));

		$authorRole = new Role('author');
		$authorRole->addPermission('article.create');

		$adminRole->addPermission('article.delete');

		$rbac->addRole($authorRole);

		$this->assertTrue($rbac->hasPermission('article.create'));
		$this->assertTrue($rbac->hasPermission('article.delete'));
	}
}
