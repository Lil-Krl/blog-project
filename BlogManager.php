<?php
class BlogManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function loadData() {
        // Удаление старых данных
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->query("TRUNCATE TABLE comments");
        $this->db->query("TRUNCATE TABLE posts");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");

        $posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
        $comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);

        foreach ($posts as $post) {
            $this->db->insert("INSERT INTO posts (id, title, body) VALUES (?, ?, ?)", [
                $post['id'], $post['title'], $post['body']
            ]);
        }

        foreach ($comments as $comment) {
            $this->db->insert("INSERT INTO comments (id, post_id, body) VALUES (?, ?, ?)", [
                $comment['id'], $comment['postId'], $comment['body']
            ]);
        }

        return [
            'message' => 'Загружено ' . count($posts) . ' записей и ' . count($comments) . ' комментариев'
        ];
    }

    public function search($query) {
        if (strlen($query) < 3) {
            return [];
        }

        $sql = "
            SELECT posts.title, comments.body
            FROM posts
            JOIN comments ON posts.id = comments.post_id
            WHERE comments.body LIKE ?
        ";

        return $this->db->query($sql, ['%' . $query . '%'])->fetchAll();
    }
}
