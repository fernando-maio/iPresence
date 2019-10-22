<?php

namespace Src\Controllers;

use Src\Components\FamousQuotes;

class ParamsController
{
    /**
     * Author Controler is responsible to get the arguments, delivery to componets works and return what is expected.
     * @param array $request 
     * @param array $response 
     * @param array $args 
     */
    public function author($request, $response, $args)
    {
        // New instance of component
        $famous = new FamousQuotes;
        $quotes = $famous->listQuotes($args['params'], $request->getQueryParams()['count']);

        //API return
        echo json_encode($quotes);
    }
}
