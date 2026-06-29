<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;

class HealthController extends BaseApiController
{
    public function __invoke()
    {
        return $this->success(
            [
                'app' => config('app.name'),
                'version' => '1.0.0',
                'environment' => app()->environment(),
                'php_version' => PHP_VERSION,
            ],
            'Application is healthy',
        );
    }
}