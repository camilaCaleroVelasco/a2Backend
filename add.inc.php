<?php
$host = 'localhost';  
$user = 'root';  
$pass = '';  
$db = 'movies';  

$conn = mysqli_connect($host, $user, $pass,$db);  

if(!$conn){  

  die('Could not connect: '.mysqli_connect_error());  

}  

echo 'Connected successfully<br/>';

$movie_title = $_POST['movie_title'];
$category = $_POST['category'];
$director = $_POST['director'];
$producer = $_POST['producer'];
$synopsis = $_POST['synopsis'];
$reviews = $_POST['reviews'];
$picture = $_POST['picture'];
$video = $_POST['video'];
$rating_code = $_POST['rating_code'];
$movie_status = $_POST['movie_status'];
$cast_1 = $_POST['cast_1'];
$cast_2 = $_POST['cast_2'];
$cast_3 = $_POST['cast_3'];
$cast_4 = $_POST['cast_4'];
$cast_5 = $_POST['cast_5'];


$sql = "INSERT INTO Movies(
    movie_title,
    category,
    director,
    producer,
    synopsis,
    reviews,
    picture,
    video,
    rating_code,
    movie_status
)
VALUES (
        '$movie_title',
        '$category',
        '$director',
        '$producer',
        '$synopsis',
        '$reviews',
        '$picture',
        '$video',
        '$rating_code',
        '$movie_status'
    );";
if(mysqli_query($conn, $sql)){  

 echo "Movie inserted successfully";  

}else{  

echo "Could not insert record: ". mysqli_error($conn);  

}  

$sql = "INSERT INTO Movie_Cast(cast1, cast2, cast3, cast4, cast5)
        VALUES(
        '$cast_1',
        '$cast_2',
        '$cast_3',
        '$cast_4',
        '$cast_5'
    );";

if(mysqli_query($conn, $sql)){  

    echo "Movie Cast record inserted successfully";  
   
   } else{  
   
   echo "Could not insert record: ". mysqli_error($conn);  
   
   }  
   mysqli_close($conn);  
    
   header("Location: ../adminmovie.php?sigup=success");

