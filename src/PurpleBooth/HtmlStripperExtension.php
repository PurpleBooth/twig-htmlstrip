<?php

namespace PurpleBooth;

class HtmlStripperExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('html_strip', array($this, 'toText')),
        );
    }

    public function getName() {
        return "html_stripper";
    }

    public function toText($html)
    {
        $parser = new Parser();

        $xml_parser = xml_parser_create();
        xml_set_element_handler($xml_parser, array($parser, 'startElement'), array($parser, 'endElement'));
        xml_set_character_data_handler($xml_parser, array($parser, 'characterData'));

        $wrappedHtml = "<root>$html</root>";
        $returnStatus = xml_parse($xml_parser, $wrappedHtml, true);

        if(!$returnStatus) {
            return $html;
        }

        return $parser->getText();
    }
}
