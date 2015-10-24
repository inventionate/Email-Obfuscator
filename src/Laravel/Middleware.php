<?php namespace Propaganistas\EmailObfuscator\Laravel;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\Middleware as MiddlewareContract;

class Middleware implements MiddlewareContract
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Apply logic differently based on the nature of $response.
        if ($response instanceof Renderable) {
            $response = obfuscateEmail($response->render());
        } elseif ($response instanceof Response) {
            $content = obfuscateEmail($response->getContent());
            $response->setContent($content);
        }

        return $response;
    }

}