<?php
/**
 * User: goto
 * Date: 19/01/16
 * Time: 13:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Alert;
use AppBundle\Form\AlertFormType;
use AppBundle\Services\Geocoder;
use Doctrine\ORM\NoResultException;
//use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
     * @QueryParam(name="creator_id", requirements="\d+", description="id of the user")
     * @QueryParam(name="dep", description="departement number like 'Isère'")
     * @QueryParam(name="city", requirements="[a-z]+", description="city name like 'grenoble' ")
     * @QueryParam(name="country", requirements="[a-z]+", description="country name 'france' ")
     * @QueryParam(name="status", requirements="[a-z]+", description="status name 'active', 'closed' ")
     * @Route("/alerts", name="alerts_get")
     * @Method("GET")
     *
     * @return View
     */
    public function getAlertsAction(ParamFetcherInterface $paramFetcher) {
        $department = $paramFetcher->get("dep", false);
        $country = $paramFetcher->get("country", false);
        $city = $paramFetcher->get("city", false);
        $creator = $paramFetcher->get("creator_id", false);
        $status = $paramFetcher->get("status", false);
        $alerts = $this->get('service.alert')->getAlerts($city, $department, $country, $creator, $status);


        return View::create($alerts, Codes::HTTP_OK);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne une alerte",
     *  output="AppBundle\DTO\AlertDTO",
     *  parameters={
     *  },
     *  statusCodes={
     *          200="Retourné quand tout va bien",
     *          404 = "Retourné quand l'alerte n'est pas trouvé"
     *     }
     * )
     * @Route("/alerts/{id}", name="alert_get")
     * @Method("GET")
     *
     * @param integer $id    id de l'alerte
     *
     * @return \AppBundle\DTO\AlertDTO
     */
    public function getAlertAction($id) {


        try {
            $alert = $this->get('service.alert')->getAlertById($id);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("Alerte d'id $id n'existe pas");
        }
        return $alert;
    }
//
//    /**
//     * @ApiDoc(
//     *  resource=true,
//     *  description="Supprime une alerte par son id",
//     *  statusCodes = {
//     *     204 = "Retourné si bien supprimé",
//     *     404 = "Retourné quand l'alerte n'est pas trouvé"
//     *   }
//     * )
//     * @Route("/alerts/{id}", name="alert_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAlertAction($id)
//    {
//        try {
//            $this->get("service.alert")->deleteAlertById($id);
//        } catch(NoResultException $e) {
//            throw $this->createNotFoundException("pas d'alerte d'id $id");
//        }
//    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Ajoute une alerte",
     *  output = "AppBundle\DTO\AlertDTO",
     *  input = "AppBundle\Form\AlertFormType",
     *  statusCodes = {
     *     201 = "Retourné lorsque bien créé",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'alerte n'est pas trouvé"
     *   }
     * )
     * @Route("/alerts", name="alert_create")
     * @Method("POST")
     */
    public function createAlertAction(Request $request) {

        $form = $this->createForm(AlertFormType::class, new Alert());
        $form->handleRequest($request);

        if ($form->isValid()) {

            $alertDTO = $this->get('service.alert')->createAlert($form->getData());

            $response = new Response();
            $response->setStatusCode(201);

            $response->headers->set('Location',
                                    $this->generateUrl('alert_get', array('id' => $alertDTO->id))
            );

            return $response;
        }

        return View::create($form, 400);

    }

//    /**
//     * @ApiDoc(
//     *  resource=true,
//     *  description="Met à jour une alerte",
//     *  statusCodes = {
//     *     204 = "Retourné lorsque bien modifié",
//     *     400 = "Retourné lorsque probleme de paramètre invalide",
//     *     404 = "Retourné quand l'alerte n'est pas trouvé"
//     *   }
//     * )
//     * @Route("/alerts/{id}", name="alert_update")
//     * @Method("PUT")
//     */
//    public function updateAlertAction(Request $request, $id) {
//
//        try {
//            $alert = $this->get('service.alert')->getAlertById($id);
//        } catch(NoResultException $e) {
//            throw $this->createNotFoundException("Alerte d'id $id n'existe pas");
//        }
//
//        $form = $this->createForm(new AlertFormType(), $alert);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//
//            $this->get('service.alert')->updateAlert($form->getData(), $id);
//
//            $response = new Response();
//            $response->setStatusCode(204);
//
//            return $response;
//        }
//
//        return View::create($form, 400);
//
//    }
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Met à jour une alerte partiellement",
     *  statusCodes = {
     *     204 = "Retourné lorsque bien modifié",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'alerte n'est pas trouvé"
     *   }
     * )
     * @RequestParam(name="positionLong", requirements="[-+]?(\d*[.])?\d+", description="longitude like 31.487")
     * @RequestParam(name="positionLat", requirements="[-+]?(\d*[.])?\d+", description="latitude like -31.487")
     * @RequestParam(name="category", description="category name 'vol','help' ")
     * @RequestParam(name="finished",requirements="[0-1]", description="is the alert finished? ")
     * @Route("/alerts/{id}", name="alert_patch")
     * @Method("PATCH")
     */
    public function patchAlertAction( $id, ParamFetcherInterface $paramFetcher) {

        $errors = [];
        try {
            $alert = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:Alert")->getAlertById($id);


        } catch(NoResultException $e) {
            throw $this->createNotFoundException("Alerte d'id $id n'existe pas");
        }
        $positionLat = $paramFetcher->get("positionLat", false);
        $positionLong = $paramFetcher->get("positionLong", false);
        $category = $paramFetcher->get("category", false);
        $finished = $paramFetcher->get("finished", false);




        if (
            ($positionLong != "" && $positionLat == "")
            || ($positionLong == "" && $positionLat != "")
        ) {
            $errors[]= "La lattitude et la longitude doivent être renseigné";
        } elseif ( $positionLong != "" ) {
            $alert->setPositionLat($positionLat);
            $alert->setPositionLong($positionLong);
        }
        if($category != "") {
            $alert->setCategory($category);
        }
        if($finished != "") {
            if ($finished) {
                $alert->setFinishedAt( new \DateTime() );
            } else {
                $alert->setFinishedAt(null);
            }
        }

        //beurk dégeulasse mais probleme pour valider le formulaire
        if( $positionLat == ""
            &&  $category == ""
            &&  $finished == ""
            && $positionLong == ""
        ) {
            $errors[]= "aucun parametre";
        }

        if( count($errors) == 0 ) {

            $this->get('service.alert')->updateAlert($alert);

            $response = new Response();
            $response->setStatusCode(204);

            $infos = Geocoder::getLocation($alert->getPositionLat(), $alert->getPositionLong() );


            return  $response ;

        } else {
            return View::create($errors, 400);
        }

    }

//    private function processForm(Alert      $alert, array $parameters, $method = "PUT")
//    {
//        $form = $this->get('form.factory')->create(new AlertFormType(), $alert, array('method' => $method));
//
//        $clearIfMissing =   ('PATCH' !== $method);
//
//        $form->submit($parameters, $clearIfMissing);
//        if ($form->isValid()) {
//
//            $page = $form->getData();
//            $this->om->persist($page);
//            $this->om->flush($page);
//
//            return $page;
//        }
//
//        throw new InvalidFormException('Invalid submitted data', $form);
//    }



}