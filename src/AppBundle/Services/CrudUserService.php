<?php
namespace AppBundle\Services;

use AppBundle\DTO\UserDTO;
use AppBundle\Entity\Alert;
use AppBundle\Entity\User;
use AppBundle\Repository\AlertRepository;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

class CrudUserService
{
    private $userRepository;
    private $alertRepository;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::BUNDLE_NAME);
        $this->alertRepository = $em->getRepository(Alert::BUNDLE_NAME);

    }


    /**
     * @param $id
     *
     * @return UserDTO
     */
    public function getUserById($id) {
        $user =  $this->userRepository->getUserById($id);
        return new UserDTO($user);
    }

    /**
     * @return \AppBundle\DTO\UserDTO[]
     */
    public function getUsers() {
        $users = $this->userRepository->getUsers();
        $dtos = [];
        foreach($users as $user) {
            $dtos[]= new UserDTO($user);
        }
        return $dtos;
    }

    /**
     * @param $id
     */
    public function deleteUserById($id) {
        $user =  $this->userRepository->getUserById($id);

        $this->em->remove($user);
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function createUser(User $user) {
        $this->em->persist($user);
        $this->em->flush();

        return new UserDTO($user);
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function updateUser(User $user) {
        $this->em->persist($user);
        $this->em->flush();
        return new UserDTO($user);
    }

    /**
     * @param $email
     * @param $password
     *
     * @return bool
     */
    public function isUserCredentialsOk($email, $password) {
        try {
            $user =  $this->userRepository->getUserByEmail($email);

        } catch(NoResultException $e) {
            //on ne sonde pas la base ;)
            return false;
        } finally {
            return $user->checkPassword($password);
        }

    }

}