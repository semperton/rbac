<?php

declare(strict_types=1);

namespace Semperton\Rbac;

class Role implements RoleInterface
{
	protected $permissions = [];

	/** @var string */
	protected $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function addPermission(string $name): self
	{
		$this->permissions[$name] = true;
		return $this;
	}

	public function hasPermission(string $name): bool
	{
		return isset($this->permissions[$name]);
	}

	/**
	 * @return string[]
	 */
	public function getPermissions(): array
	{
		return array_keys($this->permissions);
	}
}
