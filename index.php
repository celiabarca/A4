<?php

require 'sys/DB.php';
use App\Sys\DB;
$gdb=DB::getInstance();

$db->query("INSERT INTO users (password,username , rol) VALUES (:name, :passwd, 2)");
$db->bind("passwd", "123");
$db->bind("name", "celia");

if($db->execute()) {
  echo "Insertado \n";
  $user = $db->lastInsertId();
} else {
  echo "Error \n";
  die;
}
$db->query("INSERT INTO comments (content, user, post, creation_date) VALUES (:cont, :user, :post, NOW())");
    $db->bind("cont", "creado");
    $db->bind("user", $userId);
    $db->bind("post", $postId);

if($db->execute()) {
  echo "Insertado!! \n";
} else {
  echo "Error\n";
  die;
}

$db->query("INSERT INTO posts (title, content, creation_date, user) VALUES (:titulo, :cont, NOW(), :user)");
$db->bind("titulo", "hola que hase");
$db->bind("cont", "bla bla kdvlkdlñdskñldsksdñlksdñlkdslñkdsñldskñldsksdkñdskddskldsñdñskd");
$db->bind("user", $userId);

if($db->execute()) {
    echo "insertado\n";
    $postId = $db->lastInsertId();
} else {
    echo "Error\n";
    die;
}

$db->query("INSERT INTO posts_tags (post, tag) VALUES (:post, :tag)");
$db->bind("tag", $tagId);
$db->bind("post", $postId);
if($db->execute()) {
    echo "insertado\n";
} else {
    echo "Error\n";
    die;
}
$db->query("SELECT * FROM posts WHERE user = :usuario");
$db->bind("usuario", $userId);
$db->execute();
$posts = $db->resultSet();
var_dump($posts);
//mostrar todos
$db->query("SELECT * FROM posts");
$db->execute();
$posts = $db->resultSet();
var_dump($posts);
