<?php

namespace App\Controller;

use App\Common\dto\TagDto;
use App\Common\dto\TagsDto;
use App\Entity\Article;
use App\Entity\Dto\ArticleSearchDto;
use App\Form\ArticleSearchForm;
use App\Form\ArticleType;
use App\Form\TagsForm;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Reports\SalesByCustomer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/", name="article_index", methods={"GET"})
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response {

        $search = new ArticleSearchDto();
         $search->page = $request->get('page', 1);
         $search->limitPerPage = $request->get('limitPerPage', 10);
         
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
     * @Route("/gallery", name="article_gallery", methods={"GET","POST"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function gallery(Request $request, PaginatorInterface $paginator): Response
    {
        $cardLight = $request->get('light', false);

        $search = new ArticleSearchDto();
        $search->page = $request->get('page', 1);
        $search->limitPerPage = $request->get('limitPerPage', 50);

        // get tags grouped
        $liste = $this->articleRepository->findaaaa();
        foreach ($liste as $list) {
            $search->liste[] = new TagsDto(
                new TagDto($list['tag1']),
                new TagDto($list['tag2']),
                new TagDto($list['tag3']),
                new TagDto($list['tag4']),
                new TagDto($list['tag5']),
                new TagDto($list['tag6']),
                $list['total']
            );
            //var_dump($list['tag1'].' - '.$list['tag2'].PHP_EOL.'<br/>');
        }

        $form = $this->createForm(ArticleSearchForm::class, $search);
        $form->handleRequest($request);
        //die(var_dump($form->isValid()));
        if ($form->isSubmitted()) { //} && $form->isValid()) {
            /** @var ArticleSearchDto $entity */
            $entity = $form->getData();
            foreach ($entity->liste as $dto) {
                if ($dto->isModified()) {
                    // modifier les articles avec ces tagc (original) par celui modifié

                    die(var_dump($dto));
                }
            }

        }

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


    /**
     * @Route("/search", name="article_show", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query', null);

        $array = [
            [
                "food"    => "1 Sauce - Thousand Island",
                "cities"  => "Soanindrariny",
                "animals" => "Common boubou shrike"
            ],
            [
                "food"    => "2 Flour - Masa De Harina Mexican",
                "cities"  => "Magoúla",
                "animals" => "Black-backed magpie"
            ],
            [
                "food"    => "3 sdfdsfsdfsd",
                "cities"  => "Soanindrariny",
                "animals" => "Commsdfsdf sdfsdfon boubou shrike"
            ]
        ];

        return $this->json($array);
    }



    /**
     * @Route("/findByTags", name="article_find_by_tags", methods={"GET"})
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function articleFindByTags(Request $request, PaginatorInterface $paginator): Response
    {
        $search = new TagsDto();
        $search->getTag1()->setTag($request->get('tag1', null));
        $search->getTag2()->setTag($request->get('tag2', null));
        $search->getTag3()->setTag($request->get('tag3', null));
        $search->getTag4()->setTag($request->get('tag4', null));
        $search->getTag5()->setTag($request->get('tag5', null));
        $search->getTag6()->setTag($request->get('tag6', null));
        $form = $this->createForm(TagsForm::class, $search);
        $form->handleRequest($request);
        $articles = $this->articleRepository->searchByTags($search);



        return $this->render('article/index.html.twig', [
            'articles'  => $articles,
            'form'      => $form->createView(),
            'gridLight' => true,
        ]);
    }
}
