
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
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/master.css">
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="node_modules/juqery-cookie/src/jquery.cookie.js"></script>
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="js/script.js"></script>
    <?php require_once "includes/required.php"?>
    <?php
    $filterMessage=$_GET["filterMessage"] ?? 0;
        if(isset($_GET["idDelete"])){
            $idTable=$_GET["idDelete"];
            if (adminClasses::deleteRow('products',$idTable)){
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
  title: 'باموفقیت حذف شد'
})
                })</script>";
            }
            else{
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
  title: 'مشکلی پیش امده'
})
                })</script>";
            }
        }
        if(isset($_POST["sendMessage"])){
            if (!empty($_POST["titleMessage"]) && !empty($_POST["discribtionMessage"])){
                $titleMessage=connection::sanitize($_POST["titleMessage"]);
                $discribtionMessage=connection::sanitize($_POST["discribtionMessage"]);
                $conn=connection::connect();
                $sql="INSERT INTO `adminmessages`(`titleMessage`,`discribtionMessage`) VALUES ('$titleMessage','$discribtionMessage')";
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
  title: 'باموفقیت ارسال شد'
})
                })</script>";
                }
            }
            else{
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
  title: 'فیلد ها خالی را پر کنید'
})
                })</script>";
            }
            connection::disconnect($conn);
        }
        if (isset($_POST["sendQuestion"])){
            if (!empty($_POST["title"]) && !empty($_POST["Answer"])){
                $conn=connection::connect();
                $questionTitle=connection::sanitize($_POST['title']);
                $discribtionMessage=connection::sanitize($_POST['Answer']);
                $sql="INSERT INTO `adminmessages`(`titleMessage`,`discribtionMessage`,`status`) VALUES ('$questionTitle','$discribtionMessage','1')";
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
  icon: 'success',
  title: 'باموفقیت ارسال شد'
})
                })</script>";
                }
            }

            else{
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
  title: 'حتما خطایی رخ داده'
})
                })</script>";
            }
        }
        if (isset($_GET["changeTypeMessage"], $_GET["idMessage"])){

            $changeTypePassword=$_GET["changeTypeMessage"];
            $idMessage=$_GET["idMessage"];
            $conn=connection::connect();
            $sql="UPDATE `messagesuser` SET `status`='$changeTypePassword' WHERE `id`='$idMessage'";
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
  icon: 'success',
  title: 'باموفقیت ارسال شد'
})
                })</script>";
            }
            else{
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
  title: 'با خطا رو به رو شد'
})
                })</script>";
            }
        }
    ?>

</head>
<body>

