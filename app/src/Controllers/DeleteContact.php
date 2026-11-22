<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class DeleteContact extends AbstractController
{
    public function process(Request $request): Response
    {
        $response = new Response();
        $uri = basename($request->getUri());
        $pathToFileContact = __DIR__ . '/../../var/contacts/' . $uri;

        if (!file_exists($pathToFileContact)) {
            $response->statusCode = 404;
            $response->content = "Le fichier n'existe pas";
            return $response;
        }

        unlink($pathToFileContact);


        $response->statusCode = 204;
        $response->content = "Le fichier a été supprimé avec succès";
        return $response;
    }
}
