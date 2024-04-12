<?php
  require_once "includes/dbh.inc.php";
  require_once "functions/searchFunctions.php";
  include_once 'editProfileProcess.php';

  // Initialize the $results variable
  $results = array();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check if search term and filter are provided
      if(isset($_POST["now-playing-button"]) || isset($_POST["coming-soon-button"])) {
          $search = $_SESSION['search'];

          // Filter based on both search term and filter
          if(isset($_POST["coming-soon-button"])) {
              $results = filterMoviesByStatus($conn, "coming soon", $search);
              if($results == false) {
                  $results = filterMoviesByCategory($conn, "coming soon", $search);
              }

          } elseif(isset($_POST["now-playing-button"])) {
              $results = filterMoviesByStatus($conn, "now playing", $search);
              if($results == false) {
                  $results = filterMoviesByCategory($conn, "now playing", $search);
              }
          }
      }
      // Check if only search term is provided
      elseif(isset($_POST["moviesearch"])) {
          $_SESSION['search'] = $_POST["moviesearch"];

          $search = $_POST["moviesearch"];

          $results = searchMovieTitle($conn, $search);
          //var_dump($results);
          if($results == false) {
              $results = searchMovieCategory($conn,$search);
          }
      }
  } 