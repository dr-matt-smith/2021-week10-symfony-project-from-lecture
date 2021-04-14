<?php

namespace App\Controller;

use App\Entity\Timber;
use App\Form\TimberType;
use App\Repository\TimberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/timber")
 */
class TimberController extends AbstractController
{
    /**
     * @Route("/", name="timber_index", methods={"GET"})
     */
    public function index(TimberRepository $timberRepository): Response
    {
        return $this->render('timber/index.html.twig', [
            'timbers' => $timberRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="timber_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $timber = new Timber();
        $form = $this->createForm(TimberType::class, $timber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($timber);
            $entityManager->flush();

            return $this->redirectToRoute('timber_index');
        }

        return $this->render('timber/new.html.twig', [
            'timber' => $timber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="timber_show", methods={"GET"})
     */
    public function show(Timber $timber): Response
    {
        return $this->render('timber/show.html.twig', [
            'timber' => $timber,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="timber_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Timber $timber): Response
    {
        $form = $this->createForm(TimberType::class, $timber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('timber_index');
        }

        return $this->render('timber/edit.html.twig', [
            'timber' => $timber,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="timber_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Timber $timber): Response
    {
        if ($this->isCsrfTokenValid('delete'.$timber->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($timber);
            $entityManager->flush();
        }

        return $this->redirectToRoute('timber_index');
    }
}
