
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>لباس ها</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="node_modules/normalize.css/normalize.css">
    <link rel="stylesheet" href="node_modules/fontawesome/css/all.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.carousel.css">
    <link rel="stylesheet" href="node_modules/owl.carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/master.css">
    <?php require_once "includes/required.php";
    $filterFlag=false;
    $errors=array();
    if (isset($_POST["changePass"])){
        if (!empty($_POST["emailReset"]) && filter_var($_POST["emailReset"])){
            connection::resetEmail("reset my email","<div>کار شما اشتباه اسن</div>","tahajob1382@gmai.com");
        }
        else{
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

    ?>
</head>
<body>
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
<div class="popularProducts">
    <?php
    require_once "includes/required.php";

    for ($parentAverage=1; $parentAverage<=ceil(((count(manageProducts::getProuctByPurchase(40))+1))/4); $parentAverage++){

        $number=1;
        $str='<div class="col-12 d-flex justify-content-center flex-wrap">';
        $maxLengthWidth=$parentAverage*4 > count(manageProducts::getProuctByPurchase(40)) ? count(manageProducts::getProuctByPurchase(40)) :$parentAverage*4;
        for ($singleCarts=($parentAverage-1)*4; $singleCarts<$maxLengthWidth; $singleCarts++){
            if (manageProducts::getProuctByPurchase(40)[$singleCarts]->discount==0){
                $str .= " <div class='col-lg-3 col-sm-6 col-12 cartPopular'>
                <div class='extrasImageParent'>                <a href='productPage.php?id=".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."' data-id='".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."'><div class='imageParentPopular d-flex flex-column col-12'>
                <div class='imagePrentPopular d-flex justify-content-center d-block col-12 foe'>
                    <label class='labelNumberProduct' style='z-index: 1'>" . ($singleCarts + 1) . "</label>
                    <img src='images/product/" . manageProducts::getProuctByPurchase(40)[$singleCarts]->image_address . ".jpg' class='d-block mx-lg-auto' alt=''>
                </div>
                <div class='titlePopualrShop col-12 p-2 d-md-block d-flex justify-content-center'>
                    <span class='textTitleProduct font-size-1 text-dark'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->nameProduct . "</span>
                </div>
                <div class='col-12 d-flex py-3 ps-2 pricesPartPopular'>
                    <div class='col-6'>
                        <span class='floatLeft text-dark'>تومان</span>
                        <div class='d-flex flex-column'>
                            <span class='fw-bold ms-2 text-dark realPrice'>" . manageProducts::convertDiscount(manageProducts::getProuctByPurchase(40)[$singleCarts]->price, manageProducts::getProuctByPurchase(40)[$singleCarts]->discount) . "</span>
                            <span class='fw-bold ms-2 text-secondary defiedPrice opacity-0'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->price . "</span>
                         </div>

                    </div>
                    <div class='col-6'>
                        <div class='badgeDesfire text-dark opacity-0'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->discount."%".  "</div>
                    </div>
                </div>
                <div class='col-11 mx-auto d-flex sendSectionDetail'>
                    <div class='col-6 favoritesProduct'>
                        <a href='#'>
                       <i class='fas fa-shopping-cart text-secondary' data-id-product='".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."'></i>
                        </a>
                    </div>
                    <div class='col-6 d-flex justify-content-end'>
                        <span class='titleSendComapny me-2 text-dark'>ارسال سریع سوپر مارکتی</span>
                        <i class='fas fa-truck text-secondary'></i>
                    </div>
                </div>
            </div></a></div>

            </div> ";
            }
            else{
                $str .= " <div class='col-lg-3 col-sm-6 col-12 cartPopular'>
                <div class='extrasImageParent'>                <a href='productPage.php?id=".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."' data-id='".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."'><div class='imageParentPopular d-flex flex-column col-12'>
                <div class='imagePrentPopular d-flex justify-content-center d-block col-12 foe'>
                    <label class='labelNumberProduct' style='z-index: 1'>" . ($singleCarts + 1) . "</label>
                    <img src='images/product/" . manageProducts::getProuctByPurchase(40)[$singleCarts]->image_address . ".jpg' class='d-block mx-lg-auto' alt=''>
                </div>
                <div class='titlePopualrShop col-12 p-2 d-md-block d-flex justify-content-center'>
                    <span class='textTitleProduct font-size-1 text-dark'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->nameProduct . "</span>
                </div>
                <div class='col-12 d-flex py-3 ps-2 pricesPartPopular'>
                    <div class='col-6'>
                        <span class='floatLeft text-dark'>تومان</span>
                        <div class='d-flex flex-column'>
                            <span class='fw-bold ms-2 text-dark realPrice'>" . manageProducts::convertDiscount(manageProducts::getProuctByPurchase(40)[$singleCarts]->price, manageProducts::getProuctByPurchase(40)[$singleCarts]->discount) . "</span>
                            <span class='fw-bold ms-2 text-secondary defiedPrice'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->price . "</span>
                        </div>

                    </div>
                    <div class='col-6'>
                        <div class='badgeDesfire text-dark'>" . manageProducts::getProuctByPurchase(40)[$singleCarts]->discount . "%</div>
                    </div>
                </div>
                <div class='col-11 mx-auto d-flex sendSectionDetail'>
                    <div class='col-6 favoritesProduct'>
                        <a href='#'>
                       <i class='fas fa-shopping-cart text-secondary' data-id-product='".manageProducts::getProuctByPurchase(40)[$singleCarts]->id."'></i>
                        </a>
                    </div>
                    <div class='col-6 d-flex justify-content-end'>
                        <span class='titleSendComapny me-2 text-dark'>ارسال سریع سوپر مارکتی</span>
                        <i class='fas fa-truck text-secondary'></i>
                    </div>
                </div>
            </div></a></div>

            </div> ";
            }

        }

        $str.='</div>';
        echo $str;
    }
    ?>

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

<script src="node_modules/jquery/dist/jquery.js"></script>
<script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="node_modules/@persian-tools/persian-tools/build/persian-tools.umd.js"></script>
<script src="node_modules/juqery-cookie/src/jquery.cookie.js"></script>
<script src="js/script.js"></script>
<script>
    $(".shoppingCart .badgeLeft").text("0")
    $(document).ready(function () {
        $(".favoritesProduct").click(function (e) {
            e.preventDefault()
            var Id=$(this).children("a").attr("data-id");
            var nameProduct=$(this).parent().parent().parent().children().children().children(".titlePopualrShop").text();
            var count=1;
            var imageAddress=$(this).parent().parent().parent().children().children().children(".imagePrentPopular").children("img").attr("src");
            var priceProduct=$(this).parent().parent().parent().children().children().children(".pricesPartPopular").children().children(".flex-column").children(".realPrice").text();
            shoppingCart(Id,nameProduct,count,imageAddress,priceProduct)
        })


    })


</script>

</body>
</html>