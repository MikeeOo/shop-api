<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	protected $token;

	public function __construct($resource, $token = null)
	{
		parent::__construct($resource);
		$this->token = $token;
	}

	public function toArray(Request $request): array
	{
		return [
			'type' => 'users',
			'id' => (string) $this->id,
			'attributes' => [
				'first_name' => $this->first_name,
				'last_name' => $this->last_name,
				'email' => $this->email,
				// 'is_admin' => $this->when($this->is_admin, $this->is_admin),
				// 'email_verified_at' => $this->when($this->email_verified_at, $this->email_verified_at),
				'created_at' => $this->created_at->toIso8601String(),
				'updated_at' => $this->updated_at->toIso8601String(),
			],
		];
	}

	public function with($request)
	{
		$meta = [
			// 'author' => 'MikeeOo',
			// 'version' => '1.0.0',
		];

		if ($this->token) {
			$meta['token'] = $this->token;
			$meta['token_type'] = 'Bearer';
			$meta['expires_in'] = config('sanctum.expiration') * 60;
		}

		return [
			'meta' => $meta,
		];
	}
}
