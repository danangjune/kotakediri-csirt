<?php

namespace App\Exceptions;

//use Exception;
use Throwable;
use App\ContentPolicy;
use Spatie\Csp\Keyword;
use Spatie\Csp\Directive;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     //
        // });

        $this->renderable(function (Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                return redirect()->back();
            }
        });

        $this->renderable(function (Exception $e) {        
            if ($e instanceof AccessDeniedHttpException) {
                return redirect()->back();
            }
        });

        $this->renderable(function (Exception $e) {
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return redirect()->route('login');
            };
        });


        
    }

    public function render($request, Throwable $e)
    {
        $this->container->singleton(ContentPolicy::class, function ($app) {
            return new ContentPolicy();
        });
        app(ContentPolicy::class)->addDirective(Directive::SCRIPT, Keyword::UNSAFE_INLINE);
        
        abort_if ($e instanceof MethodNotAllowedHttpException, 404);
        return parent::render($request, $e);
    }

}
