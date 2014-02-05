<?php

namespace PurpleBooth;


class Parser {

    private $text = "";
    private $transformedTextStack;
    private $blockTypeStack;
    private $blockAttributesStack;

    public function __construct() {
        $this->transformedTextStack = new \SplStack();
        $this->blockTypeStack = new \SplStack();
        $this->blockAttributesStack = new \SplStack();
    }

    public function startElement($parser, $name, $attrs)
    {
        $this->blockBegin($name, $attrs);

        switch($name) {
            case "LI":
                $this->appendBlockText("* ");
                break;
        }
    }

    public function endElement($parser, $name)
    {
        switch($name) {
            case "P":
                $this->appendBlockText("\n\n");
                break;
            case "UL":
                $this->appendBlockText("\n\n");
                break;
            case "LI":
                $this->appendBlockText("\n");
                break;
            case "DIV":
                $this->appendBlockText("\n\n\n");
                break;
            case "A":
                $attrs = $this->blockAttributesStack->top();

                if(isset($attrs['HREF'])) {
                    $this->appendBlockText(" ({$attrs['HREF']})");
                }
        }

        $blockContent = $this->blockFinished();

        if(count($this->transformedTextStack)) {
            $this->appendBlockText($blockContent);
        }
        else {
            $this->text .= $blockContent;
        }
    }

    public function characterData($parser, $data)
    {
        $this->appendBlockText(str_replace("\n", " ", $data));
    }

    public function getText() {
        $text = trim($this->text);
        $lines = explode("\n", $text);

        return implode("\n", array_map("trim", $lines));
    }

    private function appendBlockText($value) {
        $this->setBlockText($this->getBlockText() . $value);
    }

    private function setBlockText($value) {
        $this->transformedTextStack->pop();
        $this->transformedTextStack->push($value);
    }

    private function getBlockText() {
        return $this->transformedTextStack->top();
    }

    private function blockBegin($name, $attributes) {
        $this->transformedTextStack->push("");
        $this->blockTypeStack->push($name);
        $this->blockAttributesStack->push($attributes);
    }

    private function blockFinished() {
        return $this->transformedTextStack->pop();
        return $this->blockTypeStack->pop();
        return $this->blockAttributesStack->pop();
    }
} 