<div class="col-12 d-flex directionRtl">
    <div class="col-lg-3 col-6 position-fixed dashboardItem" style="z-index: 11111">
        <ul class="d-flex justify-content-center flex-column p-0">
            <li class="p-3 cursorPointer itemDashboardLi activeDashboardItem" data-display="dashboard">
                <i class="fas fa-grip-horizontal text-secondary"></i>
                <a href="" class="colorDashboard">داشبورد</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="productBought">
                <i class="fas fa-cart-plus text-secondary"></i>
                <a href="" class="colorDashboard">لیست محصولات شما</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="commentsUser">
                <i class="fas fa-sms text-secondary"></i>
                <a href="" class="colorDashboard">پیام های ارسالی </a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="changeInfo">
                <i class="fas fa-user text-secondary"></i>
                <a href="" class="colorDashboard">کاربران شما</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="messagesAdmin">
                <i class="fas fa-heart text-secondary"></i>
                <a href="" class="colorDashboard">ارسال اعلان</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="questionsPage">
                <i class="fas fa-question text-secondary"></i>
                <a href="" class="colorDashboard">لیست صفحه سوال ها</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi" data-display="companyName">
                <i class="fas fa-building text-secondary"></i>
                <a href="" class="colorDashboard">لیست شرکت ها</a>
            </li>
            <li class="p-3 cursorPointer itemDashboardLi">
                <i class="fas fa-eye text-secondary"></i>
                <a href="index.php" class="colorDashboard">بازگشت به وبسایت</a>
            </li>
        </ul>
        <div class="responsiveBarIcon position-absolute cursorPointer">
            <i class="fas fa-bars position-absolute"></i>
        </div>
    </div>
    <div class="col-9 detailDashboard mrCustom">
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail dashboard d-block" style="height: 300px">
            <div class="col-12 flex-column flex-md-row d-flex justify-content-around">
                <div class="col-md-5 col-10 my-2 bg-secondary bg-opacity-25 py-3 rounded-2">
                    <div class="parentUserCard mx-auto position-relative border border-1 border-light">
                        <i class="fas fa-user position-absolute text-dark text-opacity-50"></i>
                    </div>
                    <div class="mx-auto text-center text-dark text-opacity-50 my-2">
                        <h4 class="my-1"> تعداد کاربرهای وبسایت شما</h4>
                        <span class="countUser fw-bold d-block font-size-2 PersianNumber"><?php echo count(adminClasses::selectSpecialTable('users'))?></span>
                    </div>

                </div>
                <div class="col-md-5 col-10 my-2 bg-secondary bg-opacity-25 py-3 rounded-2">
                    <div class="parentUserCard mx-auto position-relative border border-1 border-light">
                        <i class="fas fa-shopping-cart position-absolute text-dark text-opacity-50"></i>
                    </div>
                    <div class="mx-auto text-center text-dark text-opacity-50 my-2">
                        <h4 class="my-1"> تعداد خرید ها از وبسایت شما</h4>
                        <span class="countUser fw-bold d-block font-size-2"><?php echo count(adminClasses::selectSpecialTable('buyproduct'))?></span>
                    </div>

                </div>
            </div>
            <div class="col-12 flex-column flex-md-row d-flex justify-content-around">
                <div class="col-md-5 col-10 my-2 bg-secondary bg-opacity-25 py-3 rounded-2">
                    <div class="parentUserCard mx-auto position-relative border border-1 border-light">
                        <i class="fas fa-building position-absolute text-dark text-opacity-50"></i>
                    </div>
                    <div class="mx-auto text-center text-dark text-opacity-50 my-2">
                        <h4 class="my-1"> تعداد شرکت های فروش</h4>
                        <span class="countUser fw-bold d-block font-size-2 PersianNumber"><?php echo count(adminClasses::selectSpecialTable('companies'))?></span>
                    </div>

                </div>
                <div class="col-md-5 col-10 my-2 bg-secondary bg-opacity-25 py-3 rounded-2">
                    <div class="parentUserCard mx-auto position-relative border border-1 border-light">
                        <i class="fas fa-comment position-absolute text-dark text-opacity-50"></i>
                    </div>
                    <div class="mx-auto text-center text-dark text-opacity-50 my-2">
                        <h4 class="my-1">تعداد نظرات کاربران</h4>
                        <span class="countUser fw-bold d-block font-size-2">20</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-10 mt-5 mx-auto d-none dashboardDetail productBought d-block">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">ردیف</th>
                    <th scope="col">اسم محصول</th>
                    <th scope="col">قیمت</th>
                    <th scope="col">عملیات</th>
                </tr>
                </thead>
                <tbody>

                <?php if (adminClasses::selectSpecialTable('products')):$i=1; ?>
                    <?php foreach (adminClasses::selectSpecialTable('products') as $product): ?>
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $product["nameProduct"]?></td>
                            <td class="PersianNumber"><?php echo $product["price"]?></td>
                            <td>
                                <a href="http://localhost/project-php-oop/dashboardAdmin.php?idDelete=<?php echo $product['id']?>" class="text-danger"><i class="fas fa-trash"></i></a>

                            </td>
                        </tr>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-10 col-12 mt-5 mx-auto d-block dashboardDetail commentsUser d-none">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-around">
                        <a href="?filterMessage=0" class="preventDefault"><button class="btn btn-outline-warning active" data-filterMessage="warning">همه پیام ها</button></a>
                        <a href="?filterMessage=1" class="preventDefault"><button class="btn btn-outline-secondary" data-filterMessage="secondary">پیام های بررسی</button></a>
                        <a href="?filterMessage=2" class="preventDefault"><button class="btn btn-outline-success" data-filterMessage="success">پیام های پیگیری شده</button></a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (adminClasses::selectMessageUsers($filterMessage)){ ?>

                        <?php foreach (adminClasses::selectMessageUsers($filterMessage) as $value): ?>
                            <div class="card mt-3">
                                <div class="card-header">
                                    <span class="userSendingMessage fw-bold text-dark"><?php echo $value["firstName"] ." ". $value["lastName"] ?></span>

                                </div>
                                <div class="card-body">
                                    <p><?php echo $value["message"]?></p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-evenly">
                                        <?php
                                        switch ($value["status"]){
                                            case 0:
                                                echo '<a href="dashboardAdmin.php?changeTypeMessage=1&idMessage='.$value["id"].'"><button class="btn btn-info rounded-0 text-dark">درحال بررسی</button></a> ';
                                                break;
                                            case 1:
                                                echo '<a href="dashboardAdmin.php?changeTypeMessage=2&idMessage='.$value["id"].'"><button class="btn btn-info rounded-0 text-dark">درحال بررسی</button></a>';
                                                break;
                                            case 2:
                                                echo '<a href="dashboardAdmin.php?changeTypeMessage=3&idMessage='.$value["id"].'"><button  class="btn btn-success text-dark rounded-0">انجام شد</button></a>';
                                                break;
                                            case 3:
                                                echo '<button class="btn btn-primary">پیگیری شد</button>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php }else{echo "<div class='alert alert-secondary text-center'>هیچ پیامی ارسال نکردید!!!!</div>";} ?>
                </div>
            </div>
        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail changeInfo d-none">
            <?php foreach (adminClasses::selectSpecialTable('users') as $user): ?>

                <div class="col-12 col-lg-10 mt-3 mx-auto">
                    <div class="col-12 bg-secondary bg-opacity-25 py-4 rounded-3">
                        <div class="userAdminDashboardParentImage mx-auto">
                            <img src="images/userImages/user.jpg" class="w-100 h-100" alt="">
                        </div>

                        <div class="detailAboutUsersAdminDashboard">
                            <div class="col-12 text-dark justify-content-center flex-lg-row flex-column d-flex mt-3">
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">نام کامل:</span>
                                    <span class="titleOfLabel "><?php echo $user["firstName"] . $user["lastName"]?></span>
                                </div>
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">شماره تماس:</span>
                                    <span class="titleOfLabel"><?php echo $user["phone"]?></span>
                                </div>
                            </div>
                            <div class="col-12 text-dark justify-content-center flex-lg-row flex-column d-flex mt-3">
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">نام کاربری:</span>
                                    <span class="titleOfLabel "><?php echo $user["userName"]?></span>
                                </div>
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">پست الکترونیکی:</span>
                                    <span class="titleOfLabel"><?php echo $user["email"]?></span>
                                </div>
                            </div>
                            <div class="col-12 text-dark justify-content-center flex-lg-row flex-column d-flex mt-3">
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">تعداد کامنت ها:</span>
                                    <span class="titleOfLabel ">26</span>
                                </div>
                                <div class="col-lg-6 col-12 justify-content-center justify-content-lg-start d-flex px-2">
                                    <span class="labelUserCard">تعداد پیام ها:</span>
                                    <span class="titleOfLabel">11</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;  ?>
        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail messagesAdmin rounded-2 d-none">
            <div class="col-8 mx-auto">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="my-2">
                                <label for="">عنوان خود را بنویسید:</label>
                                <input type="text" name="titleMessage" class="form-control">
                            </div>
                            <div class="my-2">
                                <label for="">توضیحات شما:</label>
                                <textarea name="discribtionMessage" rows="10" class="form-control"></textarea>
                            </div>
                            <button class="btn btn-secondary d-flex mx-auto" name="sendMessage">ارسال پیام</button>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <div class="col-10 mt-5 mx-auto d-none dashboardDetail questionsPage">
            <form action="" method="post">
                <div class="my-2">
                    <label for="" class="mb-2">سوال خود را بنویسید:</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="my-2">
                    <label for="">توضیحات شما:</label>
                    <textarea name="Answer" rows="10" class="form-control"></textarea>
                </div>
                <button class="btn btn-secondary d-flex mx-auto" name="sendQuestion">ارسال پیام</button>
            </form>
            <?php foreach (adminClasses::selectSpecialTable('adminmessages','1') as $question): ?>
                <div class="col-12 my-3">

                    <span class="d-block titleQuestion"><?php echo $question['titleMessage']; ?></span>
                    <p class="mt-3"><?php echo $question["discribtionMessage"]?></p>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail companyName d-none">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="text-center textEllipsis text-dark">ردیف</th>
                    <th scope="col" class="text-center textEllipsis text-dark">نام شرکت</th>
                    <th scope="col" class="text-center textEllipsis text-dark">تعداد محصول</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (adminClasses::selectSpecialTable('companies') as $key => $value):?>
                <tr>
                    <td class="text-center textEllipsis text-dark"><?php echo $key+1;?></td>
                    <td class="text-center textEllipsis text-dark"><?php echo $value["nameCompany"]?></td>
                    <td class="text-center textEllipsis text-dark"><?php echo count(adminClasses::categoryId(0,$key+1))?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-10 mt-5 mx-auto d-block dashboardDetail cartUsers bg-primary bg-opacity-100 rounded-2 d-none" style="height: 300px">

        </div>

    </div>





</body>
</html>