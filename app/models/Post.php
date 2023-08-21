<?php
    class Post {
        private $db;

        public function __construct() {
            $this->db = new Database;

        }

        public function getPosts() {
            $this->db->query('SELECT *,
                            posts.id as postId,
                            users.id as userId,
                            posts.createdDate as postCreated,
                            users.createdDate as userCreated
                            FROM posts
                            INNER JOIN users
                            ON posts.userId = users.id
                            ORDER BY posts.createdDate DESC');

            $results = $this->db->resultSet();
            return $results;

        }

        public function addPost($data) {
            
            $this->db->query('INSERT INTO posts (title, userId, body) VALUES (:title, :userId, :body)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':userId', $data['userId']);
            $this->db->bind(':body', $data['body']);
            
            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }

        }

        public function getPostById($id) {
            $this->db->query('SELECT * from posts WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();
            
            return $row;
        }

        public function updatePost($data) {

            $this->db->query('UPDATE posts SET title = :title, body = :body WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            
            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function deletePost($id) {
            $this->db->query('DELETE FROM posts WHERE id = :id');
            $this->db->bind(':id', $id);
            
            // execute
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

    }