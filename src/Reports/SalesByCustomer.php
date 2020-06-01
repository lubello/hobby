<?php

namespace App\Reports;

use koolreport\KoolReport;
use koolreport\processes\Group;
use koolreport\processes\Limit;
use koolreport\processes\Sort;

class SalesByCustomer extends KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sales"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=hobby",
                    "username"=>"root",
                    "password"=>"gcl",
                    "charset"=>"utf8"
                )
            )
        );
    }

    /**
     * @return void|null
     * @throws Exception
     */
    public function setup()
    {
        $this->src('sales')
            ->query("SELECT article.tag2 FROM article")
            ->pipe(new Group(array(
                "by"    => "tag2",
                "count" => "quantite"
            )))
            ->pipe(new Sort(array(
                "quantite"=>"desc"
            )))
            ->pipe(new Limit(array(5)))
            ->pipe($this->dataStore('sales_by_customer'));
    }
}
