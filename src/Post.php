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

    function update($new_text)
    {
        $GLOBALS['DB']->exec("UPDATE posts SET text = '{$new_text}' WHERE id = {$this->getId()};");
        $this->setText($new_text);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM posts WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM posts_tags WHERE post_id = {$this->getId()};");
    }

    function addTag($tag)
    {
        $GLOBALS['DB']->exec("INSERT INTO posts_tags (post_id, tag_id) VALUES ({$this->getId()}, {$tag->getId()});");
    }

    function getTags()
    {
        $query = $GLOBALS['DB']->query("SELECT tag_id FROM posts_tags WHERE post_id = {$this->getId()};");
        $tag_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $tags = [];
        foreach($tag_ids as $id) {
            $tag_id = $id['tag_id'];
            $result = $GLOBALS['DB']->query("SELECT * FROM tags WHERE id = {$tag_id};");
            $returned_tag = $result->fetchAll(PDO::FETCH_ASSOC);

            $id = $returned_tag[0]['id'];
            $name = $returned_tag[0]['name'];
            $new_tag = new Tag($name, $id);
            array_push($tags, $new_tag);
        }
        return $tags;
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
