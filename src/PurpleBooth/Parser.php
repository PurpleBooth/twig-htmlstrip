<?php

namespace PurpleBooth;


class Parser {

    private $text = "";
    private $currentBlockStack;

    public function __construct() {
        $this->currentBlockStack = new \SplStack();
    }

    public function startElement($parser, $name, $attrs)
    {
        $this->blockBegin();

        switch($name) {
            case "LI":
                $this->appendToCurrentBlock("* ");
                break;
        }
    }

    public function endElement($parser, $name)
    {
        switch($name) {
            case "P":
                $this->appendToCurrentBlock("\n\n");
                break;
            case "UL":
                $this->appendToCurrentBlock("\n\n");
                break;
            case "LI":
                $this->appendToCurrentBlock("\n");
                break;
            case "DIV":
                $this->appendToCurrentBlock("\n\n\n");
                break;
        }

        $blockContent = $this->blockFinished();

        if(count($this->currentBlockStack)) {
            $this->appendToCurrentBlock($blockContent);
        }
        else {
            $this->text .= $blockContent;
        }
    }

    public function characterData($parser, $data)
    {
        $this->appendToCurrentBlock(str_replace("\n", " ", $data));
    }

    public function getText() {
        $text = trim($this->text);
        $lines = explode("\n", $text);

        return implode("\n", array_map("trim", $lines));
    }

    private function appendToCurrentBlock($value) {
        $this->setCurrentBlock($this->getCurrentBlock() . $value);
    }

    private function setCurrentBlock($value) {
        $this->currentBlockStack->pop();
        $this->currentBlockStack->push($value);
    }

    private function getCurrentBlock() {
        return $this->currentBlockStack->top();
    }

    private function blockBegin() {
        $this->currentBlockStack->push("");
    }

    private function blockFinished() {
        return $this->currentBlockStack->pop();
    }
} 