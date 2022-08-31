
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>سایت فروشگاهی</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="node_modules/normalize.css/normalize.css">
    <link rel="stylesheet" href="node_modules/fontawesome/css/all.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/juqery-cookie/src/jquery.cookie.js"></script>

    <?php
    require_once "includes/required.php";
    if (!isset($_SESSION["userInfo"])){
        die(header("Location: index.php"));
    }
    if (isset($_POST["sendMessageToAdmin"])){
        if (!empty($_POST["categoryMessage"])){
            $conn=connection::connect();
            $user_id=$_SESSION["userInfo"]["id"];

            $message=connection::sanitize($_POST["categoryMessage"]);
            $category_id=connection::sanitize($_POST["categorySelect"]);
            $sql="INSERT INTO `messagesuser`(`user_id`,`message`,`category_message`) VALUES ('$user_id','$message','$category_id')";
            $result=$conn->query($sql);
            if ($result){
                echo "<script>$(document).ready(function() {
                  let timerInterval
Swal.fire({
  title: 'پیتم شما به موفقیت ازسال شد',
  html: 'درحال ازسال به پشتیبانی <b></b>',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})
                })</script>";
            }
        }
        else{
            if(empty($_POST["categoryMessage"])){
                echo "<script>$(document).ready(function() {
                      const Toast = Swal.mixin({
  toast: true,
  position: 'top-start',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'error',
  title: 'شما نمیتوانید پیام را خالی رها کنید'
})
                    })</script>";
            }
        }
    }
    if(isset($_POST["changing"])){
        $fieldChange=connection::sanitize($_POST["changeForm"]);
        $fieldInput=$_POST["fieldValue"];
        $id=$_SESSION["userInfo"]["id"];
        $conn=connection::connect();
        $sql="UPDATE `users` SET $fieldChange='$fieldInput' WHERE `id`='$id' ";
        $result=$conn->query($sql);
        if ($result){
            echo "<script>$(document).ready(function() {
                      const Toast = Swal.mixin({
  toast: true,
  position: 'top-start',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'error',
  title: 'شما نمیتوانید پیام را خالی رها کنید'
})
                    })</script>";
        }
        else{
            echo "<script>$(document).ready(function() {
                  let timerInterval
Swal.fire({
  title: 'پیتم شما به موفقیت ازسال شد',
  html: 'درحال ازسال به پشتیبانی <b></b>',
  timer: 2000,
  timerProgressBar: true,
  didOpen: () => {
    Swal.showLoading()
    const b = Swal.getHtmlContainer().querySelector('b')
    timerInterval = setInterval(() => {
      b.textContent = Swal.getTimerLeft()
    }, 100)
  },
  willClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }
})
                })</script>";
        }
    }
    $filterDelete=false;
    if (isset($_POST["buyIt"])){
        for($i=0;$i<count($_POST["nameProductShop"]);$i++){
            $filterDelete=true;
            $nameProduct=connection::sanitize($_POST["nameProductShop"][$i]);
            $priceProduct=connection::sanitize($_POST["priceProductShopping"][$i]);
            $countProduct=connection::sanitize($_POST["countProductShopping"][$i]);
            $user_id=$_SESSION["userInfo"]["id"];
            $conn=connection::connect();
            $sql="INSERT INTO `buyproduct`(`nameProduct`,`count`,`price`,`user_id`) VALUES ('$nameProduct','$countProduct','$priceProduct','$user_id')";
            $result=$conn->query($sql);
            if($result){
                echo "<script>$(document).ready(function() {
                      const Toast = Swal.mixin({
  toast: true,
  position: 'top-start',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

Toast.fire({
  icon: 'success',
  title: 'منتظر ارسال ما باشید'
})
                    })
                   
                   console.log($.removeCookie('shoppingItem'))
                    
                    </script>";
            }
        }
    }
    if (isset($_GET["logout"])){
        session_destroy();
        session_unset();
        header("Refresh:0");
    }
    ?>
</head>
<body>

