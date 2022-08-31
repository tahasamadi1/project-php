<?php
require_once "includes/required.php";
?>
<?php
$sql="SELECT * FROM products";
    if (isset($_POST["category"]) || isset($_POST["brand"]) ){
        if (!strpos($sql,'WHERE')){
            $sql.=' WHERE ';
        }
        if (isset($_POST["category"])){
            $category=implode(",",$_POST["category"]);
            $categoryQuery='idCategory in ('.$category.')';
        }
        if (isset($_POST["brand"])){
            $brand=implode(",",$_POST["brand"]);
            $brandQuery='id_company in ('.$brand.')';
        }
        if (isset($_POST["brand"]) && !isset($_POST["category"])){
            $sql.=$brandQuery;
        }
        if (isset($_POST["category"]) && !isset($_POST["brand"])){
            $sql.=$categoryQuery;
        }
        if (isset($_POST["category"]) && isset($_POST["brand"])){
            $sql.='id_company in ('.$brand.') AND idCategory in ('.$category.')';
        }
    }
        $dataDefaults=manageProducts::allProduct($sql);
        if ($dataDefaults){
            for ($i=0;$i<(count($dataDefaults)-1)/4;$i++){
                $parent='<div class="col-10 mx-auto d-flex justify-content-around flex-wrap mt-4">';
                for ($s=($i*4);$s<($i*4)+4;$s++){
                    if (isset($dataDefaults[$s])){
                        $parent.='<div class="col-md-2 col-5 imageProductDetail directionRtl">
            <a href="productPage.php?id='.$dataDefaults[$s]['id'].'">
                <div class="parentImageProduct position-relative">
                    <img src="images/product/'.$dataDefaults[$s]['image_address'].'.jpg" class="w-100 h-100" alt="">
                    <div class="btn btn-dark rounded-0 position-absolute labelDiscountProduct btn-sm">'.$dataDefaults[$s]["discount"].'%</div>
                </div>
            </a>
            <div class="priceProduct py-2">
                <span class="nameProduct d-block textEllipsis">'.$dataDefaults[$s]["nameProduct"].'</span>

                <div class="price-product mt-2 d-flex justify-content-between">
                    <span class="realPrice">'.manageProducts::convertDiscount($dataDefaults[$s]["price"],$dataDefaults[$s]["discount"]).'</span>
                    <a href="#" class="text-dark shoppingAdd" data-id="'.$dataDefaults[$s]["id"].'"><i class="fas fa-shopping-cart"></i></a>
                    <span class="text-secondary discountPrice" style="text-decoration: line-through">'.$dataDefaults[$s]["price"].'</span>
                </div>
            </div>

        </div>';
                    }

                }
                $parent.="</div>";
                echo $parent;
            }
        }
        else{
            echo "<div class='mx-auto alert alert-danger col-6 text-center'>نتیجه ای یافت نشد</div>";
        }

    ?>
<script>
    $(".shoppingAdd").click(function (e) {
        e.preventDefault()
        var id=$(this).parent().children(".shoppingAdd").attr("data-id")
        var nameProduct=$(this).parent().parent().children(".nameProduct ").text()
        var cunt=1;
        var imageAddress=$(this).parent().parent().parent().children("a").children(".parentImageProduct").children("img").attr("src");
        var priceProduct=$(this).parent().parent().children(".price-product").children(".realPrice").text()
        shoppingCart(id,nameProduct,cunt,imageAddress,priceProduct)
    })
</script>




