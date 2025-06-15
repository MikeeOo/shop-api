<?php

return [
	// The root JSON:API namespace for new servers and filters.
	'namespace' => 'JsonApi', // use App\JsonApi\[whatever];

	//  A list of JSON:API compliant APIs, referred to as "servers".
	'servers' => [
		'v1' => \App\JsonApi\V1\Server::class, // 'unique-name' => \App\JsonApi\['unique-name']\Server::class,
	],
];
