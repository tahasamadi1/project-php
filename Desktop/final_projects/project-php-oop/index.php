
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
    <script src="node_modules/@persian-tools/persian-tools/build/persian-tools.umd.js"></script>
    <script src="node_modules/juqery-cookie/src/jquery.cookie.js"></script>
    <script src="node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <script src="js/script.js"></script>
    <?php require_once "includes/required.php";
    $filterFlag=false;
    $errors=array();
    if (isset($_POST["changePass"])){
        if (!empty($_POST["emailReset"]) && filter_var($_POST["emailReset"])){
            $email=connection::sanitize($_POST["emailReset"]);
            $conn=connection::connect();
            $sql="SELECT * FROM `users` WHERE `email`='$email'";
            $result=$conn->query($sql);
            if ($result->num_rows){
                $res=$result->fetch_assoc();
                $code=$res["phone"];
                connection::sendEmail("reset my email","<a href='http://localhost/project-php-oop/index.php?id=$code'>عوض کردن رمزتون</a>",connection::sanitize($_POST["emailReset"]));
            }
            else{
                $errors[]="ایمیلتان را اشتباه وارد کردید";
                $filterFlag=true;
            }
        }
        else{
            connection::error();
            if(empty($_POST["emailReset"])){
                $errors[]="لطفا فیلد ایمیل را پرکنید";
                $filterFlag=true;
            }
            if (!filter_var($_POST["emailReset"])){
                $errors[]="فرمت ایمیل شما اشتباه است";
                $filterFlag=true;
            }
        }
    }
    if(isset($_POST["signUp"])){
            if (!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["phone"]) && !empty($_POST["email"]) && !empty($_POST["userName"]) && !empty($_POST["password"]) && !empty($_POST["re-password"]) && filter_var($_POST["email"],FILTER_VALIDATE_EMAIL) && preg_match('/\+98|0(9\d{2,})\d{7}/',$_POST["phone"]) && preg_match('/[a-z0-9-_]{4,}/',$_POST["userName"]) && preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-z0-9A-Z!@#$%^&*]{5,}/',$_POST["password"])){

                $conn=connection::connect();
                $checkEmail=connection::checkEmail($_POST["email"]);
                if ($checkEmail){
                    $firstName=connection::sanitize($_POST["firstName"]);
                    $lastName=connection::sanitize($_POST["lastName"]);
                    $phone=connection::sanitize($_POST["phone"]);
                    $email=connection::sanitize($_POST["email"]);
                    $userName=connection::sanitize($_POST["userName"]);
                    $password=connection::sanitize(connection::hashPassword($_POST["password"]));
                    $sql="INSERT INTO `users`(`firstName`,`lastName`,`phone`,`email`,`userName`,`password`) VALUES ('$firstName','$lastName','$phone','$email','$userName','$password')";
                    $result=$conn->query($sql);
                    if ($result){
                        $sql2="SELECT * FROM `users` WHERE `email`='$email'";
                        $result2=$conn->query($sql2);
                        if ($result2->num_rows){
                            $ress=$result2->fetch_assoc();
                            $infoArray=array(
                                "id"=>$ress["id"],
                                "fullName"=>$ress["firstName"]." ".$ress["lastName"],
                                "userName"=>$ress["userName"],
                                "phone"=>$ress["phone"],
                                "password"=>$ress["password"],
                                "email"=>$ress["email"],
                                "time"=>time()+30000
                            );
                            $_SESSION["userInfo"]=$infoArray;
                        }
                    }
                }
                else{
                    $filterFlag=true;
                    $errors[]="این ایمیل قبلا استفاده شده لطفا ایمیل جدید استفاده کنید";
                }
                connection::disconnect($conn);
            }
            else{
                connection::error();
                if (empty($_POST["firstName"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد نام الزامی است";
                }
                if (empty($_POST["lastName"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد نام خانوادگی الزامی است";
                }
                if (empty($_POST["phone"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد شماره تماس الزامی است";
                }
                if (empty($_POST["email"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد پست الکترونیکی الزامی است";
                }
                if (empty($_POST["userName"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد نام کاربری الزامی است";
                }
                if (empty($_POST["password"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد رمز عبور الزامی است";
                }
                if (empty($_POST["re-password"])){
                    $filterFlag=true;
                    $errors[]="پرکردن فیلد تکرار رمز عبور الزامی است";
                }
                if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
                    $filterFlag=true;
                    $errors[]="لطفا ایمیل خود رو به درستی وارد کنید";
                }
                if (!preg_match('/\+98|0(9\d{2,})\d{7}/',$_POST["phone"])){
                    $filterFlag=true;
                    $errors[]="شماره شما صحیح نیست";
                }
                if (!preg_match('/[a-z0-9-_]{4,}/',$_POST["userName"])){
                    $filterFlag=true;
                    $errors[]="نام کاربری شما باید از پنج حرف بیشتر باشد و از حروف لاتین استفاده کنید";
                }
                if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-z0-9A-Z!@#$%^&*]{5,}/',$_POST["password"])){
                    $filterFlag=true;
                    $errors[]="پسور شما باید از 5 حرف بیشتر شود و باید شامل یک کاراکتر خاص و باید از حروف لاتین استفاده شود حداقل یک عدد باشد";
                }
            }
    }
    if(isset($_POST["login"])) {
        if (!empty($_POST["emailLogin"]) && !empty($_POST["passwordLogin"])) {
            $checkLogin = connection::checkLogin($_POST["emailLogin"],connection::hashPassword($_POST["passwordLogin"]));
            if ($checkLogin) {
                echo "";
            } else {
                $filterFlag = true;
                $errors[] = "رمز عبور یا نام کاربری که وارد کردید اشتباه است";
            }
        }
        else{
            connection::error();
            if (empty($_POST["emailLogin"])){
                $filterFlag = true;
                $errors[] = "پرکردن فیلد نام کاربری الزامی است";
            }
            if (empty($_POST["passwordLogin"])){
                $filterFlag = true;
                $errors[] = "پرکردن فیلد رمز عبور الزامی است";
            }

        }
    }
    if (isset($_POST["changePassTime"])){
        $conn=connection::connect();
        $phone=$_GET["id"];
        $passwordss=connection::hashPassword($_POST["resetPassword"]);
        echo $passwordss;

        $sql="UPDATE `users` SET `password` = '$passwordss' WHERE `phone`='$phone' ";
        $res=$conn->query($sql);
        if ($res){
            header("Location: http://localhost/project-php-oop/index.php");
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
  title: 'باموقیت عوض شد'
})
        })</script>";
        }
    }
    ?>
</head>
<body>
<?php if (isset($_GET["id"])): ?>
    <div class="col-8 resetPPassword position-absolute">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <form action="" method="post" novalidate>
                    <div class="my-3">
                        <input type="password" class="form-control" name="resetPassword">
                    </div>
                    <button class="btn btn-secondary mx-auto d-block" type="submit" name="changePassTime">تغییر انجام شود</button>
                </form>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
<?php endif; ?>
<div class="col-12 navbarCartShop d-flex justify-content-around align-items-center flex-row-reverse" >
    <div class="shoppingCart position-relative">
        <a href="cart.php">
            <span class="badge badge-light bg-danger position-absolute badgeLeft">4</span>
            <i class="fas fa-shopping-cart"></i>
        </a>
    </div>
    <div class="btnParent ">
        <?php if(isset($_SESSION["userInfo"])){
            echo '<button class="btn btn-danger"><a href="dashboardUser.php" class="text-white">'.$_SESSION["userInfo"]["fullName"].'</a></button>';
        }
        else{
            echo '<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">            ثبت نام
        </button>';
        }
        ?>




        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="font-size-2 text-center changeFormTitle">فرم ثبت نام</h6>
                            <?php if ($filterFlag): ?>
                                <?php foreach ($errors as $error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $error?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                                </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <form action=""  method="post" id="formRegister" class="d-none" novalidate>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">نام کامل:</label>
                                    <input type="text" class="form-control" name="firstName">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">نام خانوادگی:</label>
                                    <input type="text" class="form-control" name="lastName">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">شماره تماس:</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">پست الکترونیکی:</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">نام کاربری:</label>
                                    <input type="text" class="form-control" name="userName">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">رمز عبور:</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">تکرار رمز عبور:</label>
                                    <input type="password" class="form-control" name="re-password">
                                </div>
                                <button class="btn btn-light" name="signUp">ثبت نام</button>
                            </form>
                            <form action="" id="fromLogin" method="post" novalidate>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">ایمیل:</label>
                                    <input type="text" class="form-control" name="emailLogin">
                                </div>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">رمز عبور:</label>
                                    <input type="password" class="form-control" name="passwordLogin">
                                    <a href="#" style="text-decoration: underline" class="resetPassword">اگر رمزتان را یادتون رفته کلیک کنید</a>
                                </div>
                                <button class="btn btn-light" name="login">ورود</button>
                            </form>
                            <form action="" id="resetPassword" method="post" class="d-none" novalidate>
                                <div class="mb-3 parentInputForm">
                                    <label for="" class="label-control col-3 mb-2">پست الکترونیکی:</label>
                                    <input type="email" class="form-control" name="emailReset">
                                </div>
                                <button type="submit" class="btn btn-light" name="changePass">انجام عملیات</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <span id="changeFormTitle" class="text-secondary text-center d-flex justify-content-center"><a href="" class="" style="cursor: pointer">من در این سایت حسابی ندارم.</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="btn btn-dark barsResponsive d-lg-none d-block"><i class="fas fa-bars"></i></button>
</div>
<div class="col-lg-12 col-6 navbarCustom transformToggleClass p-1 d-lg-block position-absolute " style="z-index: 2">
    <ul class="d-flex me-3 liItemParent align-items-lg-end align-items-stretch flex-column flex-lg-row">
        <li class="me-lg-2 mt-3 mt-lg-0 mb-3 mb-lg-0 liMegaMenu">
            <div class="d-flex align-items-center buttonMegaMenu">

                <i class="fas fa-bars" style="transform: translateX(10px)"></i>
                <a href="#" class="text-dark fw-bold">دسته بندی کالاها</a>
            </div>


            <div class="justify-content-center megaMenuMain flex-lg-row flex-column">
                <div class="itemMegaMenu">
                    <ul>
                        <li class="categoryName d-flex align-items-baseline">
                            <i class="fas fa-chevron-up d-lg-none d-block align-items-baseline" style="transform: translateX(10px)"></i>
                            <a href="#" class="text-dark fw-bold">لباس مردانه</a>
                        </li>
                        <div class="itemChild d-none d-lg-block">
                            <li>
                                <a href="products.php?category=man?type=t-shirt">تی شرت و پولو شرت</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=pirahan">پیراهن</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=Pants">شلوار</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=jeans">جوراب</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=pants-shorts">شلوارک</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=suit">کت و ست رسمی</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=sweatshirt">سویشرت و هودی</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=jacket">ژاکت و پلیور</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=stilettos">تاپ و رکابی</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=copshan">کاپشن</a>
                            </li>
                            <li>
                                <a href="products.php?category=man?type=autumn-vest">جلیقه پاییزه</a>
                            </li>
                        </div>

                    </ul>
                </div>
                <div class="itemMegaMenu">
                    <ul>
                        <li class="categoryName d-flex align-items-baseline">
                            <i class="fas fa-chevron-up d-lg-none d-block align-items-baseline" style="transform: translateX(10px)"></i>
                            <a href="" class="text-dark fw-bold">لباس زنانه</a>
                        </li>
                        <div class="itemChild d-none d-lg-block">
                            <li>
                                <a href="products.php?category=women?type=t-shirt">تی‌شرت و پولوشرت</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=clothes-sleep">لباس راحتی و خواب</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=manto">مانتو، پانچو و رویه</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=paper">شومیز</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=top">تاپ</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=tonic">تونیک</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=sweatshirt">سویشرت و هودی</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=jacket">ژاکت و پلیور</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=jeans">جوراب</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=pants-saree">شلوار و سرهمی</a>
                            </li>
                            <li>
                                <a href="products.php?category=women?type=skirt">دامن</a>
                            </li>
                        </div>

                    </ul>
                </div>
                <div class="itemMegaMenu">
                    <ul>
                        <li class="categoryName d-flex align-items-baseline">
                            <i class="fas fa-chevron-up d-lg-none d-block align-items-baseline" style="transform: translateX(10px)"></i>
                            <a href="" class="text-dark fw-bold" >مراقبت پوست</a>
                        </li>
                        <div class="itemChild d-none d-lg-block">
                            <li>
                                <a href="products.php?category=skin-care?type=sunscreen"> کرم ضد آفتاب</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=moisturizing-softening"> کرم مرطوب کننده و نرم کننده</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=sunlotion-oil">لوسیون و روغن آفتاب</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=eye-cream">کرم دور چش</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=body-lotion-oil">لوسیون و روغن بدن</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=anti-wrinkle-cream">کرم ضد چروک</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=anti-wrinkle-cream">کرم روشن کننده</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=anti-stain-cream">کرم ضد لک</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=exfoliating-cream">کرم لایه بردار</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=acne-cream-gel">کرم و ژل ضد جوش</a>
                            </li>
                            <li>
                                <a href="products.php?category=skin-care?type=repairing-cream-gel">کرم و ژل ترمیم کننده</a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </li>
        <hr class="d-lg-block d-none">
        <li class="me-lg-3 mt-3 mt-lg-0">
            <i class="fas fa-home"></i>
            <a href="index.php">صفحه اصلی</a>
        </li>
        <li class="me-lg-5 mt-3 mt-lg-0">
            <i class="fas fa-fire"></i>
            <a href="bestselling.php">پرفروش ترین ها</a>
        </li>
        <li class="me-lg-5 mt-3 mt-lg-0">
            <i class="fas fa-id-badge"></i>
            <a href="discount-product.php" class="fa-white">تخفیف ها و پیشنهاد ها</a>
        </li>
        <li class="me-lg-5 mt-3 mt-lg-0">
            <i class="fas fa-question"></i>
            <a href="faq.php">سوالی دارید</a>
        </li>
        <li class="me-lg-5 mt-3 mt-lg-0">
            <i class="fas fa-info"></i>
            <a href="about-us.php" class="fa-white">درباره ما</a>
        </li>
    </ul>

</div>
<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" style="z-index: 1">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="images/3.jpg" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="dicountSection">
    <div class="owl-carousel owl-theme ">
        <?php for ($i=0;$i<count(manageProducts::getProuctByPurchase(9));$i++): ?>
        <div class="card directionRtl" style="width: 350px;">
            <a href="productPage.php?id=<?php echo manageProducts::getProuctByPurchase(10)[$i]->id ?>" class="text-dark">
                <div class="card-header">
                    <span class="text-danger fw-bold banner-discount">پیشنهاد شگفت انگیز</span>
                </div>
                <div class="card-body position-relative body-custom">
                    <div class="btn backgroundCustomButton btn-sm position-absolute top-0 rounded-0 text-dark brander-label"><?php echo manageProducts::getProuctByPurchase(10)[$i]->nameCompany ?></div>
                    <img src="images/product/<?php echo manageProducts::getProuctByPurchase(10)[$i]->image_address ?>.jpg" alt="">
                    <div class="btn btn-dark btn-sm label-discount position-absolute bottom-0 rounded-0 text-light "><?php echo manageProducts::getProuctByPurchase(10)[$i]->discount ?>%</div>
                </div>
                <div class="card-footer pb-2">
                    <span class="font-size-1 d-block"><?php echo manageProducts::getProuctByPurchase(10)[$i]->nameProduct ?></span>
                    <div class="prices-box">
                        <span class="discountPrice"><?php echo manageProducts::getProuctByPurchase(10)[$i]->price ?></span>
                        <span class="realPrice"><?php echo manageProducts::convertDiscount(manageProducts::getProuctByPurchase(10)[$i]->price,manageProducts::getProuctByPurchase(10)[$i]->discount) ?></span>

                    </div>
                </div>
            </a>
        </div>
        <?php endfor; ?>

        <button class="btn btn-danger btn-all-discout rounded-0 btn-lg d-xl-block d-none"><a href="bestselling.php" class="text-white">مشاهده همه</a></button>
    </div>
</div>
<div class="CategorySection mb-3">
    <div class="col-10 mx-auto pt-4 pb-4">
        <div class="d-flex categoryNamesParent flex-row-reverse justify-content-evenly">
            <span class="categoryNameSp position-relative d-block text-dark afterClick fw-bold" data-category="man">لباس مردانه</span>
            <span class="categoryNameSp position-relative d-block text-dark" data-category="woman">لباس زنانه</span>
            <span class="categoryNameSp position-relative d-block text-dark" data-category="skin">مراقبت پوست</span>
        </div>
        <div class="line"></div>
        <div class="galleryPhotoCategory col-12 position-relative mt-4 position-relative">
            <img src="images/tombnailPhoto/1_thumb_man.jpg" class="w-100 h-100 position-absolute" alt="">
            <button class="btn btn-secondary btn-lg"><a href="">لباس مردانه</a></button>
        </div>
    </div>

    <div class="col-10 mx-auto">
        <div class="d-flex justify-content-between">
            <div class="col-3 position-relative d-xl-block d-none"><a href="#">
                <div class="parentImages w-100"><img src="images/tombnailPhoto/2_thumb_man.jpg" alt=""></div>
                    </a>
            </div>
            <div class="col-3 position-relative d-xl-block d-none"><a href="#">
                <div class="parentImages w-100"><img src="images/tombnailPhoto/3_thumb_man.jpg" alt="" class="w-100"></div>
                </a>
            </div>
            <div class="col-3 position-relative d-xl-block d-none"><a href="#">
                <div class="parentImages w-100"><img src="images/tombnailPhoto/3_thumb_man.jpg" alt="" class="w-100"></div>
                </a>
            </div>
        </div>
    </div>
    
</div>
<div class="popularProduct mx-auto">
    <h4 class="text-center text-dark mb-5">محصولات محبوب ما <i class="fas fa-money-check-alt"></i></h4>
    <?php
        for ($i=1;$i<=count(manageProducts::getProuctByPurchase(12))/6;$i++){
            $str='<div class="col-12 productPrent d-flex justify-content-center mx-auto">';
            for ($s=($i*6)-6;$s<$i*6;$s++){
                if ($s%3==0){
                    $str.='<div class="col-lg-2 productCart d-lg-flex d-none justify-content-center"><a href="productPage.php?id='.manageProducts::getProuctByPurchase(12)[$s]->id.'">
            ';
                }
                else{
                    $str.='<div class="col-lg-2  col-6 productCart d-flex justify-content-center"><a href="productPage.php?id='.manageProducts::getProuctByPurchase(12)[$s]->id.'">';
                }
                $str.='            <div class="parentImagePopularSection d-flex justify-content-center">
                <img src="images/product/'.manageProducts::getProuctByPurchase(12)[$s]->image_address.'.jpg" alt="">
            </div>
            <div class="py-4 text-dark">
                <div class="d-flex justify-content-center flex-row-reverse text-danger fw-bold">
                    <span class="text-dark realPrice">'.manageProducts::getProuctByPurchase(12)[$s]->price.'</span>
                    <span class="mx-1 text-dark">تومان</span>
                </div>
            </div>
        </a></div>';
            }
            $str.='</div>';
            echo $str;
        }
    ?>
    <div class="linkPopularProduct d-flex justify-content-center mt-3">
        <a href="bestselling.php"><i class="fas fa-chevron-left mx-2"></i>مشاهده بیشتر</a>
    </div>
</div>
<div class="bannerSection">
    <div class="col-12 d-flex flex-wrap">
        <div class="col-md-6 col-12 parentPicSuggest">
            <a href=""><img src="images/man-master-pic.jpg" alt=""></a>
        </div>
        <div class="col-md-6 col-12 parentPicSuggest">
            <a href=""><img src="images/man-master-pic.jpg" alt=""></a>
        </div>
    </div>
</div>

<span class="text-center text-darkr d-block font-size-2">پیشنهاد ما به شما <i class="fas fa-ad" style="    vertical-align: middle;"></i></span>
<div class="suggestSectionCategory mx-auto">

    <div class="col-12 d-flex">
<?php
            for ($io=1;$io<=count(manageProducts::getProuctByPurchase(12))/6;$io++){
                $str='<div class="col-12 col-lg-6 d-flex">';
                for ($so=($io-1)*3;$so<$io*3;$so++){
                    $str.='<div class="col-lg-4 col-6 d-flex flex-column">';
                    for ($m=$so*2;$m<=($so*2)+1;$m++){
                        $str.='<a href="productPage.php?id='.manageProducts::getProuctByPurchase(12)[$m]->id.'"><div class="col-12 box-image-Suggest d-flex justify-content-center align-items-center flex-column">
                    <img src="images/product/'.manageProducts::getProuctByPurchase(12)[$m]->image_address.'.jpg" alt="">
                    <span class="d-block text-danger text-dark textEllipsis">'.manageProducts::getProuctByPurchase(12)[$m]->nameProduct.'</span>
                </div></a>';
                    }
                    $str.="</div>";
                }
                $str.='</div>';
                echo $str;
            }

        ?>
    </div>
</div>
<div class="col-12 my-5 d-flex justify-content-center flex-wrap text-center">
    <div class="col-lg-3 col-6">
        <img src="images/logos/cash-on-delivery.svg" alt="">
        <small class="d-block">ضمانت اصل بودن کالا</small>
    </div>
    <div class="col-lg-3 col-6">
        <img src="images/logos/days-return.svg" alt="">
        <small class="d-block">امکان بازگشت کالا</small>
    </div>
    <div class="col-lg-3 col-6 mt-lg-0 mt-5">
        <img src="images/logos/express-delivery.svg" alt="">
        <small class="d-block">۷ روز ﻫﻔﺘﻪ، ۲۴ ﺳﺎﻋﺘﻪ</small>
    </div>
    <div class="col-lg-3 col-6 mt-lg-0 mt-5">
        <img src="images/logos/original-products.svg" alt="">
        <small class="d-block">امکان پرداخت در محل</small>
    </div>

</div>

<footer class="col-12 d-flex justify-content-center py-5 flex-wrap flex-row-reverse footer">
    <div class="col-lg-4 col-6 d-flex flex-column text-center">
        <span class="fw-bold title-footer text-center mb-3">منو های اصلی</span>
        <ul>
            <li class="menuChildFirstColumn">
                <a href="index.php" class="text-dark">صفحه اصلی</a>
            </li>
            <li class="menuChildFirstColumn">
                <a href="bestselling.php" class="text-dark">پرفروش ترین ها</a>
            </li>
            <li class="menuChildFirstColumn">
                <a href="discount-product.php" class="text-dark">تخفیف و پیشنهاد ها</a>
            </li>
            <li class="menuChildFirstColumn">
                <a href="faq.php" class="text-dark">سوالی دارید</a>
            </li>
            <li class="menuChildFirstColumn"><a href="about-us.php" class="text-dark">درباره ما</a></li>
        </ul>
    </div>
    <div class="col-lg-4 col-6 d-flex flex-column text-center">
        <span class="fw-bold title-footer text-center mb-3">ارتباط با ما</span>
        <ul>
            <li class="menuChildFirstColumn">
                <a href="#" class="text-dark">:شماره تماس</a>
                <span class="number d-block">021-112289</span>
            </li>
            <li class="menuChildFirstColumn">
                <a href="#" class="text-dark">:پست الکترونیکی</a>
                <span class="number d-block">tahajob1382@gmail.com</span>
            </li>
            <li class="menuChildFirstColumn">
                <a href="#" class="text-dark">:شماره همراه</a>
                <span class="number d-block">09393545718</span>
            </li>
        </ul>
    </div>
    <div class="col-lg-4 col-6 d-flex flex-column text-center">
        <span class="fw-bold title-footer mb-3">اطلاعات شرکت</span>
        <ul>
            <li class="menuChildFirstColumn">
                <a href="#" class="text-dark">:ادرس شرکت</a>
                <span class="number d-block">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ   </span>
            </li>
            <li class="menuChildFirstColumn">
                <a href="#" class="text-dark">:شعارما</a>
                <span class="number d-block">کار تیمی نماد قدرت و همکاری ماست</span>
            </li>

        </ul>
    </div>
</footer>









</body>
</html>