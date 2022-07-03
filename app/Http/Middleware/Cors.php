<?php

namespace App\Http\Middleware;

use Closure;
use function header;
use function request;
use function response;

class Cors {
    public function handle($request, Closure $next) {
        $origin = request()->header('origin') ?? '*';
        header('Access-Control-Max-Age: 999999', true);
        header('Access-Control-Allow-Credentials: true', true);
        header('Access-Control-Allow-Origin: '.$origin, true);
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS', true);
        header('Access-Control-Allow-Headers: Shop-Namespace, meta, shop-namespace, Origin, Content-Type, Authorization, Content-Length, X-Requested-With, Host, Accept-Encoding, Referer, Accept, Content-Disposition, Content-Range, Content-Disposition, Content-Description, X-CSRF-TOKEN, X-Requested-With, content-type, authorization, x-requested-with, x-xsrf-token, Shop-Domain', true);

        if ($request->isMethod('OPTIONS')) {
            return response('OK', 200);
        }

        return $next($request);
    }
}
