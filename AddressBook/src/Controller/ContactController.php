<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contacts")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function list()
    {
        /** @var $connect Connection */
        $connect = $this->getDoctrine()->getConnection();
        $count = $connect->fetchColumn('SELECT COUNT(id) AS count FROM contact');

        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $repo->findBy([], [], 100);
        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
            'count' => $count,
        ]);
    }

    /**
     * @Route("/add")
     */
    public function create()
    {
        return $this->render('contact/create.html.twig', []);
    }

    /**
     * @Route("/{id}")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repo->find($id);

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/update")
     */
    public function update()
    {
        return $this->render('contact/update.html.twig', []);
    }

    /**
     * @Route("/{id}/delete")
     */
    public function delete()
    {
        return $this->render('contact/delete.html.twig', []);
    }
}
