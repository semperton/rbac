<?php

declare(strict_types=1);

namespace Semperton\Rbac;

class Rbac
{
	protected $roles = [];

	public function addRole(RoleInterface $role): self
	{
		$name = $role->getName();

		$this->roles[$name] = $role;

		return $this;
	}

	public function addNewRole(string $name): self
	{
		$this->roles[$name] = new Role($name);

		return $this;
	}

	public function getRole(string $name): ?RoleInterface
	{
		if (isset($this->roles[$name])) {
			return $this->roles[$name];
		}

		return null;
	}

	public function hasRole(string $name): bool
	{
		return isset($this->roles[$name]);
	}

	public function getRoles(): array
	{
		return array_values($this->roles);
	}

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
