<?php declare(strict_types = 1);

namespace App\Modules\Front\Portal\Base\Controls\AddonList;

use Nextras\Orm\Collection\ICollection;

interface IAddonListFactory
{

	/**
	 * @phpstan-param ICollection<\App\Model\Database\ORM\Addon\Addon> $addons
	 */
	public function create(ICollection $addons): AddonList;

}
