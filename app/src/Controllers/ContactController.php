<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        $response = new Response();
        if ($request->getMethod() !== "POST") {
            $response->statusCode = 405;
            $response->content = "La méthode reçu n'est pas la méthode attendue";
            return $response;
        }

        $dataJSON = file_get_contents('php://input');
        $data = json_decode($dataJSON, true);
        if (!is_array($data)) {
            $response->statusCode = 400;
            $response->content = 'Le format JSON est invalide';
            return $response;
        }

        $obligatoryKeys = ['email', 'subject', 'message'];
        $nameKeys = array_keys($data);

        if ($obligatoryKeys !== $nameKeys) {
            $response->statusCode = 400;
            $response->content = "Tout les champs n'ont pas été rempli";
            return $response;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $response->statusCode = 400;
            $response->content = "Le mail n'est pas valide";
            return $response;
        }

        $newPathForContact = __DIR__ . '/../../var/contacts';
        if (!is_dir($newPathForContact)) {
            mkdir($newPathForContact, 0777, true);
        }

        $timestamp = time();

        $nameFile = $timestamp . "_" . $data["email"] . ".json";

        $newData = ['email' => $data['email'], 'subject' => $data['subject'], 'message' => $data['message'], 'dateOfCreation' => $timestamp, 'dateOfLastUpdate' => $timestamp];

        $finalPath = $newPathForContact . "/" . $nameFile;



        $response->statusCode = 201;
        $response->content = 'success';
        return $response;
    }
}
