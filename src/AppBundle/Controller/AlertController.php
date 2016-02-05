<?php
/**
 * User: goto
 * Date: 19/01/16
 * Time: 13:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Alert;
use AppBundle\Form\AlertFormType;
use Doctrine\ORM\NoResultException;
//use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AlertController
 */
class AlertController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  description="Retourne des alertes",
     *  statusCodes={
     *         200="Retourné quand tout va bien",
     *     }
     * )
     * @RequestParam(name="user_email", description="email of the user")
     * @RequestParam(name="user_id", requirements="\d+", description="id of the user")
     * @Route("/alerts", name="alert_get")
     * @Method("GET")
     *
     * @return View
     */
    public function getAlertsAction() {

        $alerts = $this->get('service.alert')->getAlerts();
        return View::create($alerts, Codes::HTTP_OK);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne une alerte",
     *  output="AppBundle\DTO\AlertDTO",
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="id de l'alerte"}
     *  },
     *  statusCodes={
     *          200="Retourné quand tout va bien",
     *          404 = "Retourné quand l'alerte n'est pas trouvé"
     *     }
     * )
     * @Route("/alerts/{id}", name="alert_get")
     * @Method("GET")
     */
    public function getAlertAction($id) {


        try {
            $alert = $this->get('service.alert')->getAlertById($id);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("Alerte d'id $id n'existe pas");
        }
        return $alert;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Supprime une alerte par son id",
     *  statusCodes = {
     *     204 = "Retourné si bien supprimé",
     *     404 = "Retourné quand l'alerte n'est pas trouvé"
     *   }
     * )
     * @Route("/alerts/{id}", name="alert_delete")
     * @Method("DELETE")
     */
    public function deleteAlertAction($id)
    {
        $this->get("service.alert")->deleteAlertById($id);
    }
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Ajoute une alerte",
     *  output = "Epsi\RestBundle\Alert",
     *  input = "alert_type",
     *  statusCodes = {
     *     201 = "Retourné lorsque bien créé",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'alerte n'est pas trouvé"
     *   }
     * )
     * @Route("/alerts/{id}", name="alert_create")
     * @Method("POST")
     */
    public function createAlertAction(Request $request) {

        $form = $this->createForm(new AlertFormType(), new Alert());
        $form->handleRequest($request);

        if ($form->isValid()) {

            $id_created = $this->get('service.alert')->createAlert($form->getData());

            $response = new Response();
            $response->setStatusCode(201);

            $response->headers->set('Location',
                                    $this->generateUrl('alert_get', array('id' => $id_created))
            );

            return $response;
        }

        return View::create($form, 400);

    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Met à jour une alerte",
     *  statusCodes = {
     *     204 = "Retourné lorsque bien modifié",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'alerte n'est pas trouvé"
     *   }
     * )
     * @Route("/alerts/{id}", name="alert_update")
     * @Method("PUT")
     */
    public function updateAlertAction(Request $request, $id) {

        $alert = $this->get("service.alert")->getAlertById($id);
        $form = $this->createForm(new AlertFormType(), $alert);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $this->get('service.alert')->updateAlert($form->getData(), $id);

            $response = new Response();
            $response->setStatusCode(204);

            return $response;
        }

        return View::create($form, 400);

    }

}