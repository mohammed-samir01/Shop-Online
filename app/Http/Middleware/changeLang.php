<?php

namespace App\Http\Middleware;
use App\Http\traits\generalTrait;
use Closure;

class changeLang
{
    use generalTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('lang')){
            $lang = $request->header('lang');
            if($lang == 'en'){
                app()->setLocale('en');
                return $next($request);

            }elseif($lang == 'ar'){
                app()->setLocale('ar');
                return $next($request);

            }else{
               return $this->returnError(400,'language is not supported');
            }
        }else{
            return $this->returnError(400,'You must send language');

        }
    }
}
