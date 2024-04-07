<?php
    if (!isset($_SESSION["email"]) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] != 2)) {

        header("Location: restrictedAccess.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link rel="stylesheet" href="css/addMovie.css">
    <style>
        .custom-select select{
    display: none; /*hide original SELECT element:*/
}

.select-selected {
    background-color:#555;
}

  /*style the arrow inside the select element:*/
.select-selected:after {
    position: absolute;
    content: "";
    top: 14px;
    right: 10px;
    width: 0;
    height: 0;
    border: none;
    border-radius: 5px;
}

  /*style the arrow inside the select element:*/
.select-selected:after {
    position: absolute;
    content: "";
    top: 14px;
    right: 10px;
    width: 0;
    height: 0;
    border: none;
    border-radius: 5px;
    color: white;
}

  /*point the arrow upwards when the select box is open (active):*/
.select-selected.select-arrow-active:after {
    top: 7px;
}

  /*style the items (options), including the selected item:*/
.select-items div,.select-selected {
    color: #ffffff;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    user-select: none;
}

  /*style items (options):*/
.select-items {
    position: relative;
    background-color: #555;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 99;
}

  /*hide the items when the select box is closed:*/
.select-hide {
    display: none;
}
  
.select-items div:hover, .same-as-selected {
    background-color: rgba(0, 0, 0, 0.1);
}

textarea {
  width: calc(100% - 20px);
  height: 150px;
  padding: 8px;
  box-sizing: border-box;
  border: none;
    border-radius: 5px;
    background-color: #555;
    color: white;
    font-size: 16px;
  resize: none;
}
</style>
</head>
<body>
    <header>
        <a href="admin.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php" >MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="login.php">PROMOTIONS</a></li>
            </ul>
        </nav>
    </header>
    <form action="add.php" method="POST">
        <input type="text" name="movie_title" placeholder="Movie Title">
        <br>
        <input type="text" name="category" placeholder="Movie Category">
        <br>
        <input type="text" name="director" placeholder="Director">
        <br>
        <input type="text" name="producer" placeholder="Producer">
        <br>
        <textarea id="synopsis" name="synopsis" > Enter movie description here... </textarea>
        <br>
        <input type="text" name="reviews" placeholder="Reviews">
        <br>
        <input type="text" name="picture" placeholder="Picture link">
        <br>
        <input type="text" name="video" placeholder="Youtube Link">
        <br>
        <div class ="custom-select" style="width: calc(100% - 20px);">
            <select name="rating_code" id="rating_code">
                <option value="0">Select Rating</option>
                <option value="G">G</option>
                <option value="PG">PG</option>
                <option value="PG-13">PG-13</option>
                <option value="R">R</option>
                <option value="NR">NR</option>
            </select>
        </div>
        <br>
        <div class ="custom-select" style="width: calc(100% - 20px);">
            <select name="movie_status" id="movie_status">
                <option value="0">Select Movie Status</option>
                <option value="coming soon">Coming Soon</option>
                <option value="now playing">Now Playing</option>
            </select>
        </div>
        <br>
        <input type="text" name="cast" placeholder="Cast">
        <br>
        <button id = "submit" type="submit" name="submit"> Add </button>
</body>
<script>
var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>

</html>
