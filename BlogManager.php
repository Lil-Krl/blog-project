<?php
class BlogManager
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function loadData()
    {
        $postsJson = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $commentsJson = file_get_contents('https://jsonplaceholder.typicode.com/comments');

        $posts = json_decode($postsJson, true);
        $comments = json_decode($commentsJson, true);

        try {
            $this->db->executeQuery("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->executeQuery("TRUNCATE TABLE comments");
            $this->db->executeQuery("TRUNCATE TABLE posts");
            $this->db->executeQuery("SET FOREIGN_KEY_CHECKS = 1");

            $postStmt = $this->db->getConnection()->prepare("INSERT INTO posts (id, user_id, title, body) VALUES (:id, :user_id, :title, :body)");
            foreach ($posts as $post) {
                $postStmt->execute([
                    ':id' => $post['id'],
                    ':user_id' => $post['userId'],
                    ':title' => $post['title'],
                    ':body' => $post['body'],
                ]);
            }

            $commentStmt = $this->db->getConnection()->prepare("INSERT INTO comments (id, post_id, name, email, body) VALUES (:id, :post_id, :name, :email, :body)");
            foreach ($comments as $comment) {
                $commentStmt->execute([
                    ':id' => $comment['id'],
                    ':post_id' => $comment['postId'],
                    ':name' => $comment['name'],
                    ':email' => $comment['email'],
                    ':body' => $comment['body'],
                ]);
            }

            return [
                'success' => true,
                'message' => "Загружено " . count($posts) . " записей и " . count($comments) . " комментариев.",
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => "Ошибка загрузки данных: " . $e->getMessage(),
            ];
        }
    }

    public function search($term)
    {
        if (strlen($term) < 3) {
            return [];
        }

        $query = "
            SELECT posts.title, comments.body 
            FROM posts
            JOIN comments ON posts.id = comments.post_id
            WHERE comments.body LIKE :term
        ";

        $stmt = $this->db->executeQuery($query, [':term' => '%' . $term . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
