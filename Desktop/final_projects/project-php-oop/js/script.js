$(document).ready(function () {
    if (Number($(window).width()) >= 950){
        $(".navbarCustom").removeClass("transformToggleClass")
    }

    $(window).resize(function () {
        if (Number($(window).width()) >= 950){
            $(".navbarCustom").removeClass("transformToggleClass")
        }

    })
    $(".barsResponsive").click(function () {
        $(".navbarCustom").toggleClass("transformToggleClass")
    })

    $(".categoryName").click(function (e) {
        e.preventDefault();
        var className=this;
        if (Number($(window).width()) <= 950){
            $(className).parent().children(".itemChild").toggleClass("d-none")
            $(className).children(".fa-chevron-up").toggleClass("transformRotate")
        }
    })
    const myCarouselElement = document.querySelector('#carousel')
    const carousel = new bootstrap.Carousel(myCarouselElement, {
        interval: 1000,
        wrap: false
    })
    $(".categoryNameSp").click(function () {
        $(".fw-bold").removeClass("fw-bold")
        $(this).addClass("fw-bold")
        var categoryName={
            "woman":"لباس زنانه",
            "man":"لباس مردانه",
            "skin":"مراقبت پوست"
        }
        $(".afterClick").removeClass("afterClick")
        $(this).addClass("afterClick")
        var imagesName=$(this).attr("data-category")
        $(".galleryPhotoCategory button").text(categoryName[imagesName])
        var lengthImages=$(".CategorySection img").length
        for (i=1;i<=lengthImages;i++){

            $(".CategorySection img").eq(i-1).attr("src","images/tombnailPhoto/"+i+"_thumb_"+imagesName+".jpg")
        }
    })
    var $owl = $('.owl-carousel');

    $owl.on('initialized.owl.carousel resized.owl.carousel', function(e) {
        $(e.target).toggleClass('hide-nav', e.item.count <= e.page.size);
    });
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoWidth:true,
        autoHeight:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    })
    var boxImageSuggestLength=$(".box-image-Suggest").length
    $(".box-image-Suggest").eq(0).css({"border-left-color":"transparent"})
    $(".box-image-Suggest").eq(1).css({"border-left-color":"transparent"})
    for (i = 1; i <=boxImageSuggestLength ; i+=2) {
        $(".box-image-Suggest").eq(i).css({"border-bottom-color":"transparent"})
    }
    $(".resetPassword").click(function (e) {
        e.preventDefault()
        $("#resetPassword").removeClass("d-none")
        $("#fromLogin").addClass("d-none")
        $("#changeFormTitle").text("من در این سایت حساب دارم")
    })
    $("#changeFormTitle").click(function (e) {
        e.preventDefault()
        if($("#fromLogin").hasClass("d-none")){
            $("#changeFormTitle").text("من در این سایت حسابی ندارم")
            $("#fromLogin").removeClass("d-none")
            $("#resetPassword").addClass("d-none")
            $("#formRegister").addClass("d-none")
            $(".changeFormTitle").text("فرم ورود")
        }
        else{
            $(".changeFormTitle").text("فرم ثبت نام")
            $("#changeFormTitle").text("من در این سایت حساب دارم")
            $("#formRegister").removeClass("d-none")
            $("#fromLogin").addClass("d-none")
        }
    })
    function invalid(field,msg) {
        $(field).addClass("border-danger")
        $(field).after("<div class='text-danger fw-bold font-size-1 mt-2'>* "+msg+"  *</div>")
    }
    function valid(field) {
        $(field).removeClass("border-danger")
        $(field).siblings("div").remove()
    }

    const emailPattern=/[A-z1-9]{4,}@[a-z1-9]{2,}\.[a-z]{2,}/gm;
    const passwordPattern=/(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-z0-9A-Z!@#$%^&*]{5,}/;
    const userNamePattern=/[a-z0-9-_]{4,}/;
    var numberPattern=/\+98|0(9\d{2,})\d{7}/;
    var filterFlag;
    $(".parentInputForm input").blur(function () {
        $(this).siblings("div").remove()
        validationNormal(this,"این فیلد را نمی توانید خالی رها کنید",$(this).val().length==0)
    })
        function validationNormal(field,msg,validationType){
            if(validationType){
                invalid(field,msg);
                filterFlag=false;
            }
            else {
                valid(field);
                filterFlag=true;
            }
        }
        function validationRegex(pattern,msg,field){
                if (pattern.test($(field).val()) == false) {
                    invalid(field, msg);
                    filterFlag = false;
                } else {
                    valid(field)
                    filterFlag = true
                }
        }
        $("input[type='email']").blur(function () {
            if (filterFlag) {
                validationRegex(emailPattern,"فرمت ایمیل اشتباه است",this);
            }
        })
        $("input[name='password']").blur(function () {
            if (filterFlag) {
                validationRegex(passwordPattern,"پسور شما باید از 5 حرف بیشتر شود و باید شامل یک کاراکتر خاص و باید از حروف لاتین استفاده شود حداقل یک عدد باشد",this);
            }
        })
    $("input[name='userName']").blur(function () {
        if (filterFlag) {
            validationRegex(userNamePattern,"نام کاربری شما باید از پنج حرف بیشتر باشد و از حروف لاتین استفاده کنید",this);
        }
    })
    $("input[name='re-password']").blur(function () {
        if (filterFlag){
                validationNormal(this,"فیلد رمز عبور و تکرار ان باید شبیه باشند",$("input[name='password']").val()!=$("input[name='re-password']").val())
        }
    })
    $("input[name='phone']").blur(function () {

        if (filterFlag){

            validationRegex(numberPattern,"لطفا شماره خود را به درستی وارد کنید",this)
        }
    })
    $(".clickToggle").click(function () {
        $(this).children("i").toggleClass("transformRotateExt")
        $(this).parent().children(".filterChild").slideToggle()
    })

    $("[data-next='true']").click(function () {
        if (Number($(".inputCount").val()+1) >= 1){
            var count=Number($(".inputCount").val())
           return  $(".inputCount").val(count+1)
        }
    })
    $("[data-prev='true']").click(function () {
        if (Number($(".inputCount").val()-1) >= 1){
            var count=Number($(".inputCount").val())
            return  $(".inputCount").val(count-1)
        }
    })
    $(".allTheAnswer").click(function () {
        $(this).children("i").toggleClass("fa-chevron-up");
        $(".extraComments").slideToggle(2000,"swing")
    })
    $(".responsiveBarIcon").click(function () {
        $(".dashboardItem").toggleClass("responsiveDashboard")
        $(".detailDashboard").toggleClass("col-12")
        $(".detailDashboard").toggleClass("mrCustom")
    })
    $(".detailDashboard table td , .detailDashboard table th").addClass("text-center textEllipsis text-dark")
    $("[data-display]").click(function (e) {
        e.preventDefault()
        $(".dashboardDetail").addClass("d-none")
        $(".activeDashboardItem").removeClass("activeDashboardItem")
        $(this).addClass("activeDashboardItem")
        var classPoint=$(this).attr("data-display")
        $("."+classPoint).addClass("d-block")
        $("."+classPoint).removeClass("d-none")
    })
    $(".messagesAdmin input , .messagesAdmin textarea").blur(function () {
        $(".errorTextarea").remove()
        if($(this).val().length==0){
             $(this).after("<div class='text-danger mt-1 errorTextarea'>*این فیلد نمیتواند خالی باشد*</div>")
        }
        else {
            $(".errorTextarea").remove()
        }
    })
    $("[data-show]").click(function () {
        var classPoint=$(this).attr("data-show")
        if($(".manageMessages").children("d-none")){
            $(".manageMessages .d-none").removeClass("d-none")
        }
        $("."+classPoint).addClass("d-none")
        $("[data-show]").removeClass("btn-secondary text-white")
        $("[data-show]").addClass("btn-outline-secondary")
        $(this).addClass("btn-secondary text-white")
    })
    $("[data-filterMessage]").click(function () {
        var prefixBtnColor=$(this).attr("data-filterMessage")
        var lengthButton=$("[data-filterMessage]").length;
        for ( i = 0; i <lengthButton ; i++) {
            $("[data-filterMessage]").eq(i).removeClass("btn-"+$("[data-filterMessage]").eq(i).attr("data-filterMessage")+"")
        }
        $(this).addClass("btn-"+prefixBtnColor+"")
    })
    for(i=0;i < $(".realPrice").length ;i++){
        $(".label-discount ").eq(i).text(PersianTools.digitsEnToFa($(".label-discount").eq(i).text()))
        $(".realPrice").eq(i).text(PersianTools.digitsEnToFa($(".realPrice").eq(i).text()))
        $(".labelDiscountProduct").eq(i).text(PersianTools.digitsEnToFa($(".labelDiscountProduct").eq(i).text()))

        $(".labelNumberProduct").eq(i).text(PersianTools.digitsEnToFa($(".labelNumberProduct").eq(i).text()))
        $(".badgeDesfire ").eq(i).text(PersianTools.digitsEnToFa($(".badgeDesfire ").eq(i).text()))
        $(".likeCountPpular ").eq(i).text(PersianTools.digitsEnToFa($(".likeCountPpular ").eq(i).text()))
    }
    if (typeof ($.cookie('shoppingItem'))=='undefined'){
        $(".shoppingCart .badgeLeft").text("0")
    }
    else {
        var shoppingItem=JSON.parse($.cookie("shoppingItem"));
        $(".shoppingCart .badgeLeft").text(shoppingItem.length)
    }
    $(".messageModlaButton").click(function () {
        $(".messageSelected").text(($(this).parent().children("div").text()))
    })
    var index=1;
    if (typeof ($.cookie('shoppingItem')) !== 'undefined'){
        $(".alert-null").addClass("d-none")
        console.log(JSON.parse($.cookie('shoppingItem')))
        $.each(JSON.parse($.cookie('shoppingItem')),function (key,element) {
            $(".shoppingCartShow").append(`<tr>
                    <th scope="row" class="idProductShopping text-center"></th>
                    <td class="nameProductShopping text-center"></td>
<input type="hidden" class="nameProductShoppingEx text-center" name="nameProductShop[]">
                    <td class="priceProductShopping text-center"></td>
                    <input type="hidden" class="priceProductShoppingEx" name="priceProductShopping[]">
                    <td class="countProductShopping text-center"></td>
                    <input type="hidden" class="countProductShoppingEx" name="countProductShopping[]">
                </tr>
`)
            $(".idProductShopping").eq(key).text(index)
            $(".nameProductShopping").eq(key).text(element.nameProduct)
            $(".nameProductShoppingEx").eq(key).val(element.nameProduct)
            $(".priceProductShopping").eq(key).text(element.priceProduct)
            $(".priceProductShoppingEx").eq(key).val(element.priceProduct)
            $(".countProductShopping").eq(key).text(element.count)
            $(".countProductShoppingEx").eq(key).val(element.count)
            index++;
        })
    }
    else{
        $("[name='buyIt']").addClass("d-none")
    }
    if(window.location.href.indexOf("filterMessage")!=-1){
        $(".dashboardDetail").addClass("d-none")
        $(".commentsUser").removeClass("d-none")
        $(".commentsUser").addClass("d-block")
        var indexItem=window.location.href.split("filterMessage")[1].split("=")[1];
        if (indexItem){
            $(".preventDefault").children("button").removeClass("active")
            $(".preventDefault").eq(Number(indexItem)).children("button").addClass("active")
            $(".itemDashboardLi").removeClass("activeDashboardItem")
            $(".itemDashboardLi").eq(2).addClass("activeDashboardItem")
        }

    }
    if (typeof ($.cookie('shoppingItem')) !== 'undefined'){
        $.each(JSON.parse($.cookie('shoppingItem')),function (key,element) {
            $(".shoppingCartProduct tbody").append(`<tr>
                    <td class="text-center numberRowCart">1</td>
                    <td class="text-center textRowCart">کتونی مشکی</td>
                    <td class=" textPriceRow text-center"></td>
                    <td class=" text-center countProduct fw-bold"></td>
                </tr>`)
            $(".shoppingCartProduct td.numberRowCart").eq(key).text(key+1)
            $(".shoppingCartProduct td.textRowCart").eq(key).text(element.nameProduct)
            $(".shoppingCartProduct td.textPriceRow").eq(key).text(element.priceProduct)
            $(".shoppingCartProduct td.textPriceRow").eq(key).attr("data-attr",PersianTools.digitsFaToEn(element.priceProduct))
            $(".shoppingCartProduct td.countProduct").eq(key).text(PersianTools.digitsEnToFa(element.count))

        })

    }
    var tottalPrice=0;
    for($i=0;$i<$(".textPriceRow").length;$i++){
        tottalPrice+=Number($(".textPriceRow").eq($i).attr("data-attr"))
    }
        $(".totalPrice").text(PersianTools.digitsEnToFa(tottalPrice))

    var selectorCounter=$(".fieldCount");
    $("[data-plus='true']").click(function () {
        var shoppingCartPlus=selectorCounter.val();
        selectorCounter.val(Number(shoppingCartPlus)+1)
    })
    $("[data-neg='true']").click(function () {
        var shoppingCartPlus=selectorCounter.val();
        if(shoppingCartPlus==1){
            return false;
        }
        selectorCounter.val(Number(shoppingCartPlus)-1)
    })
    $(".addToShoppingCart").click(function () {
        var id=window.location.href.split("id=")[1];
        var name=$(".titleProduct").text()
        var count=$(".fieldCount").val()
        var sizeProduct=$("#sizeProduct").find(":selected").text()
        var colorProduct=$("#colorProduct").find(":selected").text()
        var priceProduct=$(".priceProductSpecial").text()
        shoppingCart(id,name,count,'imgae/',priceProduct,sizeProduct,colorProduct)
    })
})








