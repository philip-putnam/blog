<?php
require_once 'src/Post.php';

class PostTest extends PHPUnit_Framework_TestCase
{
    function test_getId()
    {
        //Arrange
        $text = 'Hello world!';
        $id = 1;
        $test_Post = new Post($text, $id);

        //Act
        $result = $test_Post->getId();

        //Assert
        $this->assertEquals(1, $result);
    }

    function test_getText()
    {
        //Arrange
        $text = 'Hello world!';
        $test_Post = new Post($text);

        //Act
        $result = $test_Post->getText();

        //Assert
        $this->assertEquals('Hello world!', $result);
    }

    function test_setText()
    {
        //Arrange
        $text = 'Hello world!';
        $new_text = 'Goodbye world!';
        $test_Post = new Post($text);

        //Act
        $test_Post->setText($new_text);
        $result = $test_Post->getText();

        //Assert
        $this->assertEquals('Goodbye world!', $result);
    }
}
?>
