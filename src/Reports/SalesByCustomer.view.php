<?php

use koolreport\widgets\google\ColumnChart;
use \koolreport\widgets\koolphp\Table;
use \koolreport\widgets\google\BarChart;

?>

<div class="row">
    <div class="col-md-6">

        <div class="text-center">
            <h1>Sales Report</h1>
            <h4>This report shows top 10 sales by customer</h4>
        </div>
        <hr/>
        <?php

        ColumnChart::create(array(
            "dataStore"=>$this->dataStore('sales_by_customer'),
            //"width" => "50%",
            //"height"=> "250px",
            "columns" => array(
                "tag2" => array(
                    "label" => "tag2"
                ),
                "quantite" => array(
                    "type" => "number",
                    "label" => "qte",
                    "prefix" => "€",
                    "emphasis" => true
                )
            ),
            "options" => array(
                "title" => "Sales By Customer",
            )
        ));
        ?>
    </div>

    <div class="col-md-6">

        <div class="text-center">
            <h1>Sales Report</h1>
            <h4>This report shows top 10 sales by customer</h4>
        </div>
        <hr/>
        <?php
        Table::create(array(
            "dataStore" => $this->dataStore('sales_by_customer'),
             "cssClass"=>array(
                "table" => "table table-hover table-bordered",
                "th"    => "cssHeader",
                "tr"    => "cssItem"
                ),
            "removeDuplicate" => array("productLine"),
            "paging"=>array(
                "pageSize"  => 4,
                "pageIndex" => 0,
            ),
            "columns" => array(
                "tag2" => array(
                    "label" => "tag2",
                ),
                "quantite" => array(
                    "type"   => "number",
                    "label"  => "quantite",
                    "prefix" => "$",
                    "formatValue" => function($value,$row) {
                        $color = $value>40?"#718c00":"#e83e8c";
                        return "<span style='color:$color'>$".number_format($value)."</span>";
                    }
                )
            ),
        ));


        ?>
    </div>

</div>
<hr/>
