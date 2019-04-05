<?php


namespace App\Manager;


use App\Entity\Contact;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

class ContactDoctrineManager implements ContactManagerInterface
{
    /** @var ManagerRegistry */
    protected $doctrine;

    /**
     * ContactDoctrineManager constructor.
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

    public function count(): int {
        /** @var $connect Connection */
        $connect = $this->getDoctrine()->getConnection();
        return $connect->fetchColumn('SELECT COUNT(id) AS count FROM contact');
    }

    public function getAll(): array
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        return $repo->findBy([], [], 100);
    }

    public function getById(string $id): Contact
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        return $repo->findWithCompany($id);
    }

    public function save(Contact $contact): void
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();
    }
}