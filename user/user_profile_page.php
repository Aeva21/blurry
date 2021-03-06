<?php session_start() ?>
<?php require '../backend/config.php'; ?>
<?php require '../backend/html_prepare.php'; ?>
<?php require '../backend/functions.php'; ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">

<?php
if (isset($_GET['profile_remove'])) {
  echo removeProfile('../images/users/'.$_SESSION['email']);
}
?>

<head>
  <?php print $html_head ?>
</head>

<body>
  <?php print $html_header ?>
  <div id="content_profile_page">
    <div class="profile_pic">
      <img src="<?php print $_SESSION['profile_img_path'] ?>" alt="">
    </div>

    <table>
      <tr>
        <th>E-Mail:</th>
        <td><?php print $_SESSION['email'] ?></td>
      </tr>
      <tr>
        <th>Vorname:</th>
        <td><?php print $_SESSION['vorname'] ?></td>
      </tr>
      <tr>
        <th>Nachname:</th>
        <td><?php print $_SESSION['nachname'] ?></td>
      </tr>
    </table>
  </div>
  <div>
    <table class='img_list'>
      <tr>
        <th>Name:</th>
        <th>Ersteller:</th>
        <th>Upload-Datum:</th>
      </tr>
      <?php

      $conn = mysqli_connect("localhost", "root", "", "blurry");
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $email = $_SESSION['email'];
      $sql = "SELECT * from img_list WHERE img_creator = '$email' AND img_type = 'wallpaper'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td><img src=" . $row['img_path'] . "></td><td>" . $row['img_name'] . "</td><td>" . $row['img_creator'] . "</td><td>" . $row['uploaded_at'] . "</td><td><button >Bild Löschen</button></td></tr>";
        }
      } else {
        echo "<h1>Kein Eintrag gefunden</h1>";
      }

      $conn->close();
      ?>
    </table>
  </div>

  <form action="?profile_remove=1" method="post" enctype="multipart/form-data">
    <button type="submit">Profile Löschen</button>
  </form>


  <?php print $html_footer ?>
</body>

</html>