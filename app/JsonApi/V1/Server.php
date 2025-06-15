<?php

namespace App\JsonApi\V1;

use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{
	// The base URI namespace for this server.
	protected string $baseUri = '/api'; // * '/api/v1'

	// * Bootstrap the server when it is handling an HTTP request.
	public function serving(): void
	{
		// *no-op
	}

	// Server's list of schemas.
	protected function allSchemas(): array
	{
		return [Products\ProductSchema::class];
	}
}
