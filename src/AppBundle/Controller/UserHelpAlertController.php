<?php
/**
 * User: goto
 * Date: 19/01/16
 * Time: 13:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Alert;
use AppBundle\Entity\UserHelpAlert;
use AppBundle\Form\AlertFormType;
use AppBundle\Form\UserHelpAlertFormType;
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

class UserHelpAlertController extends FOSRestController
{


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Ajoute une relation user alerte",
     *  input = "AppBundle\Form\UserHelpAlertFormType",
     *  statusCodes = {
     *     201 = "Retourné lorsque bien créé",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'alerte ou l'utilisateur n'est pas trouvé n'est pas trouvé"
     *   }
     * )
     * @Route("/user/{id_user}/help/alerts/{id_alert}", name="user_help_alert_create")
     * @Method("POST")
     */
    public function createUserHelpAlertAction(Request $request, $id_user, $id_alert) {


        try {
            $alert = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:Alert")->getAlertById($id_alert);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("pas d'alerte $id_alert");
        }
        try {
            $user = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:User")->getUserById($id_user);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("pas d'user $id_user");
        }
        try {
            $userHelpAlert = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:UserHelpAlert")->getUserHelpAlertByAlertAndUser($id_user, $id_alert);
            throw $this->createNotFoundException("La relation existe deja entre l'alerte $id_alert et l'user $id_user");

        } catch(NoResultException $e) {
            //good :)
        }

        $form = $this->createForm(UserHelpAlertFormType::class, new UserHelpAlert());
        $form->handleRequest($request);



        if ($form->isValid()) {

            $userHelpalertDTO = $this->get('service.alert')->createUserHelpAlert($form->getData(), $user, $alert);

            $response = new Response();
            $response->setStatusCode(201);

//            $response->headers->set('Location',
//                                    $this->generateUrl('alert_get', array('id' => $alertDTO->id))
//            );

            return $response;
        }

        return View::create($form, 400);

    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Met à jour une  relation user alerte partiellement",
     *  statusCodes = {
     *     204 = "Retourné lorsque bien modifié",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand la relation user alerte n'est pas trouvée ou existe déjà"
     *   }
     * )
     * @RequestParam(name="is_deprecated",requirements="[0-1]", description="fausse alerte? 1 oui, 0 non ")
     * @RequestParam(name="has_called_police",requirements="[0-1]", description="a appelé les secours? 1 oui, 0 non  ")
     * @Route("/user/{id_user}/help/alerts/{id_alert}", name="user_help_alert_patch")
     * @Method("PATCH")
     */
    public function patchUserHelpAlertAction( ParamFetcherInterface $paramFetcher, $id_user, $id_alert) {

        $errors = [];
        try {
            $userHelpAlert = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:UserHelpAlert")->getUserHelpAlertByAlertAndUser($id_user, $id_alert);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("pas de relation entre l'alerte $id_alert et l'user $id_user");
        }

        $isDeprecated = $paramFetcher->get("is_deprecated", false);
        $hasCalledPolice = $paramFetcher->get("has_called_police", false);


        if($hasCalledPolice != "") {
            $userHelpAlert->setHasCalledPolice($hasCalledPolice);
        }
        if($isDeprecated != "") {
            $userHelpAlert->setIsDeprecated($isDeprecated);
        }


        //beurk dégeulasse mais probleme pour valider le formulaire
        if( $hasCalledPolice == ""
            &&  $isDeprecated == ""
        ) {
            $errors[]= "aucun parametre";
        }

        if( count($errors) == 0 ) {

            $this->get('service.alert')->updateUserHelpAlert($userHelpAlert);

            $response = new Response();
            $response->setStatusCode(204);

            return  $response ;

        } else {
            return View::create($errors, 400);
        }

    }


}