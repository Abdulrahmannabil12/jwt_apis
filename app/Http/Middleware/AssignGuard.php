<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AssignGuard extends BaseMiddleware
{
    use GeneralTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard != null) {
            auth()->shouldUse($guard); //shoud you user guard / table
            $token = $request->header('auth-token');
            $request->headers->set('auth-token', (string)$token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            try {
                $user = JWTAuth::parseToken( )->authenticate( );
                //check authenticted user
            } catch (Exception $exception) {
               if ($exception instanceof TokenExpiredException) {
                    return response()->json(['status' => 'Token is Expired']);
                }  elseif ($exception instanceof TokenInvalidException) {
                    return response()->json(['status' => 'Token is Invalid']);
                }  else if ($exception instanceof UnauthorizedHttpException || $exception instanceof TokenBlacklistedException) {
                    return response()->json(['status' => 'The token has been blacklisted']);
                }
            }
            catch (\Throwable $exception){
                if ($exception instanceof TokenExpiredException) {
                    return response()->json(['status' => 'Token is Expired']);
                }  elseif ($exception instanceof TokenInvalidException) {
                    return response()->json(['status' => 'Token is Invalid']);
                }  else if ($exception instanceof UnauthorizedHttpException || $exception instanceof TokenBlacklistedException) {
                    return response()->json(['status' => 'The token has been blacklisted']);
                }
            }
            if (!$token) {
                return $this->returnError('200',trans('unauthenticated'));


            }
            return $next($request);
        }
    }
}
