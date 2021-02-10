<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Entity\Travel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * Route principale. Affiche un tableau contenant tous les voyages disponibles dans l'agence.
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $travels = $manager->getRepository(Travel::class)->findAll();

        $inactivesTravels = [];
        /**
         * @var $travel Travel
         */
        foreach ($travels as $travel) {
            if (!$travel->getIsActive()) {
                $inactivesTravels[] = $travel;
            }
        }

        return $this->render('home/index.html.twig', [
            'page_name' => "Nos voyages",
            'travels' => $travels,
            'notifications' => $inactivesTravels
        ]);
    }

    /**
     * Enregistrement d'un nouveau voyage dans l'application
     * Les données proviennent de javascript (form_create_travel.js)
     * @Route("/travel/register", name="travel_register", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function registerNewTravel(Request $request): RedirectResponse
    {
        if ($request->request->get("travelName")) {
            $travelName = $request->request->get("travelName");
            $price = $request->request->get("price");

            if (strlen($travelName) < 2 || strlen($travelName) > 50) {
                $this->addFlash("danger", "L'intitulé du voyage doit comporter entre 2 et 50 caractères.");
                return $this->redirectToRoute("home");
            }

            if ($price < 0 || $price > 10000) {
                $this->addFlash("danger", "Le prix doit être compris entre 0 et 10000.");
                return $this->redirectToRoute("home");
            }

            $travel = new Travel();
            $travel->setName($travelName)
                ->setPrice($price);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($travel);
            $manager->flush();

            $this->addFlash("success", "Le voyage intitulé <b>" . $travel->getName() . "</b> a bien été enregistré.");
            return $this->redirectToRoute("home");
        } else {
            $this->addFlash("danger", "Le formulaire envoyé est invalide.");
            return $this->redirectToRoute("home");
        }
    }

    /**
     * Enregistrement d'un nouveau voyage dans l'application.
     * Les données proviennent de javascript (form_editor_travel.js)
     * @Route("/travel/update", name="travel_update", methods={"POST"})
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateTravel(Request $request): RedirectResponse
    {
        if ($request->request->get("id")) {
            $travelId = intval($request->request->get("id"));
            //On initialise le manager
            $manager = $this->getDoctrine()->getManager();
            /**
             * On type la varaible pour l'appel des méthodes
             * @var $travel Travel
             */
            $travel = $manager->getRepository(Travel::class)->findOneBy(["id" => $travelId]);
            if ($travel) {
                $travelName = $request->request->get("name-editor");
                $price = $request->request->get("price-editor");
                $active = $request->request->get("active-editor");
                $stagesSelected = $request->request->get('multiple-stage');

                if (empty($travelName)) {
                    $this->addFlash("danger", "L'intitulé du voyage ne peut-être vide.");
                    return $this->redirectToRoute("home");
                }

                if (empty($price)) {
                    $this->addFlash("danger", "Le prix du voyage ne peut-être vide.");
                    return $this->redirectToRoute("home");
                }

                $updated = false;

                if ($travel->getName() !== $travelName) {
                    $travel->setName($travelName);
                    $manager->flush();
                    $updated = true;
                }

                if (intval($travel->getPrice()) !== intval($price)) {
                    $travel->setPrice($price);
                    $manager->flush();
                    $updated = true;
                }
                /**
                 * Avec Request le checkbox est récupéré à null lorsqu'il est décoché. Il retourne "on" lorsqu'il est coché.
                 * Afin d'optimiser les performances de la base de données, je contrôle que le checkbox a bien été modifié
                 * pour ne pas faire de requête pour rien.
                 */
                if (($travel->getIsActive() & !isset($active)) || (!$travel->getIsActive() && $active === "on")) {
                    ($active === "on") ? $travel->setIsActive(true) : $travel->setIsActive(false);
                    $manager->flush();
                    $updated = true;
                }

                //todo problème
                //todo Les étapes non sélectionnées sont toujours ajoutée au voyage. Trouver comment les supprimer.
                if (!empty($stagesSelected)) {
                    //On boucle sur les étapes passées. Si elle est trouvée dans la base de données, on l'ajoute au voyage.
                    foreach ($stagesSelected as $stageSelected) {
                        /**
                         * @var $stage Stage
                         */
                        $stage = $manager->getRepository(Stage::class)->findOneBy(["id" => $stageSelected]);
                        if ($stage) {
                            $travel->addTravelStage($stage);
                            $manager->flush();
                            $updated = true;
                        }
                    }
                }


                if ($updated) {
                    $this->addFlash("success", "Le voyage <b>" . $travel->getName() . "</b> a bien été modifié.");
                    return $this->redirectToRoute("home");
                } else {
                    $this->addFlash("warning", "Aucune modification détectée pour le voyage <b>" . $travel->getName() . "</b>.");
                    return $this->redirectToRoute("home");
                }
            } else {
                $this->addFlash("danger", "Le voyage demandé est introuvable.");
                return $this->redirectToRoute("home");
            }
        }

        $this->addFlash("danger", "Le formulaire envoyé est invalide.");
        return $this->redirectToRoute("home");
    }
}