function shoppingCart(Id,nameProduct,count,imageAddress,priceProduct,sizeClothes="xl",$color="white") {
    var shoppingItem;
    if (typeof ($.cookie('shoppingItem'))=='undefined'){
        shoppingItem=[];


        console.log(shoppingItem)
    }
    else{
        shoppingItem=JSON.parse($.cookie('shoppingItem'));
        console.log(shoppingItem)
    }
    var flag=false;
    var shopItemProduct={};
    for (var i = 0; i < shoppingItem.length; i++) {
        if (shoppingItem[i].IdPro == Id) {
            shoppingItem[i].count = Number(shoppingItem[i].count)+1;
            $.cookie('shoppingItem',JSON.stringify(shoppingItem),{expires:7})
            console.log(JSON.parse($.cookie('shoppingItem')))
            flag=true;
            break;
        }
    }
    if (flag==false){
        shopItemProduct.IdPro=Id
        shopItemProduct.nameProduct=nameProduct
        shopItemProduct.imageAddress=imageAddress
        shopItemProduct.count=count
        shopItemProduct.sizeClothes=sizeClothes
        shopItemProduct.color=$color
        shopItemProduct.priceProduct=priceProduct
        shoppingItem.push(shopItemProduct);
        $.cookie('shoppingItem',JSON.stringify(shoppingItem),{expires:7})
        console.log(JSON.parse($.cookie('shoppingItem')))
    }
    $(".shoppingCart .badgeLeft").text(JSON.parse($.cookie('shoppingItem')).length)
    $(".fieldInput").click(function () {
        var fieldName=$(this).children("input").attr("data-chenge-field")
        $(" .hiddenValue").val(fieldName)
        $(".changeField").addClass("d-none")
        $(".formField").removeClass("d-none")
    })
    $(".comeBack").click(function (){
        $(".changeField").removeClass("d-none")
        $(".formField").addClass("d-none")
    })
}