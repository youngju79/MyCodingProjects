<?php
if(!isset($_GET["playlist"]) || empty($_GET["playlist"])){
    header("Location: playlists.php");
    exit();
}
else{
    require('../vendor/autoload.php');

    if (file_exists('../.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    }

    $pdo = new PDO($_ENV['PDO_CONNECTION_STRING']);

    $sql = "
        SELECT tracks.name AS track_name, albums.title AS album_title, artists.name AS artist_name, unit_price AS price, genres.name AS genre_name
        FROM playlist_track
        INNER JOIN tracks
            ON track_id = tracks.id
        INNER JOIN albums
            ON album_id = albums.id
        INNER JOIN artists
            ON artist_id = artists.id
        INNER JOIN genres
            ON genre_id = genres.id
        WHERE playlist_track.playlist_id = 
    " . $_GET["playlist"];

    $statement = $pdo->prepare($sql); // creating a prepared statement
    $statement->execute();
    $tracks = $statement->fetchall(PDO::FETCH_OBJ);
    if(empty($tracks)){
        $sql = "
            SELECT name
            FROM playlists
            WHERE id = 
        " . $_GET["playlist"];

        $statement = $pdo->prepare($sql); // creating a prepared statement
        $statement->execute();
        $playlist = $statement->fetchall(PDO::FETCH_OBJ);
        if(empty($playlist)){
            echo "<h1>Playlist does not exist</h1>";
        }
        else{
            echo "<h1>No tracks found for {$playlist[0]->name}</h1>";
        }
        exit();
    }
}

?>
<style>
    td{
        border: 1px solid black;
    }
    table{
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
</style>
<table>
  <thead>
    <tr>
      <th>Track Name</th>
      <th>Album Title</th>
      <th>Artist Name</th>
      <th>Price</th>
      <th>Genre Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($tracks as $track) : ?>
        <tr>
            <td><?php echo $track->track_name ?></td>
            <td><?php echo $track->album_title ?></td>
            <td><?php echo $track->artist_name ?></td>
            <td><?php echo $track->price ?></td>
            <td><?php echo $track->genre_name ?></td>
        </tr>
    <?php endforeach; ?>
  </tbody>
</table>