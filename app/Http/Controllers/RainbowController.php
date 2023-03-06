<?php

namespace App\Http\Controllers;

use App\Service\Rainbow;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redis;

class RainbowController extends BaseController
{
    public function __invoke()
    {
        if (!request()->has('encrypted')) {
            return response('No encrypted string given', 400);
        }
        if (!request()->has('plaintext')) {
            return response('No plaintext string given', 400);
        }

        $key = Rainbow::encodeKey(request('plaintext'), request('encrypted'));

        $settingsForKey = Redis::smembers($key);

        if (empty($settingsForKey)) {
            return response('Nothing found in rainbow table.', 404);
        }

        return $settingsForKey;
    }
}
