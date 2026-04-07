<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Helper\FlashMessage;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->addErroMessage('ID inválido');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $requestBody = $request->getParsedBody();
        $url = filter_var($requestBody['url'], FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErroMessage('URL inválida');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
        $titulo = filter_var($requestBody['titulo']);
        if ($titulo === false) {
            $this->addErroMessage('Título não informado');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->update($video);

        if ($success === false) {
            $this->addErroMessage('Erro ao atualizar o vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(302, [
            'Location' => '/'
        ]);
    }
}

/** PONTOS IMPORTANTES


o getQueryParams vai pegar o id que vem na url, sendo a forma que a PSR-7 ve o $_GET

o getParsedBody faz praticamente a função de um $_POST, por ele pegar os dados enviados pelo form

os filtros ou filter_var (FILTER_VALIDATE_URL, FILTER_VALIDATE_INT) vai redirecionar o usuario caso tenha digitado algo errado

o getUploadedFiles faz com que o $_FIlES vire um objeto

pra seguranca foi usado o $finfo que checa o mimetype, o que evita de um ataque via arquivo disfarçado

o menos importante é a trait de mensagem de erro, que é uma flash message, que aparece sempre que tem algum erro
seja com url errada, nome ou formato de imagem **/



