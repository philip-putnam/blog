<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Post.php';

$server = 'mysql:host=localhost:8889;dbname=blog_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class PostTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Post::deleteAll();
    }

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

    function test_save()
    {
        //Arrange
        $text = 'Hello world!';
        $test_Post = new Post($text);

        //Act
        $test_Post->save();
        $result = Post::getAll();

        //Assert
        $this->assertEquals([$test_Post], $result);
    }

    function test_getAll()
    {
        //Arrange
        $text1 = 'Hello world!';
        $text2 = 'Goodbye world!';
        $test_Post1 = new Post($text1);
        $test_Post1->save();
        $test_Post2 = new Post($text2);
        $test_Post2->save();

        //Act
        $result = Post::getAll();

        //Assert
        $this->assertEquals([$test_Post1, $test_Post2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $text1 = 'Hello world!';
        $text2 = 'Goodbye world!';
        $test_Post1 = new Post($text1);
        $test_Post1->save();
        $test_Post2 = new Post($text2);
        $test_Post2->save();

        //Act
        Post::deleteAll();
        $result = Post::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $text1 = 'Hello world!';
        $text2 = 'Goodbye world!';
        $test_Post1 = new Post($text1);
        $test_Post1->save();
        $test_Post2 = new Post($text2);
        $test_Post2->save();

        //Act
        $result = Post::find($test_Post1->getId());

        //Assert
        $this->assertEquals($test_Post1, $result);
    }
}
?>
