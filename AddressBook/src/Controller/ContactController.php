<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contacts")
 */
class ContactController extends AbstractController
{
    /** @var ContactManager */
    protected $manager;

    /**
     * ContactController constructor.
     * @param ContactManager $manager
     */
    public function __construct(ContactManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/")
     */
    public function list()
    {
        $contacts = $this->manager->getAll();
        $count = $this->manager->count();

        return $this->render('contact/list.html.twig', [
            'contacts' => $contacts,
            'count' => $count,
        ]);
    }

    /**
     * @Route("/add")
     */
    public function create(Request $request)
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'success',
                "{$contact->getFirstName()} {$contact->getLastName()} a bien été créé"
            );
            
            return $this->redirectToRoute('app_contact_list');
        }

        return $this->render('contact/create.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}")
     */
    public function show($id)
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repo->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact Not Found');
        }

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/update")
     */
    public function update($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repo->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact Not Found');
        }

        $contactForm = $this->createForm(ContactType::class);
        $contactForm->setData($contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contact = $contactForm->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash(
                'success',
                "{$contact->getFirstName()} {$contact->getLastName()} a bien été mis à jour"
            );

            return $this->redirectToRoute('app_contact_list');
        }

        return $this->render('contact/update.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete")
     */
    public function delete($id, Request $req)
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);
        $contact = $repo->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact Not Found');
        }

        if ($req->isMethod('POST')) {

            if ($req->get('confirm') === 'oui') {
                $em = $this->getDoctrine()->getManager();
                $em->remove($contact);
                $em->flush();

                $this->addFlash(
                    'success',
                    "{$contact->getFirstName()} {$contact->getLastName()} a bien été supprimé"
                );
            }

            return $this->redirectToRoute('app_contact_list');
        }

        return $this->render('contact/delete.html.twig', [
            'contact' => $contact,
        ]);
    }
}
