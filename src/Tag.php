<?php
class Tag
{
    private $id;
    private $name;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO tags (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name)
    {
        $GLOBALS['DB']->exec("UPDATE tags SET name = '{$new_name}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
    }

    static function getAll()
    {
        $tags = [];
        $queried_tags = $GLOBALS['DB']->query('SELECT * FROM tags;');

        foreach($queried_tags as $tag)
        {
            $name = $tag['name'];
            $id = $tag['id'];
            $new_tag = new Tag($name, $id);
            array_push($tags, $new_tag);
        }
        return $tags;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec('DELETE FROM tags;');
    }

    static function find($search_id)
    {
        $found_tag = null;
        $tags = Tag::getAll();
        foreach($tags as $tag)
        {
            $tag_id = $tag->getId();
            if ($tag_id == $search_id)
                $found_tag = $tag;
        }
        return $found_tag;
    }
}
?>
