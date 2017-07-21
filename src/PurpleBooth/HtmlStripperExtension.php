<?php

/*
 * Copyright (C) 2016 Billie Thompson
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace PurpleBooth;

use ReflectionClass;

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
     * It'll return Twig_SimpleFilter on versions of twig less than ^1.0.0 of twig, and Twig_Filter on versions of
     * twig ^2.0.0
     *
     * @return \Twig_SimpleFilter[]|\Twig_Filter[]
     */
    public function getFilters()
    {
        $filters = [];

        $reflection = new ReflectionClass('\Twig_Filter');
        if ($reflection->isInstantiable()) {
            $filters[] = new \Twig_Filter(
                'html_strip',
                [$this->htmlStripper, 'toText']
            );
        } else {
            // BC Twig ^1.0.0
            $filters[] = new \Twig_SimpleFilter(
                'html_strip',
                [$this->htmlStripper, 'toText']
            );
        }

        return $filters;
    }

    /**
     * A convenient name for this extension.
     *
     * BC Twig ^v1.0.0
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
