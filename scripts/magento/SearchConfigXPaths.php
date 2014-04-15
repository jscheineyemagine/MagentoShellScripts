<?php
require_once __DIR__ . '/abstract.php';

/**
 * Eyemagine shell script
 *
 * @category    Eyemagine
 * @package     Eyemagine_Shell
 * @author      Eyemagine Technology <magento@eyemaginetech.com>
 */
class Eyemagine_Shell_SearchConfigXPath extends Mage_Shell_Abstract
{
    /**
     * Run script
     *
     */
    public function run()
    {
        // Get the entire config.xml tree
        $config = Mage::app()->getConfig()->getNode()->asXML();

        // If we aren't searching, just print the entire config tree
        if( ! $this->getArg('search') )
        {
            echo $config;
        }
        else
        {
            // Convert from xml to associative array
            $ob = simplexml_load_string($config);
            $json = json_encode($ob);
            $configArray = json_decode($json, true);

            // Kick off the search function recursion.
            $terms = explode(',', $this->getArg('search'));
            $this->SearchConfigXPath($configArray, '',$terms);
        }
    }

    protected function SearchConfigXPath($anArray, $currentPath, $stringsToMatch)
    {
        // If we've reached a leaf node them check to see if it contains one of the strings to match
        if( ! is_array($anArray) )
        {
            $value = $anArray;
            $lineToAppend = $currentPath . ' : ' . $value;
            $matched = false;
            foreach($stringsToMatch as $stringToMatch)
            {
                $matched = ($matched || (strpos($lineToAppend, $stringToMatch) !== false) );
            }

            if ($matched) {
                echo $lineToAppend . "\n";
            }
            
        }
        // If we're not at a leaf keep traversing the configuration tree
        else
        {
            foreach ($anArray as $key => $value) {
                $path = $currentPath . '/' .  $key;
                $this->SearchConfigXPath($value, $path, $stringsToMatch);
            }
        }
    }
    public function getUsage()
    {
        return array_merge_recursive(parent::getUsage(), 
            array("commands" => 
                array(
                    "--search"        => "Comma seperated list of strings to search the config for"
                ),
                "extras" => array()
            )
        );
    }
}

$shell = new Eyemagine_Shell_SearchConfigXPath();
$shell->run();