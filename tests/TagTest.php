<?php
require_once 'src/Tag.php';

class TagTest extends PHPUnit_Framework_TestCase
{
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
}
?>
