<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Http\Exceptions\HttpResponseException;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use \Illuminate\Database\QueryException;
use \Illuminate\Session\TokenMismatchException;
use \Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

use App\Helpers\Code;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $exception = $this->prepareException($exception);
        if ($request->is('api/*') || $request->is('oauth/*')) { //针对API特殊处理
            if ($exception instanceof ValidationException) { // 验证失败
                $errors = $exception->errors();
                $msg = array_shift($errors);
                return response()->json(error(422, array_shift($msg), $exception->errors()), 422, [], JSON_UNESCAPED_UNICODE);
            } elseif ($exception instanceof AuthenticationException) { //token验证不通过
                return response()->json(error(401, $exception->getMessage()), 401, [], JSON_UNESCAPED_UNICODE);
            } elseif ($exception instanceof AuthorizationException) { //无权访问
                return response()->json(error(405, $exception->getMessage()), 405, [], JSON_UNESCAPED_UNICODE);
            } elseif ($exception instanceof NotFoundHttpException) { //404
                return response()->json(error(404, $exception->getMessage()), 404, [], JSON_UNESCAPED_UNICODE);
            } else {
                return response()->json(error($exception->getCode(), $exception->getMessage()),400, [], JSON_UNESCAPED_UNICODE);
            }
        }
        if ($request->expectsJson() || config('app.env') == 'local') { //ajax请求或者本地环境
            if (($exception instanceof HttpResponseException || $exception instanceof HttpException) && $exception->getStatusCode() == Code::DISALLOW) { //重写403错误
                return response()->json(error(Code::DISALLOW, $exception->getMessage(), $exception->getMessage()), Code::DISALLOW, [], JSON_UNESCAPED_UNICODE);
            }
            if ($exception instanceof QueryException && config('app.debug') == false) { //数据库query异常
                return response()->json(error(Code::QUERYEXCEPTION), Code::SUCCESS, [], JSON_UNESCAPED_UNICODE);
            }
            if ($exception instanceof TokenMismatchException) { //crsf 验证失败
                return response()->json(error(Code::TOKENMISMATCH), Code::SUCCESS, [], JSON_UNESCAPED_UNICODE);
            }
            if ($exception instanceof ValidationException) { // 验证失败
                $errors = $exception->errors();
                $msg = array_shift($errors);
                return response()->json(error($exception->getCode(), array_shift($msg), $exception->errors()), 422, [], JSON_UNESCAPED_UNICODE);
            }
        }
        return parent::render($request, $exception);
    }
}
