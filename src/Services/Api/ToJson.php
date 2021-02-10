<?php

namespace App\Services\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ToJson extends JsonResponse
{
    /**
     * Retourne une réponse JSON (HTTP OK par défaut)
     * Type de réponse : HTTP_OK, HTTP_BAD_REQUEST, HTTP_CREATED, HTTP_UNAUTHORIZED, HTTP_FORBIDDEN, HTTP_NOT_FOUND, etc...
     * @param $message
     * @param Request $request
     * @param array $params
     * @param bool $isJson
     * @param int $responseType
     * @return JsonResponse
     */
    public function setAndSendResponse(Array $message, Request $request, Array $params = [], $isJson = true, $responseType = Response::HTTP_OK): JsonResponse
    {
        $response = new JsonResponse($message, $responseType, $params, $isJson);

        if ( !array_key_exists("success", $message) || !array_key_exists("statusCode", $message)) {
            $response->setData(["success" => false, "statusCode" => 400]);
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            return $response;
        }

        if ($request->getMethod() === "OPTIONS") {
            $response->headers->set("Access-Control-Allow-Headers", "Accept, Content-Type");
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}