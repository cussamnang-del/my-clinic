<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LanguageSwitcher
{
  public function handle(Request $request, Closure $next)
  {
    if(\Session::has('locale')){
      \App::setLocale(\Session::get('locale'));
      //The default Language in Config/App.php is English
    }
    return $next($request);
  }
}
