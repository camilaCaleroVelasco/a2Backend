<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
  
</head>

<body>
    <header>
        <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  
        <nav>
            <ul class="nav__links">
                <li><a href="booking.php">Placeholder</a></li>
                <li><a href="#">MOVIES</a></li>
                <li><a href="#">ADMIN</a></li>
                <li><a href="login.php">LOGIN</a></li> <!-- Link to the login page -->
                <li class="search">
                    <form action="search.php" method="POST"> <!-- Specify the action and method for the form -->
                        <input id="search" type="text" name="moviesearch" placeholder="Search Movies">
                    </form>
                </li>
               
            </ul>
        </nav>
    </header>


    <!-- Creating Container to Hold now showing movies --> 
    
    <div class = "containter">   <!-- div class container starts here -->
        <div class = "content-holder">
            <div class="now-playing-movies">
                <h1 class ="movies-type-title"> NOW PLAYING</h1>
                <div class =" movies-list-wrapper">
                    <div class ="movies-list">
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <button id="imageButton" onclick="search.php">
                                <img class="movies-poster-img" src="images/MeanGirls.jpeg" alt = "button image">
                            </button>
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/PoorThings.jpeg" alt = "">

                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/ABY.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Oppenheimer.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/MadameWeb.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/MarleyOneLove.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">


                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/BeeKeeper.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">           

                            <!-- Place Holder Image for Movies-->
                            
                            <img class="movies-poster-img" src="images/Wonka.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Frankenstein.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/TheChoosen.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/LandOfBad.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Argylle.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/OrdinaryAngels.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/AmericanFiction.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/OutOFDarkness.jpeg" alt = "">
                        </div>

                    </div>

                    <!-- Icon from Awesome Icons -->
                    <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                </div>    
            </div>

            <div class="now-playing-movies">
                <h1 class ="movies-type-title"> COMING SOON</h1>
                <div class =" movies-list-wrapper">
                    <div class ="movies-list">
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies will eventually be replaced by posters from an API--> 
                            <img class="movies-poster-img" src="images/Dune.jpeg" alt = "">
                           
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Wicked.jpeg" alt = "">

                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/PlanetOfApes.jpeg" alt = "">
                        </div>
                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/GhostBusters.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Imaginary.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/GodZilla.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Cabrini.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/NightShift.jpeg" alt = "">
                        </div> 

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Mickey17.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/KungFuPanda.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/InsideOut2.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Challengers.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/Furiosa.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/QuietPlace.jpeg" alt = "">
                        </div>

                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/If.jpeg" alt = "">
                        </div>


                        <div class = "movies-list-item">

                            <!-- Place Holder Image for Movies-->
                            <img class="movies-poster-img" src="images/ArthurTheKing.jpeg" alt = "">
                        </div>

                    </div>
                     <!-- Icon from Awesome Icons -->
                    <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                        d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                </div>    
            </div>
        </div>
    </div>  <!-- div class container ends here -->


<script src="javascript/index.js"></script>
<script> 

</script>
</body>
</html>