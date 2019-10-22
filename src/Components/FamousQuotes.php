<?php

namespace Src\Components;
use Predis\Client;

class FamousQuotes
{
    //Time in seconds to cache expires
    const CACHE_EXPIRES = 20;

    /**
     * List Quotes get the data from controller and work on it
     * @param string $name
     * @param string $count
     * @return array Quotes
     */
    public function listQuotes($name, $count)
    {
        //Convertion $count to int to validate rule for more than 10
        $intCount = intval($count);

        //If count param will more than 10, or non numeircal value, return false
        if($intCount == 0 || $intCount > 10)
            return false;
        
        $client = new Client();
        $key = strtolower($name);
        //Check if have cache of this author
        if($client->get($key)){
            $jsonFileData = json_decode($client->get($key));
        }else{
            //Send to a secondary method to get data from json
            $jsonFileData = $this->getJsonFileData($name);
            //Save data on Cache
            $client->set($key, json_encode($jsonFileData));
            $client->expire($key, self::CACHE_EXPIRES);
        }

        //I used array_slice to not return more than value setted on params
        return array_slice($jsonFileData, 0, $intCount);
    }

    /**
     * Ger Json File Data is responsible to get the quotes from the author that was passed by param
     * @param $name
     * @return array Quotes
     */
    private function getJsonFileData($name)
    {
        // I could put this call in some config file.
        $filePath = dirname(__DIR__) . '/Data/quotes.json';

        //Check if file exists. If not, return false
        if(!file_exists($filePath))
            return false;
        
        $response = array();
        //Prepare the name from URL to find on json file (Removing "-")
        $name = str_replace('-', ' ', $name);

        //Get Json and put it on array
        $jsonItem = file_get_contents($filePath);
        $objItems = json_decode($jsonItem);

        foreach ($objItems->quotes as $quote) {
            //Check if the author is the same. If positive, prepare the text to "shouting" a quote.
            if(strtolower($quote->author) == strtolower($name)){
                $text = in_array(substr($quote->quote, -1), array('.', '!', '?')) ? substr($quote->quote, 0, -1) : $quote->quote;
                $response[] = strtoupper($text) . '!';
            }
        }

        return $response;
    }
}