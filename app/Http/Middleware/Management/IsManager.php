<?php

namespace App\Http\Middleware\Management;

use App\Http\Middleware\Concerns\ChecksContributorAccess;
use Closure;
use Illuminate\Http\Request;

class IsManager
{
    use ChecksContributorAccess;

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $this->allowContributorWithRoles($request, $next, [6], allowMultipleRoles: true);
    }
}
