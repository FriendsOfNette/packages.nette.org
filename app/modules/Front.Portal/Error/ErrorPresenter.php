<?php declare(strict_types = 1);

namespace App\Modules\Front\Portal\Error;

use App\Modules\Front\Portal\Base\BasePresenter;
use Nette\Application\BadRequestException;
use Throwable;
use Tracy\ILogger;

final class ErrorPresenter extends BasePresenter
{

	/** @var ILogger @inject */
	public $logger;

	public function renderDefault(Throwable $exception): void
	{
		if ($exception instanceof BadRequestException) {
			$code = $exception->getCode();
			// load template 403.latte or 404.latte or ... 4xx.latte
			$this->setView((string) (in_array($code, [403, 404, 405, 410, 500]) ? $code : '4xx'));
			// log to access.log
			$this->logger->log(sprintf(
				'HTTP code %s: %s in %s:%s',
				$code,
				$exception->getMessage(),
				$exception->getFile(),
				$exception->getLine()
			), 'access');
		} else {
			$this->setView('500'); // load template 500.latte
			$this->logger->log($exception, ILogger::EXCEPTION); // and log exception
		}

		if ($this->isAjax()) { // AJAX request? Note this error in payload.
			$this->payload->error = true;
			$this->terminate();
		}
	}

}
