<?php
if (!session_id()) {
  session_start();
}
include_once 'src/connect.php';
include_once 'control.php';

class News
{
  public static function delete(string $id) {
    global $conn;
    $sql = 
    "DELETE FROM news
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function update(
    string $id,
    string $title,
    string $category_id,
    string $summary,
    string $content
  ) {
    global $conn;
    $sql = 
    "UPDATE news
    SET title='$title',
    category_id = '$category_id',
    s_content = '$summary',
    l_content = '$content'
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getNewById(string $id)
  {
    global $conn;
    $sql =
      "SELECT * FROM news
    WHERE id = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getCategoryById(string $id)
  {
    global $conn;
    $sql = "SELECT * FROM categories
    WHERE id = $id
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getAuthorById(string $id)
  {
    $data = new Data();
    $run = $data->select_user_by_id($id);
    return $run;
  }
  public static function getAllNews()
  {
    global $conn;
    $sql =
      "SELECT news.* 
    FROM 
    news INNER JOIN users 
    ON news.user_id = users.id 
    WHERE users.email = '{$_SESSION['user']}'
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function getAllCategories()
  {
    global $conn;
    $sql = 'SELECT * FROM categories';
    $run = mysqli_query($conn, $sql);
    return $run;
  }
  public static function create(
    string $title,
    string $category_id,
    string $summary,
    string $content
  ) {
    global $conn;
    $data = new Data();
    $result = $data->select_user($_SESSION['user']);
    $user = mysqli_fetch_assoc($result);
    $date = date('Y/m/d');
    $user_id = $user['id'];
    $sql = "INSERT INTO
    news(category_id, user_id, title, s_content, l_content, date)
    VALUES
    ($category_id, $user_id, '$title', '$summary', '$content','$date')
    ";
    $run = mysqli_query($conn, $sql);
    return $run;
  }
}