<div class="col-12 d-flex directionRtl">
    <div class="col-lg-3 col-6 position-fixed dashboardItem" style="z-index: 11111">
        <ul class="d-flex justify-content-center flex-column p-0">
            <li class="mb-3 mx-auto">
                <div class="parentUserImages position-relative mt-3">
                    <a href="" class="position-absolute w-100 h-100"><img src="images/userImages/userPic.png" alt="" class="w-100 h-100"></a>
                </div>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi activeDashboardItem" data-display="productBought">
                <i class="fas fa-cart-plus text-secondary"></i>
                <a href="" class="colorDashboard">محصولات خریداری شده</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="commentsAdmin">
                <i class="fas fa-sms text-secondary"></i>
                <a href="" class="colorDashboard">پشتیبانی</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="changeInfo">
                <i class="fas fa-user text-secondary"></i>
                <a href="" class="colorDashboard">تغییر اطلاعات کاربری</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="messagesAdmin">
                <i class="fas fa-bell text-secondary"></i>
                <a href="" class="colorDashboard">اعلان ها</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="cartUsers">
                <i class="fas fa-shopping-cart text-secondary"></i>
                <a href="" class="colorDashboard">سبد خرید</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi">
                <i class="fas fa-eye text-secondary"></i>
                <a href="index.php" class="colorDashboard">بازگشت به وبسایت</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi">
                <i class="fas fa-sign-out-alt text-secondary"></i>
                <a href="http://localhost/project-php-oop/dashboardUser.php?logout=true " class="colorDashboard">خروج از حساب کاربری</a>
            </li>
        </ul>
        <div class="responsiveBarIcon position-absolute cursorPointer">
            <i class="fas fa-bars position-absolute"></i>
        </div>
    </div>
    <div class="col-9 detailDashboard mrCustom">
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail productBought d-block ">
            <span class="font-size-2 fw-bold mb-4 text-dark" style="display: block">لیست خرید های شما در وبسایت ما</span>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">اسم محصول</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">وضعیت</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach(userDashboard::productButId($_SESSION["userInfo"]["id"]) as $key => $value): ?>
                    <tr>
                        <th scope="row"><?php echo $key+1?></th>
                        <td><?php echo $value["nameProduct"]; ?></td>
                        <td><?php echo $value["price"]; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm rounded-0">ارسال شده</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-10 col-12 mt-5 mx-auto d-block dashboardDetail commentsAdmin rounded-2 d-none">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-lg-around justify-content-center">
                            <div class="titleCardQuestion">
                                <span class="font-size-2 d-none text-dark d-lg-block">پیام های شما با پشتیبانی</span>
                            </div>
                            <div class="buttonGroup d-flex">
                                <button class="btn btn-secondary mx-2 btn-sm btnNewMessage" data-show="allMessages">ارسال پیام جدید</button>
                                <button class="btn btn-outline-secondary d-none d-md-block mx-2 btn-sm btnAllMessage" data-show="sendMessage">همه پیام ها</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body manageMessages">
                        <div class="allMessages d-none">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">ردیف</th>
                                    <th scope="col">موضوع پیام</th>
                                    <th scope="col">مشاهده پیام</th>
                                    <th scope="col">تاریخ ارسال پیام</th>
                                    <th scope="col">وضعیت</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; if (userDashboard::selectMessages()){ ?>


                                    <?php foreach (userDashboard::selectMessages() as $message): ?>
                                        <tr>
                                     <td><?php echo $i;?></td>
                                     <td><?php echo userDashboard::$subjectMessage[$message["category_message"]]?></td>
                                     <td><button type="button" class="btn btn-secondary btn-sm messageModlaButton" data-bs-toggle="modal" data-bs-target="#staticBackdrop">مشاهده پیام</button>
                                         <div style="display: none"><?php echo $message["message"]?></div>
                                     </td>

                                     <td><?php echo $message["time"]?></td>
                                     <td><?php
                                        switch ($message["status"]){
                                            case 0:
                                                echo "<button class='btn btn-primary btn-sm'>انتظار       بررسی</button>";
                                                break;
                                            case 2:
                                                echo "<button class='btn btn-primary btn-sm'>در حال بررسی</button>";
                                                break;
                                            case 3:
                                                echo "<button class='btn btn-primary btn-sm'> انجام      شد</button>";
                                                break;
                                            default :
                                                echo "<button class='btn btn-primary btn-sm'>اتمام رسید</button>";
                                        }
                                     ?></td>
                                        </tr>
                                    <?php $i++; endforeach; ?>

                                <?php }else{
                                    echo "<div class='alert alert-secondary'>هیچ پیامی تا به الان ارسال نکردید</div>";
                                } ?>
                                <?php

                                echo "</tbody>";
                            echo "</table>";

                            ?>
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center mx-auto" id="staticBackdropLabel">پیامی که شما فرستادید</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body messageSelected">
                                            ...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sendMessage">
                            <form action="" method="post">
                                <div class="mb-2">
                                    <span class="fw-bold d-block my-3">موضوع پیام خود را بزنید:</span>
                                    <select class="form-select w-75 text-dark" aria-label="Default select example" name="categorySelect">
                                        <option value="1">محصولی که به دستم رسیده</option>
                                        <option value="2">درباره شرکت</option>
                                        <option value="3">نظرات و انتقادات</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <span class="fw-bold d-block my-3 text-dark">پیام خود را وارد کنید :</span>
                                    <textarea class="form-control w-75" name="categoryMessage"  ></textarea>
                                </div>
                                <button class="btn btn-light" name="sendMessageToAdmin">ارسال پیام</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail changeInfo rounded-2 d-none">
            <div class="card">
                <div class="changeField">
                    <div class="card-header">
                        <div class="alert alert-primary col-10 mx-auto p-3 mb-0">برای تغییر هریک از اطلاعات رو فیلد کلیک کنید</div>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="my-2">
                                <div class="col-md-10 col-12 mx-auto">
                                    <a href="#" class="fieldInput">
                                        <input type="text" class="form-control cursorPointer rounded-0 disabled" disabled value="<?php echo $_SESSION['userInfo']['fullName']?>">
                                    </a>
                                </div>
                            </div>
                            <div class="my-2">
                                <div class="col-md-10 col-12 mx-auto ">
                                    <a href="#" class="fieldInput">
                                        <input type="text" class="form-control cursorPointer rounded-0 disabled" disabled data-chenge-field="phone" value="<?php echo $_SESSION['userInfo']['phone'] ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="my-2">
                                <div class="col-md-10 col-12 mx-auto ">
                                    <a href="#" class="fieldInput">
                                        <input type="text" class="form-control cursorPointer rounded-0 disabled" disabled data-chenge-field="email" value="<?php echo $_SESSION['userInfo']['email'] ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="my-2">
                                <div class="col-md-10 col-12 mx-auto ">
                                    <a href="#" class="fieldInput">
                                        <input type="text" class="form-control cursorPointer rounded-0 disabled" disabled data-chenge-field="userName" value="<?php echo $_SESSION['userInfo']['userName'] ?>">
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="formField d-none">
                    <div class="card-header d-flex justify-content-around">
                        <div class="alert alert-primary col-10 mx-auto p-3 mb-0">اسم تغییر دلخواه را وارد کنید</div>
                        <button class="btn-sm btn btn-secondary comeBack">پشیمان شدم</button>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="my-2">
                                <input type="hidden" value="" class="hiddenValue" name="changeForm">
                                <input type="text" class="form-control w-75 d-block mx-auto" name="fieldValue">
                            </div>
                            <button class="btn btn-secondary d-block mx-auto" name="changing">تغییر!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail messagesAdmin rounded-2 d-none">

            <?php foreach (adminClasses::selectSpecialTable('adminmessages','0') as $messageAdmin): ?>
            <div class="card text-white bg-<?php echo adminClasses::$btnColor[rand(0,3)];?> mb-3 messageAdmin">
                <div class="card-header"><?php echo $messageAdmin["titleMessage"];?></div>
                <div class="card-body"><?php echo $messageAdmin["discribtionMessage"]; ?></div>
            </div>

            <?php endforeach; ?>
    </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail cartUsers bg-opacity-100 rounded-2 d-none">
            <span class="font-size-2 fw-bold mb-4 text-dark" style="display: block">لیست خرید های شما در وبسایت ما</span>
            <form action="" method="post">
            <table class="table table-bordered">

                <thead>
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">اسم محصول</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">تعداد</th>
                </tr>
                </thead>

                    <tbody class="shoppingCartShow">
                        <div class="alert alert-secondary w-75 mx-auto alert-null">هیچ محصولی را انتخاب نکرده اید
                        !!!!!!!!</div>
                    </tbody>


            </table>

            <div class="d-flex mx-auto d-flex justify-content-center"><button class="btn btn-light" name="buyIt">برای خرید کلیک کنید</button></div>
            </form>
        </div>

</div>



<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script src="node_modules/@persian-tools/persian-tools/build/persian-tools.umd.js"></script>
<script src="node_modules/juqery-cookie/src/jquery.cookie.js"></script>
<script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>

<script src="js/script.js"></script>

</body>
</html>