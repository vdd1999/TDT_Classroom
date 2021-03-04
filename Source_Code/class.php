<?php
    require_once('conn.php');

    session_start();
    if (isset($_SESSION['user'])&&isset($_GET['malop'])) {
        $matk = $_SESSION['matk'];
        $hoten = $_SESSION["name"];
        $email = $_SESSION["email"];
        $quyen = $_SESSION["quyen"];
        $malop = $_GET['malop'];
        $result = get_ds_Lop($matk);
        if ($result['code'] == '0') {
            $data = $result['lop'];           
        }
        else {
            $data = null;
        }
        $error = "";
        $tepdinhkem = "";
        if (isset($_POST['btn-dangbai'])) {
            if ($_FILES['filename_dangbai']['size']  != 0){
                $tepdinhkem = $_FILES['filename_dangbai']['name'];  
                $file = $_FILES["filename_dangbai"]["tmp_name"];
                $destination = 'uploads/'.$tepdinhkem;
                move_uploaded_file($file, $destination);    
            }
            $malop = $_GET['malop'];
            $matk = $_SESSION['matk'];
            $noidung = $_POST['post-input'];
            if ($noidung == ""){
                $error= "Vui lòng nhập nội dung";
            }
            else {
                $loaibd = 0;
                $ngaynop = NULL;
                $tieude = '';
                $action = $_GET['action'];
                if ($action == 'createAnnouncement'){
                    createAnnouncement($matk,$malop,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop);
                }
            }
        }
        if (isset($_POST['btn-dangbaitap'])) {
            if ($_FILES['filename_assign']['size']  != 0){
                $tepdinhkem = $_FILES['filename_assign']['name'];
                $file = $_FILES["filename_assign"]["tmp_name"];
                $destination = 'uploads/'.$tepdinhkem;
                move_uploaded_file($file, $destination);
            }
            $malop = $_GET['malop'];
            $matk = $_SESSION['matk'];
            $noidung = $_POST['post-input'];
            $loaibd = 1; 
            $ngaynop = $_POST['ngaynop'];
            $tieude = $_POST['tieude'];
            $action = $_GET['action'];
            if ($noidung == ""){
                $error= "Vui lòng nhập nội dung";
            }
            else if ($ngaynop == ""){
                $error= "Vui lòng chọn ngày nộp bài";
            }
            else if ($action == 'createAnnouncement'){
                createAnnouncement($matk,$malop,$tieude,$loaibd,$noidung,$tepdinhkem,$ngaynop);
            }
        }
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

<body onload="truncate()">
    <div id="modal-backdrop1" class="modal-backdrop1" onclick="w3_close();"></div>
    <header>
        <div class="w3-sidebar w3-bar-block w3-card w3-animate-left hover1" style="display:none" id="mySidebar">
            <div class="logout">
                <p class="nameAcc"><?= $hoten ?></p>
                <p class="text-truncate emailAcc"><?= $email ?></p>
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
                if (is_null($data)) {
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
                }
                ?>
            </div>

            

            
        </div>
        <div class="Head" id="main">
            <div class="left col-lg-4 col-12" style="padding: 0;">
                <div id="myBtn" onclick="w3_open()"  class="list">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>

                <div class="infoClass">
                    <div class="Subjects">
                        <span class="" id="subjectsName"><?= get_name_class($malop)?></span>
                    </div>

                    <div class="teacherName">
                        <span id="teacherName">
                            <?php echo get_name_GV($malop); ?>
                        </span>
                    </div>
                </div>
            </div>

            


            <div class="center col-lg-4 col-12">
                <div class="tab">
                    <button class="tablinks active" onclick="openCity(event, 'Stream')">Stream</button>
                    <button class="tablinks" onclick="openCity(event, 'Classwork')">Classwork</button>
                    <button class="tablinks" onclick="openCity(event, 'People')">People</button>
                    <?php
                    if ($quyen ==1){
                    ?>
                    <button class="tablinks" onclick="openCity(event, 'Noti')">Noti</button>                    
                    <?php
                    }
                    ?>
                </div>
            </div>

         

        </div>

        

    </header>

    <div class="Main-content" id="main2" onclick="w3_close()">
        <div class="container">
            <?php
                if (!empty($error)) {
                ?>
                <div id="show-error" class="alert alert-danger">
                    <strong><?=$error ?></strong>
                </div>
                <?php
                }
            ?>
            <div hidden id="show-error" class="alert alert-success">
                    <strong id="msg-error"></strong>
            </div>
            <div id="Stream" class="tabcontent">
                <div class="title">
                    <div class="background" >
                        <img src='https://cdn.dribbble.com/users/244437/screenshots/14351924/media/d58fbf5758ce2e50097d0a56d7d17d02.jpg'>
                    </div>

                    <div class="text-title">
                        <h1 class="text-truncate"><?=  get_name_class($malop) ?></h1>
                        <p><?php echo get_name_GV($malop); ?></p>
                    </div>

                    <i class="fa fa-chevron-down down" aria-hidden="true" onclick="showinfoClass()"></i>
                    <i class="fa fa-chevron-up up" aria-hidden="true" onclick="offinfoClass()"></i>
                </div>

                <div class="info-Class">
                    <table style="width:100%">
                        <tr>
                            <td colspan="2">
                                <i class="fa fa-wrench" aria-hidden="true" data-toggle="modal" data-target="#edit-infoClass"></i>
                                <div class="ava">
                                    <img src="https://s31450.pcdn.co/wp-content/uploads/2019/08/iStock-528978494-170719.jpg" alt="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="">Course</label>
                            </th>
                            <td><?= $malop ?></td>
                        </tr>
                        <tr>
                            <th>
                                <label for="">Class Name</label>
                            </th>
                            <td><?= get_name_class($malop)?></td>
                        </tr>
                        <tr>
                            <th>
                                <label for="">Room</label>
                            </th>
                            <td><?= get_room_class($malop) ?></td>
                        </tr>
                        <tr>
                            <th>
                                <label for="">Subject</label>
                            </th>
                            <td><?= get_subject_class($malop) ?></td>
                        </tr>
                    </table>   
                </div>

                <div class="modal" id="edit-infoClass">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">                               
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Edit</h4>
                            </div>                                   
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 row">
                                        <div class="col-4">
                                            <p>Course</p>
                                            <p>Class Name</p>
                                            <p>Room</p>
                                            <p>Subject</p>
                                        </div>
                                        <div class="col-8">
                                            <input id="malop" type="text" readonly value="<?= $malop ?>">
                                            <input id="tenlop" type="text" value="<?= get_name_class($malop)?>">
                                            <input id="phonghoc" type="text" value="<?= get_room_class($malop)?>">
                                            <input id="monhoc" type="text" value="<?= get_subject_class($malop)?>">
                                        </div>
                                    </div>
                                </div>

                                <button onclick="editLop(<?=$matk ?>)">Edit</button>
                         
                            </div>
                           
                        </div>
        
                    </div>
                </div>



                <div class="body-content">
                    <div class="deadline col-lg-3">
                        <?=getDeadline($malop) ?>
                        <div style="display: flex;">
                            <div></div>
                            <div style="flex: 1 0 1rem;"></div>
                        </div>
                    </div>

                    <div class="post col-lg-9">
                        <?php
                        if ($quyen == 1){
                        ?>
                        <div class="post-topic" id="post-topic" onclick="clickPost()">
                            <div class="abc">
                                <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg" alt="">
                            </div>

                            <div class="bcd">Share something with your class…</div>
                        </div>
                        <div class="post-text" id="post-text">
                            <div class="tab">
                                <button class="tablinksPost active" onclick="postAssign(event, 'Post')">Post</button>
                                <button class="tablinksPost" onclick="postAssign(event, 'Assignment')">Assignment</button>
                            </div>

                            <div class="newpost tabcontentPost" id="Post">
                                <form id="form-dangbai" method="POST" action="class.php?malop=<?=$malop?>&action=createAnnouncement" enctype="multipart/form-data">
                                    <div class="post-input">
                                        <textarea id="post-input" class="post-input" name="post-input" placeholder="Share with your class" rows="4"></textarea>
                                    </div>
                                    <div class="post-btn">
                                        <div class="file-upload">
                                            <div class="custom-file mb-3">
                                                <ul hidden id='save-file-list'>
                                                    <li class="save-file-item">
                                                        <div class="save-file-format">
                                                            <p id="show-file-format" class="format-text"></p>
                                                        </div>
                                                        <div id="show-file-name" class="save-file-name"></div>
                                                        <div id="show-file-size"class="save-file-size"></div>
                                                    </li>
                                                </ul>
                                                
                                                <div class="choose-file">
                                                    <label class="file-upload-label" for="file">Choose file from your computer</label>
                                                    <input style="display: none;" type="file" id="file" name="filename_dangbai">                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-action">
                                            <button class="btn-cancel" onclick="cancelPost()">Cancel</button>
                                            <button class="btn-post" name="btn-dangbai">Post</button>
                                        </div>
                                    </div>                                   
                                </form>
                            </div>

                            <div class="newassign tabcontentPost" id="Assignment">
                                <form id="form-dangbaitap" method="POST" action="class.php?malop=<?=$malop?>&action=createAnnouncement" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="">Tiêu đề</label>
                                        <input id="tieude" type="text" name="tieude" placeholder="Tiêu đề">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ngày nộp</label>
                                        <input id="ngaynop" name="ngaynop" type="date">
                                    </div>
                                    <div class="post-input">
                                        <textarea id="assign-noidung" class="post-input" name="post-input" placeholder="Nội dung" rows="4"></textarea>
                                    </div>
                                    <div class="post-btn">
                                        <div class="file-upload">
                                            <div class="custom-file mb-3">
                                                <ul id='save-file-list-assign' hidden>
                                                    <li class="save-file-item">
                                                        <div class="save-file-format">
                                                            <p id="show-file-format-assign" class="format-text"></p>
                                                        </div>
                                                        <div id="show-file-name-assign" class="save-file-name"></div>
                                                        <div id="show-file-size-assign"class="save-file-size"></div>
                                                    </li>
                                                </ul>                                            
                                                <div class="choose-file">
                                                    <label class="file-upload-label" for="file-assign">Choose file from your computer</label>
                                                    <input style="display: none;" type="file" id="file-assign" name="filename_assign">                            
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn-action">
                                            <button class="btn-cancel" onclick="cancelPost()">Cancel</button>
                                            <button class="btn-post" name="btn-dangbaitap" >Post</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        }
                        ?>

                        <div id="show-post">
                            <?= getBaidang($malop,$matk)?>
                        </div>
                        <div class="modal" id="myModal3">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">                               
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Class comments</h4>
                                    </div>                                   
                                    <!-- Modal body -->
                                    <div id="show-cmt">
                                        <!--SHOW COMMENT HERE-->
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="add-cmt">
                                        <div class="abc col-1 col-lg-1">
                                            <img src="https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/s40-c-fbw=1/photo.jpg" alt="">
                                        </div>
                                        <div class="cmt col-11 col-lg-11">
                                            <input id="addCMT" class="text-cmt" placeholder="Add class comment...">
                                            <i id="send" class="fa fa-paper-plane" aria-hidden="true"></i>  
                                        </div>
                                    </div>  
                                </div>
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="Classwork" class="tabcontent">
                <div class="classwork-item">
                    <div class="heading">
                        <h3 class="heading-title">Tutorials</h3>
                    </div>
                    <?= getAssignment($malop)?>
                </div>
            </div>

            <div id="People" class="tabcontent">

                <div class="classwork-item">
                    <div class="heading">
                        <h3 class="heading-title">Teacher</h3>
                    </div>
                    <?=getGV_client($malop) ?>
                </div>
                <div class="classwork-item" >
                    <div class="heading">
                        <h3 class="heading-title">Classmates</h3>
                        <?php
                        if ($quyen == 1) {
                        ?>
                        <div data-toggle="modal" data-target="#modalAddStudent" data-malop="<?=$malop ?>" aria-labelledby="exampleModalCenterTitle">
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                        </div>                      
                        <?php
                    }
                        ?>

                    </div>
                    <!-- The Modal add student-->
                    <div class="modal" aria-labelledby="exampleModalCenterTitle" id="modalAddStudent">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Invite Student</h4>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                        <label for="" class="lable-modalAddclass">Email</label>
                                        <input id='invite-class' type="text" placeholder = "Enter Email" class="modal-className ip">
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="button" id="invite-btn" class="btn btn-create" data-dismiss="modal" >Invite</button>
                                </div>	
                            </div>
            
                        </div>
                    </div>
                    <div class="sv-item" id="show-SV-client">
                     <?=getSV_client($malop,$matk) ?>                       
                    </div>
                </div>
            </div>
            <?php
            if ($quyen == 1) {
            ?>
             <div id="Noti" class="tabcontent">
                <div class="heading">
                        <h3 class="heading-title">New members</h3>
                </div>
                <div class="table">
                    <table class="table">
                        <thead>
                          <tr >
                            <th>#</th>
                            <th>Full name</th>
                            <th>Email</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody id="show-sv-active">
                            <?=notifyJoinclass($malop) ?>               
                        </tbody>                 
                      </table>
                  </>

            </div>           
            <?php  
            }
            ?>

        </div>
    </div>
    
</body>