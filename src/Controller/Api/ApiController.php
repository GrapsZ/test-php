<?php

namespace App\Controller\Api;

use App\Entity\Stage;
use App\Entity\Travel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Api\ToJson;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    /**
     * Fonction qui retourne les données d'un voyage au format json pour être distribué à une requête AJAX.
     * @Route("/api/showtravel/{id}", name="show_travel", methods={"GET"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function showTravelById(int $id, Request $request): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $response = new ToJson();

        $data = [
            "success" => false,
            "statusCode" => Response::HTTP_BAD_REQUEST,
            "message" => "Requête en échec.",
            "data" => []
        ];

        if (isset($id) && !empty($id)) {
            //Recherche si un voyage est trouvé avec cet id
            $travel = $manager->getRepository(Travel::class)->findOneBy(["id" => $id]);
            if ($travel) {
                $stages = [];
                /**
                 * On définit le typage de la variable pour que PhpStorm permette l'autocompletion des méthodes
                 * @var $stage Stage
                 */
                foreach($travel->getTravelStage() as $stage) {
                    $stages[] = [
                        "id" => $stage->getId(),
                        "type" => $stage->getType()->getName(),
                        "departure" => $stage->getDeparture()->getName(),
                        "arrival" => $stage->getArrival()->getName(),
                        "number" => $stage->getNumber(),
                        "departure_date" => $stage->getDepartureDate()->format("Y-m-d H:i:s"),
                        "arrival_date" => $stage->getArrivalDate()->format("Y-m-d H:i:s"),
                        "seat" => $stage->getSeat(),
                        "gate" => $stage->getGate(),
                        "baggage_drop" => $stage->getBaggageDrop(),
                    ];
                }

                $data["message"] = "Voici le voyage sélectionné";
                $data["statusCode"] = Response::HTTP_OK;
                $data["success"] = true;
                $data["data"] = [
                    "id" => $travel->getId(),
                    "name" => $travel->getName(),
                    "price" => $travel->getPrice(),
                    "is_active" => ($travel->getIsActive()) ? true : false,
                    "stages" => $stages,
                ];

            }
        }

        return $response->setAndSendResponse($data, $request, [], false, $data["statusCode"]);
    }

    /**
     * Route qui retourne un tableau de toutes les étapes au format JSON
     * @Route("/api/showtravels", name="show_travels", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllStages(Request $request): JsonResponse
    {
        $manager = $this->getDoctrine()->getManager();
        $response = new ToJson();

        $data = [
            "success" => true,
            "statusCode" => Response::HTTP_OK,
            "message" => "Aucune étape n'a été trouvée.",
            "data" => []
        ];

        $stages = $manager->getRepository(Stage::class)->findAll();

        if (!empty($stages)) {
            $data["message"] = "Voici la liste des étapes";
            foreach($stages as $stage) {
                $data["data"][] = [
                    "id" => $stage->getId(),
                    "type" => $stage->getType()->getName(),
                    "departure" => $stage->getDeparture()->getName(),
                    "arrival" => $stage->getArrival()->getName(),
                    "number" => $stage->getNumber(),
                    "departure_date" => $stage->getDepartureDate()->format("Y-m-d H:i:s"),
                    "arrival_date" => $stage->getArrivalDate()->format("Y-m-d H:i:s"),
                    "seat" => $stage->getSeat(),
                    "gate" => $stage->getGate(),
                    "baggage_drop" => $stage->getBaggageDrop(),
                ];
            }
        }

        return $response->setAndSendResponse($data, $request, [], false, $data["statusCode"]);
    }
}