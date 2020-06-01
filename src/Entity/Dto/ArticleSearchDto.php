<?php


namespace App\Entity\Dto;


use App\Entity\Marque;

class ArticleSearchDto
{


    /**
     * @var string
     */
    public $q;

    /**
     * @var Marque[]
     */
    public $marques;

    /**
     * @var integer
     */
    public $min;

    /**
     * @var integer
     */
    public $max;

    /**
     * @var integer
     */
    public $quantiteMin;
    /**
     * @var integer
     */
    public $quantiteMax;

    /**
     * @var integer
     */
    public $page = 1;

    /**
     * @var integer
     */
    public  $limitPerPage = 5;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $ref;


    public function __construct() { }

}