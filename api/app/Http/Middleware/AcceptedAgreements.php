<?php

namespace App\Http\Middleware;

use App\Services\TermsService;
use Closure;

class AcceptedAgreements
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ts = new TermsService();
        if(!$request->user() || !$ts->userHasAgreedToAll($request->user())){
            abort(403, 'You have not accepted the latest user agreements.');
        }

        return $next($request);
    }
}
