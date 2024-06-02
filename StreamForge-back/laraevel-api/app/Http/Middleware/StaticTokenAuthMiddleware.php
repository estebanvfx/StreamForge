<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticTokenAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $static_token = 'vDynxU!fan-5=[:RU=CBaYbJ$9wZ}!!%gUz@-D]1(cnj)3-FeeuuHVh-tu+a2,HX}RC6xe)xengu%gdN.]QnqX7Sg{-NbZ6:Fe3VUzt4QX5R=}iL=CkrE_d{WmhHQ5+]wPrvi!6C&S6r11G!-Wm/A0_:XpKXrz1k-Gv.+=Pe(THk6jH}j(/5cCj-7(wz8+cxhjHcZh6@uMh1x?mP/:h.JnNMv{4(9WWEBdgGASTF{k{yw(MUb.L6)E$cH.[+GY]G(WQWvAnAAqv]E8_x4DAH)B!X#8:ei{6QD%W/p.)K';

        $token = $request->header('Authorization');

        if($token !==  $static_token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
