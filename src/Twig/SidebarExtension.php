<?php


namespace  App\Twig;



use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SidebarExtension extends AbstractExtension
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var TagAwareAdapterInterface
     */
    private $cache;

    /**
     * SidebarExtension constructor.
     * @param Environment $twig
     * @param TagAwareAdapterInterface $cache
     */
    public function __construct(Environment $twig,
                                TagAwareAdapterInterface $cache)
    {

        $this->twig = $twig;
        $this->cache = $cache;  // pas d' autowire par défaut ==>ajouter dans service.yaml !!!
    }

    public function getFunctions():array {
        return [
            new TwigFunction('sidebar', [$this, 'getSidebar'], ['is_safe' => ['html']])
        ];
    }

    public function getSidebar(string $parm1): string
    {
        try {
            $this->cache->invalidateTags(['posts']);
        } catch (InvalidArgumentException $e) {
        }
        return $this->cache->get('sidebar', function(ItemInterface $item)  use ($parm1){
            $posts[] = [ 'id' => 1, 'name'=>'Régions',  'href'=> '/region'  ];
            $posts[] = [ 'id' => 2, 'name'=>'Departements', 'href'=> '/departement' ];
            $posts[] = [ 'id' => 3, 'name'=>'Villes',   'href'=> '/ville' ];
            $posts[] = [ 'id' => 4, 'name'=>'Marques',  'href'=> '/marque' ];
            $posts[] = [ 'id' => 5, 'name'=>'Modèles',  'href'=> '/modele' ];
            $posts[] = [ 'id' => 6, 'name'=>'Articles', 'href'=> '/article/gallery' ];

            $item ->expiresAfter(3600) ;
            $item->tag(['comments', 'posts']);
            return $this->twig->render('Partials/sidebar.html.twig', [
                'posts'  => $posts,
                'param1' => $parm1, // Comment passer un paramètre
            ]);
        });

        $this->cache->delete('sidebar');
        $this->cache->invalidateTags(['posts']);

    }

}