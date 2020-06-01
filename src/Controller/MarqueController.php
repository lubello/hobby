<?php

namespace App\Controller;

use App\Annotation\Uploadable;
use App\Annotation\UploadAnnotationReader;
use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marque")
 */
class MarqueController extends AbstractController
{
    /**
     * @Route("/", name="marque_index", methods={"GET"})
     * @param MarqueRepository $marqueRepository
     * @return Response
     */
    public function index(MarqueRepository $marqueRepository): Response
    {
        return $this->render('marque/index.html.twig', [
            'marques' => $marqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="marque_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     */
    public function new(Request $request): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        $reflexion = new \ReflectionClass(get_class($marque));
        //$aaa = $this->get('upload.annotation_reader')->isUploadable($marque);

        // ajouter dans service.yaml 'upload.annotation_reader' sinon marche pas
        //$an = $this->get('annotations.reader')->getClassAnnotations($reflexion);
        //dump($an);
        //$an = $this->get('annotations.reader')->getClassAnnotations($reflexion);
        //dump($an);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setCreatedAt(new \DateTime()); // permet de vauver le fichier (champ file)
            // car file n'est pas tracké par symfony !!!!!!

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marque);
            $entityManager->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marque_show", methods={"GET"})
     * @param Marque $marque
     * @return Response
     */
    public function show(Marque $marque): Response
    {
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="marque_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Marque $marque
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, Marque $marque): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setUpdatedAt(new \DateTime()); // permet de sauver le fichier (champs file)
            // car file n'est pas tracké par symfony !!!!!!
            //var_dump($marque);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('marque_index');
        }

        return $this->render('marque/edit.html.twig', [
            'marque' => $marque,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="marque_delete", methods={"DELETE"})
     * @param Request $request
     * @param Marque $marque
     * @return Response
     */
    public function delete(Request $request, Marque $marque): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($marque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('marque_index');
    }




}
