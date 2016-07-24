<?php

namespace PurpleBooth;

/**
 * This class is designed to by hooked into an XML parser to convert HTML to text.
 *
 * @see     xml_parser_create()
 * @see     HtmlStripperExtension
 *
 * @package PurpleBooth
 */
class Parser
{

    /**
     * @var string
     */
    private $text = "";

    /**
     * @var \SplStack
     */
    private $transformedTextStack;

    /**
     * @var \SplStack
     */
    private $blockTypeStack;

    /**
     * @var \SplStack
     */
    private $blockAttributesStack;

    /**
     * Parser constructor.
     *
     * Sets up the stacks
     */
    public function __construct()
    {
        $this->transformedTextStack = new \SplStack();
        $this->blockTypeStack       = new \SplStack();
        $this->blockAttributesStack = new \SplStack();
    }

    /**
     * Function called on the start of an element
     *
     * Mostly used to prepend text to things, like the "*"s on LIs
     *
     * @see xml_set_element_handler()
     *
     * @param resource $parser
     * @param string   $name
     * @param array    $attrs
     */
    public function startElement($parser, $name, $attrs)
    {
        $this->blockBegin($name, $attrs);

        switch ($name) {
            case "LI":
                $this->appendBlockText("* ");
                break;
        }
    }

    /**
     * Called when we begin a block.
     *
     * We build a series of stacks to represent the tree of the document
     *
     * We operate at this level of the stack when we're editing content
     *
     * @param string $name
     * @param array  $attributes
     */
    private function blockBegin($name, $attributes)
    {
        $this->transformedTextStack->push("");
        $this->blockTypeStack->push($name);
        $this->blockAttributesStack->push($attributes);
    }

    /**
     * Append some text to the current level of the stack
     *
     * @param string $value
     */
    private function appendBlockText($value)
    {
        $this->setBlockText($this->getBlockText() . $value);
    }

    /**
     * Set the text for a block
     *
     * @param string $value
     */
    private function setBlockText($value)
    {
        $this->transformedTextStack->pop();
        $this->transformedTextStack->push($value);
    }

    /**
     * Get the current text that's in this block
     *
     * @return string
     */
    private function getBlockText()
    {
        return $this->transformedTextStack->top();
    }

    /**
     * When we reach a closing element do something
     *
     * This is mostly used to add stuff to the end of a statement, like putting new lines where div tags close
     *
     * @see xml_set_element_handler()
     *
     * @param resource $parser
     * @param string   $name
     */
    public function endElement($parser, $name)
    {
        switch ($name) {
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

                if (isset($attrs['HREF'])) {
                    $this->appendBlockText(" ({$attrs['HREF']})");
                }
        }

        $blockContent = $this->blockFinished();

        if (count($this->transformedTextStack)) {
            $this->appendBlockText($blockContent);
        } else {
            $this->text .= $blockContent;
        }
    }

    /**
     * Get the transformed text off the stack, and clear down the other stacks
     *
     * @return string
     */
    private function blockFinished()
    {
        $transformedText = $this->transformedTextStack->pop();
        $this->blockTypeStack->pop();
        $this->blockAttributesStack->pop();

        return $transformedText;
    }

    /**
     * This converts character data to human character data
     *
     * Primarily this is used for removing newlines and replacing them with spaces.
     *
     * @see xml_set_character_data_handler()
     *
     * @param resource $parser
     * @param string   $data
     */
    public function characterData($parser, $data)
    {
        $this->appendBlockText(str_replace("\n", " ", $data));
    }

    /**
     * This gets the text that has been parsed and returns it
     *
     * @return string
     */
    public function getText()
    {
        $text  = trim($this->text);
        $lines = explode("\n", $text);

        return implode("\n", array_map("trim", $lines));
    }
}
