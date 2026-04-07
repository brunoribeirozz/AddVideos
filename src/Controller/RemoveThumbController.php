<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessage;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class RemoveThumbController implements RequestHandlerInterface
{
    use FlashMessage;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $this->addErroMessage('ID inválido');
            return new Response(302, ['Location' => '/']);
        }

        $video = $this->videoRepository->find($id);


        if ($video === null) {
            $this->addErroMessage('Vídeo não encontrado');
            return new Response(302, ['Location' => '/']);
        }

        $filePath = $video->getFilePath();
        $absolutePath = __DIR__ . '/../../public/img/uploads/' . $filePath;

        if ($filePath !== null && file_exists($absolutePath)) {
            unlink($absolutePath);
        }

        $video->setFilePath(null);
        $this->videoRepository->update($video);


        return new Response(302, ['Location' => '/?sucesso=1']);
    }

}
