<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
//use App\Models\Subscription;
use App\Models\User;
use Auth;
use App\Models\Common;
use App\Models\Settings;
use Session;

class JwtMiddleware extends BaseMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //$request->headers->set('Authorization', 'Bearer '.$request->session()->get('xxx'));

        try {
            $user = JWTAuth::parseToken()->authenticate();
            $this->uu_id = $request->header('uuid');
            if (empty($user)) {
                return response()->json(['message' => 'please login now'], 401);
            }

            $recordUser = User::find(Auth::User()->id);

            if ($recordUser->status == 'inactive') {
                $log = [
                    'URI' => $request->getUri(),
                    'METHOD' => $request->getMethod(),
                    'REQUEST_BODY' => $request->all(),
                    'JWT_TTL' => env('JWT_TTL')
                ];
                \Log::info("1" . json_encode($log));

                Auth::logout();
                return response()->json(['message' => 'Your account has been De-Activated by Fans Play Louder Administrator please contact to support team'], 401);
            }
//            if ($this->uu_id != $user->uu_id) {
//                $token = $request->header('Authorization');
//                JWTAuth::parseToken()->invalidate($token);
//                $change_token = User::find(Auth::User()->id);
//                $change_token->device_token = NULL;
//                $change_token->save();
//                return response()->json(['message' => 'Session expired'], 401);
//            }
        } catch (Exception $e) {

            $authorization = $request->header('authorization');

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $log = [
                    'URI' => $request->getUri(),
                    'METHOD' => $request->getMethod(),
                    'REQUEST_BODY' => $request->all(),
                    'exception_msg' => $e->getMessage(),
                    'Header_authorization' => $authorization,
                    'JWT_TTL' => env('JWT_TTL')
                ];
                \Log::info("2" . json_encode($log));

                return response()->json(['message' => 'Token is Invalid'], 401);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $log = [
                    'URI' => $request->getUri(),
                    'METHOD' => $request->getMethod(),
                    'REQUEST_BODY' => $request->all(),
                    'exception_msg' => $e->getMessage(),
                    'Header_authorization' => $authorization,
                    'JWT_TTL' => env('JWT_TTL')
                ];
                \Log::info("3" . json_encode($log));

                return response()->json(['message' => 'Token is Expired'], 401);
            } else {
                $log = [
                    'URI' => $request->getUri(),
                    'METHOD' => $request->getMethod(),
                    'REQUEST_BODY' => $request->all(),
                    'exception_msg' => $e->getMessage(),
                    'Header_authorization' => $authorization,
                    'JWT_TTL' => env('JWT_TTL')
                ];
                \Log::info("4" . json_encode($log));

                return response()->json(['message' => $e->getMessage()], 401);
                //return response()->json(['status'=>401,'message' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }

}
