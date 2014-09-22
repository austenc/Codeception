<?php
namespace Codeception\Lib\Connector;

use Illuminate\Foundation\Testing\Client;

class Laravel4 extends Client
{

    protected function doRequest($request)
    {
        // boots the framework or does nothing if booted already
	$this->kernel->boot();

	// ensure full http headers even when requests are made from CLI
	$this->kernel->setRequestForConsoleEnvironment();

        $headers = $request->headers;

        $response = parent::doRequest($request);

        // saving referer for redirecting back
        if (!$this->getHistory()->isEmpty()) {
            $headers->set('referer', $this->getHistory()->current()->getUri());
        }
        return $response;
    }
}
