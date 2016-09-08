<?php

namespace PurpleBooth;

/**
 * This is sets up the twig extension.
 */
class HtmlStripperExtension extends \Twig_Extension
{
    /**
     * @var HtmlStripper
     */
    private $htmlStripper;

    /**
     * HtmlStripperExtension constructor.
     */
    public function __construct()
    {
        $this->htmlStripper = new HtmlStripperImplementation();
    }

    /**
     * This gets an array of the filters that this extension provides.
     *
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('html_strip', [$this->htmlStripper, 'toText']),
        ];
    }

    /**
     * A convenient name for this extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'html_stripper';
    }

    /**
     * This is the extension itself, it's mostly a small wrapper around the actual parser.
     *
     * @see        https://github.com/PurpleBooth/htmlstrip
     * @deprecated v1.1.0 This will be removed in the future, please use the PurpleBooth/htmlstrip library
     *
     * @param string $html
     *
     * @return string
     */
    public function toText($html)
    {
        return $this->htmlStripper->toText($html);
    }
}
