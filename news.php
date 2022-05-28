<?php
session_start();
include 'src/control.php';
include 'src/new.php';
if (empty($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}
$state = !empty($_GET['state']) ? $_GET['state'] : '';


?>
<!DOCTYPE html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
  <meta charset="UTF-8">
  <title>About - Bhaccasyoniztas Beach Resort Web Template</title>
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/main.css">
  <style>
    * {
      margin: 0;
      box-sizing: border-box;
    }

    .m-b {
      margin-bottom: 16px;
    }

    .width-100 {
      width: 100%;
    }

    .row {
      margin: 12px 0;
      display: flex;
      justify-content: space-between;
    }

    .row.j-center {
      display: flex;
      justify-content: center;
    }

    .row .left {
      width: 40%;
      text-align: right;
    }

    .row .right {
      width: 50%;
    }

    form {
      border: 1px solid #5a4535;
      padding: 20px;
      display: flex;
      flex-direction: column;
    }

    input {
      padding: 4px;
    }

    input[type="submit"] {
      background-color: #868fff;
      padding: 8px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    #contents {
      width: 100%;
    }

    textarea {
      resize: none;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table td {
      text-align: justify;
    }

    .btn-primary {
      display: inline-block;
      padding: 8px 12px;
      background-color: #0d6efd;
      color: white;
      border-radius: 4px;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div id="background">
    <div id="page">
      <?php include 'src/header.php' ?>
      <div id="contents">
        <div class="box">
          <div>
            <div class="body main">
              <?php if ($state == 'new' || $state == 'update') {
                if ($state == 'update') {
                  if (empty($_GET['id'])) {
                    echo '<script>
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=update&id=${id}`
                      } else {
                        window.location.href = `news.php`
                      }
                    } while(!id);
                    </script>';
                    exit();
                  }
                  $result = News::getNewById($_GET['id']);
                  $new = mysqli_fetch_assoc($result);
                  if (empty($new)) {
                    echo '<script>
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=update&id=${id}`
                      } else {
                        window.location.href = `news.php`
                      }
                    } while(id === "")
                    </script>';
                    exit();
                  }
                }
              ?>
                <?php if ($state == 'update') { ?>
                  <h1>Update Post</h1>
                <?php } else { ?>
                  <h1>New Post</h1>
                <?php } ?>
                <form action="" method="post" autocomplete="off">
                  <?php if ($state == 'update') { ?>
                    <input hidden type="text" name="txt_id" value="<?= isset($new) ? $new['id'] : '' ?>">
                  <?php } ?>
                  <div class="row">
                    <div class="left">Title</div>
                    <div class="right">
                      <input required type="text" name="txt_title" value="<?= isset($new) ? $new['title'] : '' ?>">
                    </div>
                  </div>
                  <div class="row">
                    <div class="left">Category</div>
                    <div class="right">
                      <select name="txt_category">
                        <?php
                        $result = News::getAllCategories();
                        foreach ($result as $row) {
                          $is_selected = '';
                          if ($state == 'update' && $row['id'] == $new['category_id']) {
                            $is_selected = 'selected';
                          }
                          echo "
                          <option $is_selected value='{$row['id']}'>{$row['name']}</option>
                          ";
                        } ?>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="left">Summary</div>
                    <div class="right">
                      <textarea name="txt_summary" cols="30" rows="8"><?= isset($new) ? $new['s_content'] : '' ?></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="left">Content</div>
                    <div class="right">
                      <textarea name="txt_content" required cols="30" rows="8"><?= isset($new) ? $new['l_content'] : '' ?></textarea>
                    </div>
                  </div>
                  <div class="row j-center">
                    <input type="submit" name="txt_submit" value="<?php echo $state == 'new' ? 'Create' : 'Update' ?>">
                  </div>
                  <?php
                  if ($state == 'new') {
                    if (!empty($_POST['txt_submit'])) {
                      $result = News::create(
                        $_POST['txt_title'],
                        $_POST['txt_category'],
                        $_POST['txt_summary'],
                        $_POST['txt_content']
                      );
                      if ($result) {
                        echo '<script>alert("thanhcong")</script>';
                        echo '<script>window.location.href = "news.php"</script>';
                      } else {
                        echo '<script>alert("thatbai")</script>';
                      }
                    }
                  } else if ($state == 'update') {
                    if (!empty($_POST['txt_submit'])) {
                      $result = News::update(
                        $_POST['txt_id'],
                        $_POST['txt_title'],
                        $_POST['txt_category'],
                        $_POST['txt_summary'],
                        $_POST['txt_content']
                      );
                      if ($result) {
                        echo '<script>alert("thanhcong")</script>';
                        echo '<script>window.location.href = "news.php"</script>';
                      } else {
                        echo '<script>alert("thatbai")</script>';
                      }
                    }
                  }
                  ?>
                </form>
              <?php
              } else if ($state == 'delete') {
                if (empty($_GET['id'])) {
                  echo '<script>
                    do {
                      var id = window.prompt("Vui long nhap id hop le: ");
                      if (id) {
                        window.location.href = `news.php?state=delete&id=${id}`
                      } else {
                        window.location.href = `news.php`
                      }
                    } while(!id);
                    </script>';
                  exit();
                }
                $result = News::delete($_GET['id']);
                if ($result) {
                  echo '
                  <script>window.location.href = `news.php`</script>
                  ';
                } else {
                  echo '
                  <script>window.alert("Xay ra loi khi xoa")</script>
                  ';
                }
              } else { ?>

                <table class="table m-b" border="1" cellspacing="0" , cellpadding="4">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Title</th>
                      <th>Summary</th>
                      <th>Content</th>
                      <th>Date</th>
                      <th>Category</th>
                      <!-- <th>Author</th> -->
                      <th>State</th>
                      <th>View</th>
                      <th colspan="2">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result = News::getAllNews();
                    foreach ($result as $new) {
                      // $result = News::getAuthorById($new['user_id']);
                      // $author = mysqli_fetch_assoc($result);
                      $result = News::getCategoryById($new['category_id']);
                      $category = mysqli_fetch_assoc($result);
                    ?>
                      <tr>
                        <td><?= $new['id'] ?></td>
                        <td><?= $new['title'] ?></td>
                        <td><?= $new['s_content'] ?></td>
                        <td><?= $new['l_content'] ?></td>
                        <td><?= $new['date'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <!-- <td><?= $author['username'] ?></td> -->
                        <td><?= $new['state'] ?></td>
                        <td><?= $new['number'] ?></td>
                        <td>
                          <a href="?state=update&id=<?= $new['id'] ?>">Sửa</a>
                        </td>
                        <td>
                          <a href="?state=delete&id=<?= $new['id'] ?>" class="delete-btn">Xóa</a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div style="text-align: center;">
                  <a href="?state=new" class="btn-primary">New</a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'src/footer.php' ?>
  </div>
  <script src="js/main.js"></script>
</body>

</html>