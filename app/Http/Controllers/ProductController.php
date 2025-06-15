<?php

namespace App\Http\Controllers;

use App\JsonApi\V1\Products\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchMany;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Store;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Update;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\Destroy;

class ProductController extends Controller
{
	use FetchMany, FetchOne, Store, Update, Destroy;
}
