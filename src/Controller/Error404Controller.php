<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

 use Nyholm\Psr7\Response;
 use Psr\Http\Message\ResponseInterface;
 use Psr\Http\Message\ServerRequestInterface;
 use Psr\Http\Server\RequestHandlerInterface;

 class Error404Controller implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(404);
    }
}

// bem minimalista, ta certo, porem teria de rederizar um template de erro,
// do jeito que tá vai só deixar a pag em branco e sinalizar o erro na url //
