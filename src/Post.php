<?php
class Post
{
    private $id;
    private $text;

    function __construct($text, $id = null)
    {
        $this->text = $text;
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function getText()
    {
        return $this->text;
    }

    function setText($new_text)
    {
        $this->text = $new_text;
    }
}
?>
