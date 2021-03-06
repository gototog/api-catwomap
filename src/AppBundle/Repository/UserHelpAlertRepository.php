<?php

namespace AppBundle\Repository;
use AppBundle\Entity\UserHelpAlert;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserHelpAlertRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $id
     *
     * @return UserHelpAlert
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserHelpAlertById($id) {
        $qb = $this->createQueryBuilder('user_help_alert');
        $qb
            ->andWhere('user_help_alert.id = :id')
            ->setParameter('id',$id)
            ;
        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param $userId
     * @param $alertId
     *
     * @return UserHelpAlert
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserHelpAlertByAlertAndUser($userId, $alertId) {
        $qb = $this->createQueryBuilder('user_help_alert');
        $qb
            ->andWhere('user_help_alert.alert = :alert')
            ->setParameter('alert',$alertId)
            ->andWhere('user_help_alert.user = :user')
            ->setParameter('user',$userId)
            ;
        return $qb->getQuery()->getSingleResult();
    }

}
