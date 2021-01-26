<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Dto\ArticleSearchDto;
use App\Form\ArticleSearchType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Reports\SalesByCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

         /** @var ArticleSearchDto $search */
         $search = new ArticleSearchDto();
         $search->page = $request->get('page', 1);
         $search->limitPerPage = $request->get('limitPerPage', 30);
         
        $articles = $this->articleRepository->search($search);

        return $this->render('article/index.html.twig', [
            'articles'  => $articles,
            'paginator' => $paginator,  //pas utilisé
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request): Response
    {
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $article->setCreatedAt(new \DateTime()); // permet de sauver le fichier (champs file)
            // car file n'est pas tracké par symfony !!!!!!

            $entityManager->persist($article);
            $entityManager->flush();

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'article_new'
                : 'article_index';
            return $this->redirectToRoute($nextAction);
        }


        $salesByCustomer = new SalesByCustomer;
        $graphe = $salesByCustomer->run()->render(true);

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form'    => $form->createView(),
            'graphe'  => $graphe
        ]);
    }

    /**
     * @Route("/gallery", name="article_gallery", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function gallery(Request $request, PaginatorInterface $paginator): Response
    {
        $cardLight = $request->get('light', false);

        /** @var ArticleSearchDto $search */
        $search = new ArticleSearchDto();
        $search->page = $request->get('page', 1);
        $search->limitPerPage = $request->get('limitPerPage', 30);

        $form = $this->createForm(ArticleSearchType::class, $search);
        $form->handleRequest($request);

        //dump($search);
        $articles = $this->articleRepository->search($search);



        return $this->render('article/gallery.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
            'cardLight' => $cardLight,
        ]);
    }



    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        var_dump('fff');
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     * @throws \Exception
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new \DateTime()); // permet de sauver le fichier (champs file)
            // car file n'est pas tracké par symfony !!!!!!

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * @Route("/{id}/qtUpDown", name="article_qtUpDown", methods={"GET","POST"})
     * @param Request $request
     * @param Article $article
     * @return Response
     * @throws \Exception
     */
    public function quantityUpDown(Request $request, Article $article): Response
    {
        $em = $this->getDoctrine()->getManager();
        $qt = $article->getQuantite();
        if ($qt == null) $qt = 0;

        $type = $request->get("type");
        $qt += ($type == "up" ? 1 : -1);

        $article->setQuantite($qt);
        $em->flush();

        $response = new Response(''.$qt);
        $response->headers->set('Content-Type', 'text/plain; charset=utf-8');
        //var_dump($response);
        return $response;
    }
}
