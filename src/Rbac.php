<?php

declare(strict_types=1);

namespace Semperton\Rbac;

use Semperton\Rbac\Exception\NotFoundException;

class Rbac
{
	protected $roles = [];

	public function addRole(RoleInterface $role): self
	{
		$name = $role->getName();

		$this->roles[$name] = $role;

		return $this;
	}

	public function addNewRole(string $name): RoleInterface
	{
		$role = new Role($name);

		$this->roles[$name] = $role;

		return $role;
	}

	public function getRole(string $name): RoleInterface
	{
		if (!isset($this->roles[$name])) {
			throw new NotFoundException("The role with name < $name > is missing");
		}

		return $this->roles[$name];
	}

	public function hasRole(string $name): bool
	{
		return isset($this->roles[$name]);
	}

	/**
	 * @return RoleInterface[]
	 */
	public function getRoles(): array
	{
		return array_values($this->roles);
	}

	/**
	 * @return string[]
	 */
	public function getRoleNames(): array
	{
		return array_keys($this->roles);
	}

	public function hasPermission(string $name): bool
	{
		/** @var RoleInterface */
		foreach ($this->roles as $role) {
			if ($role->hasPermission($name)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @return string[]
	 */
	public function getPermissions(): array
	{
		$permissions = [];

		/** @var RoleInterface */
		foreach ($this->roles as $role) {
			$permissions = array_merge($permissions, $role->getPermissions());
		}

		return array_unique($permissions);
	}
}
