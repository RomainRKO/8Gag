<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>8 GAG</title>
        <link rel="stylesheet" href="css/index.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/navbar_btn.css">
        <link rel="stylesheet" href="css/tags_btn.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    </head>

    <body>
        <header>
            <div class="navbar">
                <div id="logoandlinks">

                    <div class="logo" style="height:100px;"><img src="img/8gag.png" alt="#header"></div>
                    <?php 
                    require 'connect.php';
                    if (isset($_SESSION['connected'])){
                        $req = $dbh->prepare('SELECT * FROM users where id = :id');
                        $req->execute([
                            ':id' => $_SESSION['id']]);
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                            echo '<h2 style="color: rgba(255, 85, 85, 0.85)">WELCOME   '.$item['name'].'</h2>';}
                    } 
                    ?>
                    <p id="demo"></p>

                    <div class="profil"> <img src="" alt="">

                        <!--        image de profil -->

                        <nav class="cl-effect-10">
                            <?php

                            if (isset($_SESSION['connected'])){
                                echo ' </a><a href="logout.php" data-hover="Logout"><span>Logout</span></a>
                                <a href="account.php" data-hover="Count"><span>Account</span></a>';
                            }
                            else {
                                echo ' </a><a href="login.php" data-hover="Login/Register" ><span>Login/Register</span></a>';
                            }
                            ?>
                        </nav>
                    </div>
                </div>
                <hr style="margin:0;border-color: #FF0042;width: 100%;"> </div>
        </header>
        <div class="corps">
            <div class="tags">

              

                <form>
                   <input type='text' name='name' placeholder='name' size="10" />
                    <div><label style="color: #FF0042;font-family: lato;font-weight: bold;">Themes :</label>
                    <select name="cat">
                        <option ></option>
                        <option value="Others">Others </option>

                        <option value="City"> City</option>

                        <option value="Mode"> Mode</option>

                        <option value="Portrait"> Portrait</option>

                        <option value="Sport"> Sport</option>

                        <option value="Landscape"> Landscape</option>

                        <option value="Animals"> Animals </option>

                        <option value="Music"> Music</option>

                        <option value="Food"> Food</option>

                    </select></div>
                    <button class="button button--ujarak button--border-thin button--text-thick bouton" name="send" type="submit" style="margin: 0;">
                        SEARCH
                    </button>
                </form>
            </div>

            <div class="upload">
                <h2 style="color: white;font-family: lato;font-weight: lighter;">PICTURES</h2>
                <div class="affichage">
                <?php
                if (isset($_GET['send']) ) {

                    if(!empty($_GET['cat']) && !empty($_GET['name'])){
                        $stmt = $dbh->prepare('SELECT id FROM categories WHERE name=:name');
                        $arg=[
                            ':name' => $_GET['cat']
                        ];
                        $stmt->execute($arg);

                        while ($result=$stmt->fetch()){
                            global $id_cat;
                            $id_cat=$result['id'];
                        }

                        $req = $dbh->prepare('SELECT * FROM pictures where  categories_id = :id AND name = :name ');
                        $req->execute([
                            ':id' => $id_cat,
                            ':name' => $_GET['name']
                        ]
                                     );
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                            echo '<img  height="200" width="200" src="uploads/' . $item['picture'] . '" ><p>'.$item['name'].'</p>';}
                    }
                    elseif(empty($_GET['cat']) && !empty($_GET['name'])){
                         $req = $dbh->prepare('SELECT * FROM pictures where   name = :name ');
                        $req->execute([
                            ':name' => $_GET['name']
                        ]
                                     );
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                            echo '<div class="photospic"><img height="200" width="200" src="uploads/' . $item['picture'] . '" ><br>'.$item['name'].'</div>';}
                    }
                     elseif(!empty($_GET['cat']) && empty($_GET['name'])){
                          $stmt = $dbh->prepare('SELECT id FROM categories WHERE name=:name' );
                        $arg=[
                            ':name' => $_GET['cat']
                        ];
                        $stmt->execute($arg);

                        while ($result=$stmt->fetch()){
                            global $id_cat;
                            $id_cat=$result['id'];
                        }

                        $req = $dbh->prepare('SELECT * FROM pictures where  categories_id = :id ');
                        $req->execute([
                            ':id' => $id_cat
                           
                        ]
                                     );
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                            echo '<div class="photospic"><img height="200" width="200" src="uploads/' . $item['picture'] . '" ><br>'.$item['name'].'</div>';}
                     }
                    else{



                        $req = $dbh->prepare('SELECT * FROM pictures ORDER BY id DESC limit 0,5');
                        $req->execute();
                        $res = $req->fetchAll(); 
                        foreach($res as $item){
                            echo '<div class="photospic"><img height="200" width="200" src="uploads/' . $item['picture'] . '" ><br>'.$item['name'].'</div>';}
                    }


                }
                else{



                    $req = $dbh->prepare('SELECT * FROM pictures ORDER BY id DESC limit 0,5');
                    $req->execute();
                    $res = $req->fetchAll(); 
                    foreach($res as $item){
                        echo '<div class="photospic"><img height="200" width="200" src="uploads/' . $item['picture'] . '" ><br>'.$item['name'].'</div>';}
                }
                ?>
            
                </div>
            </div>


            <footer></footer>
        </div>
        <script>
            function myFunction() {
                document.getElementById("demo").innerHTML = "<div style='color:red'>NEED CONNEXION</div>";
            }
        </script>

    </body>

</html>