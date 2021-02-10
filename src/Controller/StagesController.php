<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Stage;
use App\Entity\Travel;
use App\Entity\Type;
use App\Services\Dates\DatesChecker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagesController extends AbstractController
{
    /**
     * Route d'affichage du tableau des étapes.
     * @Route("/stages", name="stages")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $stages = $manager->getRepository(Stage::class)->findAll();
        $types = $manager->getRepository(Type::class)->findAll();
        $cities = $manager->getRepository(City::class)->findAll();
        $inactivesTravels = $manager->getRepository(Travel::class)->findBy(["isActive" => false]);

        return $this->render('stages/index.html.twig', [
            'stages' => $stages,
            'types' => $types,
            'cities' => $cities,
            'notifications' => $inactivesTravels,
            'page_name' => "Les étapes disponibles",
        ]);
    }

    /**
     * Fonction qui récupère les informations du formulaire de création d'une étape.
     * @Route("/stages/register", name="stages_register", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function registerNewStage(Request $request): RedirectResponse
    {
        if ($request->request->get("selectType") ||
            $request->request->get("departureCity") ||
            $request->request->get("arrivalCity") ||
            $request->request->get("number"))
        {
            $selectType = $request->request->get("selectType");
            $departureCity = $request->request->get("departureCity");
            $departureCityDate = $request->request->get("departureCityDate");
            $arrivalCity = $request->request->get("arrivalCity");
            $arrivalCityDate = $request->request->get("arrivalCityDate");
            $number = $request->request->get("number");
            //Variables non obligatoires
            $seat = $request->request->get("seat");
            $gate = $request->request->get("gate");
            $baggagesDrop = $request->request->get("baggagesDrop");

            //Test sur l'id du type
            if (!is_numeric($selectType) && intval($selectType) <= 0) {
                $this->addFlash("danger", "Le type d'étape est incorrect.");
                return $this->redirectToRoute("stages");
            }

            //test sur l'id de la ville de départ
            if (!is_numeric($departureCity) && intval($departureCity) <= 0) {
                $this->addFlash("danger", "La ville de départ est incorrecte.");
                return $this->redirectToRoute("stages");
            }

            //test sur l'id de la ville d'arrivée
            if (!is_numeric($arrivalCity) && intval($arrivalCity) <= 0) {
                $this->addFlash("danger", "La ville d'arrivée est incorrecte.");
                return $this->redirectToRoute("stages");
            }

            //On test le numéro de l'étape
            if (empty($number)) {
                $this->addFlash("danger", "Veuillez saisir un numéro pour l'étape.");
                return $this->redirectToRoute("stages");
            }

            $dateChecker = new DatesChecker();
            //On test la validité de la date en fonction du format souhaité.
            if (!$dateChecker->checkDateFormat($departureCityDate)) {
                $this->addFlash("danger", "Le format de la date de départ est incorrect.");
                return $this->redirectToRoute("stages");
            }

            if (!$dateChecker->checkDateFormat($arrivalCityDate)) {
                $this->addFlash("danger", "Le format de la date d'arrivée est incorrect.");
                return $this->redirectToRoute("stages");
            }

            $manager = $this->getDoctrine()->getManager();

            $stage = new Stage();
            /**
             * @var $type Type
             */
            $type = $manager->getRepository(Type::class)->findOneBy(["id" => $selectType]);
            if ($type) {
                $stage->setType($type);
            }

            /**
             * @var $cityDeparture City
             */
            $cityDeparture = $manager->getRepository(City::class)->findOneBy(["id" => $departureCity]);
            if ($cityDeparture) {
                $stage->setDeparture($cityDeparture);
            }

            /**
             * @var $cityArrival City
             */
            $cityArrival = $manager->getRepository(City::class)->findOneBy(["id" => $arrivalCity]);
            if ($cityArrival) {
                $stage->setArrival($cityArrival);
            }

            //On vérifie la concordances des dates
            if ($dateChecker->getDateTime($departureCityDate) > $dateChecker->getDateTime($arrivalCityDate)) {
                $this->addFlash("danger", "La date d'arrivée doit être supérieure à la date de départ.");
                return $this->redirectToRoute("stages");
            }

            $stage->setDepartureDate($dateChecker->getDateTime($departureCityDate));
            $stage->setArrivalDate($dateChecker->getDateTime($arrivalCityDate));
            $stage->setNumber($number);

            if (!empty($seat)) {
                $stage->setSeat($seat);
            }

            if (!empty($gate)) {
                $stage->setGate($gate);
            }

            if (!empty($baggagesDrop)) {
                $stage->setBaggageDrop($baggagesDrop);
            }

            $manager->persist($stage);
            $manager->flush();

            $this->addFlash("success", "L'étape au départ de " . $stage->getDeparture()->getName() . " et à l'arrivée de " . $stage->getArrival()->getName() . " a bien été enregistrée.");
            return $this->redirectToRoute("stages");
        }

        $this->addFlash("danger", "Le formulaire envoyé est invalide.");
        return $this->redirectToRoute("stages");
    }
}
