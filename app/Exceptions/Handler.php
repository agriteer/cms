<?php

namespace App\Exceptions;

use Throwable;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        switch($exception) {
            case ($exception instanceof QueryException):

                return back()->with('error', $exception->getMessage());
                break;

            case ($exception instanceof InvalidLoginException):

                return response()->json(['type' => 'error', 'message' => 'Invalid Username or Password provided', 'data' => 'null']);
                break;
            
            case ($exception instanceof TokenInvalidException):
                return response()->json([
                            'data' => null,
                            'status' => false,
                            'err_' => [
                                'message' => 'Token Invalid',
                                'code' => 1
                            ]
                        ]);
                break;
            
            case ($exception instanceof TokenBlacklistedException):
                return response()->json([
                            'data' => null,
                            'status' => false,
                            'err_' => [
                                'message' => 'Token Blacklisted',
                                'code' => 1
                            ]
                        ]);
                break;
        
                case ($exception instanceof TokenExpiredException):
                    return response()->json([
                                'data' => null,
                                'status' => false,
                                'err_' => [
                                    'message' => 'Token Expired',
                                    'code' => 1
                                ]
                            ]);
                    break;
            case ($exception->getMessage() === 'Token not provided'):
                return response()->json([
                            'data' => null,
                            'status' => false,
                            'err_' => [
                                'message' => 'Token not provided',
                                'code' => 1
                            ]
                        ]);
                break;
            case ($exception->getMessage() === 'User not found'):
                return response()->json([
                            'data' => null,
                            'status' => false,
                            'err_' => [
                                'message' => 'User Not Found',
                                'code' => 1
                            ]
                        ]);
                break;
            default:

                return parent::render($request, $exception);
        }
    }
}
