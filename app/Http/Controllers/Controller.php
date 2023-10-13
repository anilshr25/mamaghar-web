<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="My First API Documentation",
 *     version="0.1",
 *      @OA\Contact(
 *          email="info@yeagger.com"
 *      ),
 * ),
 *  @OA\Server(
 *      description="Learning env",
 *      url="https://foo.localhost:8000/api/"
 * ),
 *    @OA\Get(
 *      path="/profiles",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *      ),
 *     @OA\PathItem (
 *   ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
