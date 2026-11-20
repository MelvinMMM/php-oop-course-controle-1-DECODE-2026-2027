<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class OneContactForms extends AbstractController
{
    public function process(Request $request): Response
    {
        $response = new Response();

        $uri = $request->getUri();
        $basenameUri = basename($uri);

        $newPathForVar = __DIR__ . '/../../var/contacts';
        $pathUri = $newPathForVar . "/" . $basenameUri;

        if (!file_exists($pathUri)) {
            $response->statusCode = 404;
            $response->content = "Le fichier n'existe pas";
            return $response;
        }
        $response->statusCode = 200;
        $response->content = file_get_contents($pathUri);

        return $response;
    }
}
