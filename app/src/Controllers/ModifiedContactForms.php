<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ModifiedContactForms extends AbstractController
{
    public function process(Request $request): Response
    {
        $response = new Response();
        $uri = basename($request->getUri());
        $pathToContact = __DIR__ . '/../../var/contacts/' . $uri;


        $dataJSON = file_get_contents('php://input');
        $data = json_decode($dataJSON, true);
        if (!is_array($data)) {
            $response->statusCode = 400;
            $response->content = 'Le format JSON est invalide';
            return $response;
        }


        if (isset($data[''])) {
            $response->statusCode = 400;
            $response->content = "Vos données sont vides";
        }


        $obligatoryKeys = ['email', 'subject', 'message'];
        $nameKeys = array_keys($data);

        foreach ($obligatoryKeys as $key) {
            if (!in_array($key, $nameKeys)) {
                $response->statusCode = 400;
                $response->content = "Le champ '$key' n'existe pas dans vos données";
                return $response;
            }
        }
        $contentFile = json_decode(file_get_contents($pathToContact), true);

        var_dump($contentFile);
        foreach ($nameKeys as $key) {
            $contentFile[$key] = $data[$key];
        }
        $contentFile['dateOfLastUpdate'] = time();

        file_put_contents($pathToContact, json_encode($contentFile, JSON_ERROR_DEPTH));

        $response->statusCode = 200;
        $response->content = "Le fichier a été modifié avec succès";
        return $response;



        // $newPathForVar = __DIR__ . '/../../var/contacts';
        // $pathUri = $newPathForVar . "/" . $basenameUri;

        // if (!file_exists($pathUri)) {
        //     $response->statusCode = 404;
        //     $response->content = "Le fichier n'existe pas";
        //     return $response;
        // }


        $response->statusCode = 200;
        $response->content = "fcou";

        return $response;
    }
}
