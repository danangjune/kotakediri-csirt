<?php

namespace App;

use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp;
use Symfony\Component\HttpFoundation\Response;

class ContentPolicy extends Policy
{
    public function configure()
    {
        $this
            ->addDirective(Directive::BASE, Keyword::SELF)
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                'data:',
                'blob:'
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                // 'www.google.com',
                // 'www.gstatic.com',
                // 'https://ajax.googleapis.com',
                // 'https://cdn.jsdelivr.net',
                // 'www.cloudfare.com',

            ])
            ->addNonceForDirective(Directive::SCRIPT)
            ->addDirective(Directive::OBJECT, Keyword::SELF);
    }


}