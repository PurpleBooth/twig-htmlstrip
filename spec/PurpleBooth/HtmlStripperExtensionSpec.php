<?php

namespace spec\PurpleBooth;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HtmlStripperExtensionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PurpleBooth\HtmlStripperExtension');
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('html_stripper');
    }

    function it_converts_html_to_txt() {
        $this->toText("<p>Hello, world.</p>")->shouldReturn("Hello, world.");
    }
}
