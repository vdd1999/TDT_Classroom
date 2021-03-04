<?php
    require_once('conn.php');

    session_start();
    if (isset($_SESSION['user'])) {
        $matk = $_SESSION['matk'];
        $hoten = $_SESSION["name"];
        $email = $_SESSION["email"];
        $quyen = $_SESSION["quyen"];
        $result = get_ds_Lop($matk);
        $data = $result['lop'];
    }
    else {
        header('Location:login.php');
        exit();
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="style.css">
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="main.js"></script>

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
</head>
<body>
    <div id="modal-backdrop1" class="modal-backdrop1" onclick="w3_close();"></div>
    <header>
        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left hover1" style="display:none" id="mySidebar">
            <div class="logout">
                <p class="nameAcc"><?=get_name_tk($matk) ?></p>
                <p class="text-truncate emailAcc"><?=$email?></p>
                <a href="logout.php">
                    <button class="signout">Sign out</button>
                </a>
            </div>
            <div>
            <a href="index.php">
                <div class="classes">
                    <i class="fa fa-home icon" aria-hidden="true"></i>
                    <div class="text">Classes</div>
                </div>
            </a>

            <div class="classes">
                <i class="fa fa-calendar-o icon" aria-hidden="true"></i>
                <div class="text">Calendar</div>
            </div>

            <hr>

            
                <div class="classes">
                    <i class="fa fa-list-alt icon" aria-hidden="true"></i>
                    <div class="text">To-do</div>
                </div>

            <?php
                foreach ($data as $dt) {
            ?>
            <a href="class.php?malop=<?=$dt['malop']?>">
                <div class="classes">
                    <div class="avatar">
                        <div class="ava-img"><?= substr($dt['tenlop'],0,1) ?></div>
                    </div>

                    <div class="infoClass">
                        <div class="Subjects">
                            <span class="name_class"><?= $dt['tenlop'] ?></span>
                        </div>

                        <div class="teacherName">
                            <span id=""><?=get_name_GV($dt['malop']);?></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php 
                }
            ?>
              
            </div>

            

            
        </div>
        <div class="Head" id="main">
            <div class="left col-lg-4" style="padding: 0;">
                <div id="myBtn" onclick="w3_open()"  class="list">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>

                <div class="infoClass">
                    <div class="Subjects">
                        <span id="subjectsName">Todo</span>
                    </div>
                </div>
            </div>

            


            <div class="center col-lg-4">
                
            </div>

            <div class="right col-lg-4">
                <div class="abc">
                    <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg" alt="">
                </div>
            </div>

        </div>

        

    </header>
    <div class="Main-content" id="main2" onclick="w3_close()">
        <div class="container">
            <div class="todo-ele">
                <div class="Nodue due">
                    <label>Todo</label>
                    <div class="space"></div>
                    <div class="num"></div>
                    <i class="fa fa-chevron-down" aria-hidden="true" onclick="showNodue()"></i>
                </div>
                <?php
                foreach ($data as $dt) {
                    getTodo($dt['malop']);
                }
                ?>
            </div>

        
        </div>
    </div>
</body>
</html>