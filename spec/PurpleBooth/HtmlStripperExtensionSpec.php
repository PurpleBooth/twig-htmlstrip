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

    function it_converts_ul_to_txt() {
        $html = <<<HTML
<ul>
    <li>You're a good person</li>
    <li>Don't be too hard on yourself</li>
    <li>Enjoy the little things</li>
</ul>
HTML;
        $text = <<<TEXT
* You're a good person
* Don't be too hard on yourself
* Enjoy the little things
TEXT;

        $this->toText($html)->shouldReturn($text);
    }

    function it_puts_three_new_lines_after_a_div() {
        $html = <<<HTML
<div>Tomorrow will be better.</div>
You're doing your best, and I'm proud of you.
HTML;
        $text = <<<TEXT
Tomorrow will be better.


You're doing your best, and I'm proud of you.
TEXT;

        $this->toText($html)->shouldReturn($text);
    }

    function it_strips_other_tags() {
        $html = <<<HTML
<blockquote>It's always good to read a good book.</blockquote>
You are not here, <i>but I am thinking of you.</i>
HTML;

        $text = <<<TEXT
It's always good to read a good book. You are not here, but I am thinking of you.
TEXT;

        $this->toText($html)->shouldReturn($text);
    }


    function it_converts_complex_html_to_txt() {
        $html = <<<HTML
<div>
    <p>If she wants to <i>dance</i> and drink all night.</p>
    <ul>
        <li>Well theres no one that can stop her</li>
        <li>Shes going until the house lights come up or her stomach spills on to the floor</li>
        <li>This night is gonna end when we're damn well ready for it to be over</li>
        <li>Worked all week long now the music is playing on our time</li>
    </ul>
    <div><div>Hello</div><div>Fin.</div></div>
</div>
HTML;
        $text = <<<TEXT
If she wants to dance and drink all night.

* Well theres no one that can stop her
* Shes going until the house lights come up or her stomach spills on to the floor
* This night is gonna end when we're damn well ready for it to be over
* Worked all week long now the music is playing on our time


Hello


Fin.
TEXT;

        $this->toText($html)->shouldReturn($text);
    }
}
