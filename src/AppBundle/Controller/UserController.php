<?php
/**

 * User: goto
 * Date: 19/01/16
 * Time: 13:03
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\UserFormType;
use Doctrine\ORM\NoResultException;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  description="Retourne des utilisateurs",
     *  statusCodes={
     *         200="Retourné quand tout va bien",
     *     }
     * )
     * @Route("/users", name="user_get")
     * @Method("GET")
     */
    public function getUsersAction() {

        $users = $this->get('service.user')->getUsers();
        return View::create($users, Codes::HTTP_OK);

    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne un utilisateur",
     *  output="AppBundle\DTO\UserDTO",
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="id de l'utilisateur"}
     *  },
     *  statusCodes={
     *          200="Retourné quand tout va bien",
     *          404 = "Retourné quand l'utilisateur n'est pas trouvé"
     *     }
     * )
     * @Route("/users/{id}", name="user_get_one")
     * @Method("GET")
     */
    public function getUserAction($id) {

        try {
            $user = $this->get('service.user')->getUserById($id);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("Utilisateur d'id $id n'existe pas");
        }
        return $user;
    }

//    /**
//     * @ApiDoc(
//     *  resource=true,
//     *  description="Supprime un utilisateur par son id",
//     *  statusCodes = {
//     *     204 = "Retourné si bien supprimé",
//     *     404 = "Retourné quand l'utilisatesur n'est pas trouvé"
//     *   }
//     * )
//     * @Route("/users/{id}", name="user_delete")
//     * @Method("DELETE")
//     */
//    public function deleteUserAction($id)
//    {
//        try {
//            $this->get('service.user')->deleteUserById($id);
//        } catch(NoResultException $e) {
//            throw $this->createNotFoundException("Utilisateur d'id $id n'existe pas");
//        }
//    }
    /**
     * @ApiDoc(
     *  description="Ajoute un utilisateur",
     *  output="AppBundle\DTO\UserDTO",
     *  input = "AppBundle\Form\UserFormType",
     *  statusCodes = {
     *     201 = "Retourné lorsque bien créé",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *   }
     * )
     * @Route("/users", name="user_create")
     * @Method("POST")
     */
    public function createUserAction(Request $request) {


        $form = $this->createForm(UserFormType::class, new User());
        $form->handleRequest($request);

        if ($form->isValid()) {

            $id_created = $this->get('service.user')->createUser($form->getData());

            $response = new Response();
            $response->setStatusCode(Codes::HTTP_CREATED);

            $response->headers->set('Location',
                                    $this->generateUrl('user_get', array('id' => $id_created))
            );

            return $response;
        }
        return View::create($form, Codes::HTTP_BAD_REQUEST);

    }

//    /**
//     * @ApiDoc(
//     *  resource=true,
//     *  description="Met à jour un utilisateur",
//     *  statusCodes = {
//     *     204 = "Retourné lorsque bien modifié",
//     *     400 = "Retourné lorsque probleme de paramètre invalide",
//     *     404 = "Retourné quand l'utilisateur n'est pas trouvé"
//     *   }
//     * )
//     * @Route("/users/{id}", name="user_update")
//     * @Method("PUT")
//     */
//    public function updateUserAction(Request $request, $id) {
//        try {
//            $user = $this->get('service.user')->getUserById($id);
//        } catch(NoResultException $e) {
//            throw $this->createNotFoundException("Utilisateur d'id $id n'existe pas");
//        }
//        $form = $this->createForm(new UserProfilFormType(), $user);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//
//            $this->get('service.user')->updateUser( $form->getData() );
//
//            $response = new Response();
//            $response->setStatusCode(Codes::HTTP_ACCEPTED);
//
//            return $response;
//        }
//
//        return View::create($form, Codes::HTTP_BAD_REQUEST);
//
//    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Met à jour un utilisateur partiellement",
     *  statusCodes = {
     *     204 = "Retourné lorsque bien modifié",
     *     400 = "Retourné lorsque probleme de paramètre invalide",
     *     404 = "Retourné quand l'utilisateur n'est pas trouvé"
     *   }
     * )
     * @RequestParam(name="positionLong", requirements="[-+]?(\d*[.])?\d+", description="longitude like 31.487")
     * @RequestParam(name="positionLat", requirements="[-+]?(\d*[.])?\d+", description="latitude like -31.487")
     * @RequestParam(name="photo", description="url of photo")
     * @Route("/users/{id}", name="user_patch")
     * @Method("PATCH")
     */
    public function patchUserAction( $id, ParamFetcherInterface $paramFetcher) {

        $errors = [];
        try {
            $user = $this->get("doctrine.orm.default_entity_manager")->getRepository("AppBundle:User")->getUserById($id);
        } catch(NoResultException $e) {
            throw $this->createNotFoundException("Utilisateur d'id $id n'existe pas");
        }
        $positionLat = $paramFetcher->get("positionLat", false);
        $positionLong = $paramFetcher->get("positionLong", false);
        $photo = $paramFetcher->get("photo", false);

        if (
            ($photo != "")
        ) {
            $user->setPhoto($photo);
        }
        if (
            ($positionLong != "" && $positionLat == "")
            || ($positionLong == "" && $positionLat != "")
        ) {
            $errors[]= "La lattitude et la longitude doivent être renseigné";
        } elseif ( $positionLong != "" ) {
            $user->setPositionLat($positionLat);
            $user->setPositionLong($positionLong);
        }

        //beurk dégeulasse mais probleme pour valider le formulaire
        if( $positionLat == ""
            && $positionLong == ""
            && $photo == ""
        ) {
            $errors[]= "aucun parametre";
        }

        if( count($errors) == 0 ) {

            $this->get('service.user')->updateUser($user);

            $response = new Response();
            $response->setStatusCode(204);

            return  $response ;

        } else {
            return View::create($errors, 400);
        }

    }

    /**
     * @ApiDoc(
     *  description="Verifie si un utilisateur peut se connecter",
     *  parameters={
     *         {
     *          "name"="password",
     *          "dataType"="string",
     *          "required"="true",
     *          "description"="sha1 encoded password"
     *         }
     *   },
     *  statusCodes = {
     *     202 = "Retourné lorsque credentials OK",
     *     400 = "Retourné lorsque le mot de passe n'est pas envoyé",
     *     412 = "Retourné lorsque credentials NOK",
     *   }
     * )
     * @Route("/authenticate/{email}", name="user_auth")
     * @Method("POST")
     */
    public function checkAuthentication($email, Request $request) {
        $password= $request->get("password", null);
        $response = new Response();
        if(is_null($password) ) {
            $response->setStatusCode(Codes::HTTP_BAD_REQUEST);
        } else {
            $isAuthenticated = $this->get('service.user')->isUserCredentialsOk($email, $password);

            if($isAuthenticated) {

                $response->setStatusCode(Codes::HTTP_ACCEPTED);
                $user =  $this->get('service.user')->getUserByEmail($email);
                return $user;
            } else {
                $response->setStatusCode(Codes::HTTP_PRECONDITION_FAILED);
            }
        }
        return $response;

    }

}