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

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO posts (text) VALUES ('{$this->getText()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $posts = [];
        $queried_posts = $GLOBALS['DB']->query('SELECT * FROM posts;');
        foreach ($queried_posts as $post) {
            $id = $post['id'];
            $text = $post['text'];
            $new_post = new Post($text, $id);
            array_push($posts, $new_post);
        }
        return $posts;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec('DELETE FROM posts');
    }

    static function find($search_id)
    {
        $found_post = null;
        $posts = Post::getAll();
        foreach ($posts as $post) {
            $post_id = $post->getId();
            if ($post_id == $search_id)
                $found_post = $post;
        }
        return $found_post;
    }
}
?>
