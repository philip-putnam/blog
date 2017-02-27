<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once 'src/Tag.php';
require_once 'src/Post.php';

$server = 'mysql:host=localhost:8889;dbname=blog_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class TagTest extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Tag::deleteAll();
        Post::deleteAll();
    }

    function test_getId()
    {
        $name = 'Travel';
        $id = 1;
        $test_Tag = new Tag($name, $id);

        //Act
        $result = $test_Tag->getId();

        //Assert
        $this->assertEquals(1, $result);
    }

    function test_getName()
    {
        //Arrange
        $name = 'Travel';
        $test_Tag = new Tag($name);

        //Act
        $result = $test_Tag->getName();

        //Assert
        $this->assertEquals('Travel', $result);
    }

    function test_setName()
    {
        //Arrange
        $name = 'Travel';
        $new_name = 'Work';
        $test_Tag = new Tag($name);

        //Act
        $test_Tag->setName($new_name);
        $result = $test_Tag->getName();

        //Assert
        $this->assertEquals('Work', $result);
    }

    function test_save()
    {
        //Arrange
        $name = 'Travel';
        $test_Tag = new Tag($name);

        //Act
        $test_Tag->save();
        $result = Tag::getAll();

        //Assert
        $this->assertEquals([$test_Tag], $result);
    }

    function test_getAll()
    {
        //Arrange
        $name1 = 'Travel';
        $name2 = 'Work';
        $test_Tag1 = new Tag($name1);
        $test_Tag1->save();
        $test_Tag2 = new Tag($name2);
        $test_Tag2->save();

        //Act
        $result = Tag::getAll();

        //Assert
        $this->assertEquals([$test_Tag1, $test_Tag2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $name1 = 'Travel';
        $name2 = 'Work';
        $test_Tag1 = new Tag($name1);
        $test_Tag1->save();
        $test_Tag2 = new Tag($name2);
        $test_Tag2->save();

        //Act
        Tag::deleteAll();
        $result = Tag::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    function test_find()
    {
        //Arrange
        $name1 = 'Travel';
        $name2 = 'Work';
        $test_Tag1 = new Tag($name1);
        $test_Tag1->save();
        $test_Tag2 = new Tag($name2);
        $test_Tag2->save();

        //Act
        $result = Tag::find($test_Tag1->getId());

        //Assert
        $this->assertEquals($test_Tag1, $result);
    }

    function test_update()
    {
        //Arrange
        $name = 'Travel';
        $new_name = 'Work';
        $test_Tag = new Tag($name);
        $test_Tag->save();

        //Act
        $test_Tag->update($new_name);
        $result = $test_Tag->getName();

        //Assert
        $this->assertEquals('Work', $result);
    }

    function test_delete()
    {
        //Arrange
        $name1 = 'Travel';
        $name2 = 'Work';
        $test_Tag1 = new Tag($name1);
        $test_Tag1->save();
        $test_Tag2 = new Tag($name2);
        $test_Tag2->save();

        //Act
        $test_Tag1->delete();
        $result = Tag::getAll();

        //Assert
        $this->assertEquals([$test_Tag2], $result);
    }

    function test_addPost()
    {
        //Arrange
        $name = 'Travel';
        $test_Tag = new Tag($name);
        $test_Tag->save();

        $text = 'Hello world!';
        $test_Post = new Post($text);
        $test_Post->save();

        $text2 = 'Goodbye world!';
        $test_Post2 = new Post($text2);
        $test_Post2->save();

        //Act
        $test_Tag->addPost($test_Post);
        $result = $test_Tag->getPosts();

        //Assert
        $this->assertEquals([$test_Post], $result);
    }

    function test_getPosts()
    {
        //Arrange
        $name = 'Travel';
        $test_Tag = new Tag($name);
        $test_Tag->save();

        $text = 'Hello world!';
        $test_Post = new Post($text);
        $test_Post->save();

        $text2 = 'Goodbye world!';
        $test_Post2 = new Post($text2);
        $test_Post2->save();

        //Act
        $test_Tag->addPost($test_Post);
        $test_Tag->addPost($test_Post2);
        $result = $test_Tag->getPosts();

        //Assert
        $this->assertEquals([$test_Post, $test_Post2], $result);
    }

    function test_delete_posts()
    {
        //Arrange
        $name1 = 'Travel';
        $test_Tag1 = new Tag($name1);
        $test_Tag1->save();
        $name2 = 'Work';
        $test_Tag2 = new Tag($name2);
        $test_Tag2->save();

        $text = 'Hello world!';
        $test_Post = new Post($text);
        $test_Post->save();
        $test_Post->addTag($test_Tag1);
        $test_Post->addTag($test_Tag2);

        //Act
        $test_Tag1->delete();
        $result = $test_Post->getTags();

        //Assert
        $this->assertEquals([$test_Tag2], $result);
    }
}
?>
