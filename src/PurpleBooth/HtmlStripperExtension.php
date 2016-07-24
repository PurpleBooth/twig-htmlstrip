<?php

namespace PurpleBooth;

/**
 * This is sets up the twig extension
 *
 * @package PurpleBooth
 */
class HtmlStripperExtension extends \Twig_Extension
{
    /**
     * This gets an array of the filters that this extension provides
     *
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html_strip', [$this, 'toText']),
        ];
    }

    /**
     * A convenient name for this extension
     *
     * @return string
     */
    public function getName()
    {
        return "html_stripper";
    }

    /**
     * This is the extension itself, it's mostly a small wrapper around the actual parser.
     *
     * @param string $html
     *
     * @return string
     */
    public function toText($html)
    {
        $parser = new Parser();

        $xmlParser = xml_parser_create();
        xml_set_element_handler($xmlParser, [$parser, 'startElement'], [$parser, 'endElement']);
        xml_set_character_data_handler($xmlParser, [$parser, 'characterData']);

        $wrappedHtml  = "<root>$html</root>";
        $returnStatus = xml_parse($xmlParser, $wrappedHtml, true);

        if (!$returnStatus) {
            return $html;
        }

        return $parser->getText();
    }
}
