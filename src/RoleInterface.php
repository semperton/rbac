<?php

declare(strict_types=1);

namespace Semperton\Rbac;

interface RoleInterface
{
	public function getName(): string;
	public function addPermission(string $name);
	public function hasPermission(string $name): bool;
	public function getPermissions(): array;
}
