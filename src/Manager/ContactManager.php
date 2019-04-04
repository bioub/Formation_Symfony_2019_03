<?php


namespace App\Manager;


use App\Entity\Contact;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

class ContactManager
{
    /** @var ManagerRegistry */
    protected $doctrine;

    /**
     * ContactManager constructor.
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return ManagerRegistry
     */
    public function getDoctrine(): ManagerRegistry
    {
        return $this->doctrine;
    }

    public function count() {
        /** @var $connect Connection */
        $connect = $this->getDoctrine()->getConnection();
        return $connect->fetchColumn('SELECT COUNT(id) AS count FROM contact');
    }

    public function getAll() {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        return $repo->findBy([], [], 100);
    }
}