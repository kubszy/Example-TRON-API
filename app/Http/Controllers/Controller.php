<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
      /**
     * @OA\Info(
     *      version="0.0.1",
     *      title="​ Example TRON API",
     *      description="Example TRON API",
     *      @OA\Contact(
     *          email="user@user.com"
     *      )
     * )
     *
     */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
