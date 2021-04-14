<?php

namespace App\Controller;

use App\Entity\Bed;
use App\Entity\Timber;
use App\Form\BedType;
use App\Repository\BedRepository;
use App\Repository\TimberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bed")
 */
class BedController extends AbstractController
{
    /**
     * @Route("/", name="bed_index", methods={"GET"})
     */
    public function index(BedRepository $bedRepository, TimberRepository $timberRepository): Response
    {
        $template = 'bed/index.html.twig';
        $args = [
            'beds' => $bedRepository->findAll(),
            'timbers' => $timberRepository->findAll(),
        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/oak", name="bed_filter_oak", methods={"GET"})
     */
    public function filterOak(BedRepository $bedRepository, TimberRepository $timberRepository): Response
    {
        $oak = $timberRepository->findByName('oak');

        $template = 'bed/index.html.twig';
        $args = [
            'beds' => $bedRepository->findByTimber($oak)
        ];
        return $this->render($template, $args);
    }


    /**
     * @Route("/timber/{id}", name="bed_filter_timber", methods={"GET"})
     */
    public function filterByTimber($id, BedRepository $bedRepository, TimberRepository $timberRepository): Response
    {
        $timber = $timberRepository->find($id);

        $template = 'bed/index.html.twig';
        $args = [
            'beds' => $bedRepository->findByTimber($timber)
        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/new", name="bed_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bed = new Bed();
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bed);
            $entityManager->flush();

            return $this->redirectToRoute('bed_index');
        }

        return $this->render('bed/new.html.twig', [
            'bed' => $bed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bed_show", methods={"GET"})
     */
    public function show(Bed $bed): Response
    {
        $template = 'bed/show.html.twig';
        $args = [
            'bed' => $bed,
        ];
        return $this->render($template, $args);
    }

    /**
     * @Route("/{id}/edit", name="bed_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bed $bed): Response
    {
        $form = $this->createForm(BedType::class, $bed);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bed_index');
        }

        return $this->render('bed/edit.html.twig', [
            'bed' => $bed,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bed_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bed $bed): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bed->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bed);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bed_index');
    }
}
