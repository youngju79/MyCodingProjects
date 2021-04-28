<?php 

require('../vendor/autoload.php');

if (file_exists('../.env')) {
  $dotenv = \Dotenv\Dotenv::createImmutable('../');
  $dotenv->load();
}

$pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);

$sql = "
  SELECT id, name
  FROM playlists;
";

$statement = $pdo->prepare($sql); // creating a prepared statement
$statement->execute();
$playlists = $statement->fetchall(PDO::FETCH_OBJ);

?>
<style>
  table{
    padding: 5px 10px;
  }
  .names{
    padding-left: 20px;
  }
</style>
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($playlists as $playlist) : ?>
        <tr>
            <td><?php echo $playlist->id ?></td>
            <td class="names">
              <?php echo "<a href=\"tracks.php?playlist=$playlist->id\">$playlist->name</a>" ?>
            </td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>