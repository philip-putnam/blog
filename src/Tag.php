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

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM tags WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM posts_tags WHERE tag_id = {$this->getId()};");
    }

    function addPost($post)
    {
        $GLOBALS['DB']->exec("INSERT INTO posts_tags (post_id, tag_id) VALUES ({$post->getId()}, {$this->getId()});");
    }

    function getPosts()
    {
        $query = $GLOBALS['DB']->query("SELECT post_id FROM posts_tags WHERE tag_id = {$this->getId()};");
        $post_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];
        foreach($post_ids as $id) {
            $post_id = $id['post_id'];
            $result = $GLOBALS['DB']->query("SELECT * FROM posts WHERE id = {$post_id};");
            $returned_post = $result->fetchAll(PDO::FETCH_ASSOC);

            $id = $returned_post[0]['id'];
            $text = $returned_post[0]['text'];
            $new_post = new Post($text, $id);
            array_push($posts, $new_post);
        }
        return $posts;
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
