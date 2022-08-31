<?php require_once "includes/required.php";
class manageProducts extends data{
    public $data=[
        'id'=>0,
        'id_company'=>0,
        'idCategory'=>0,
        'nameProduct'=>'',
        'image_address'=>'',
        'purchase'=>0,
        'colors'=>'',
        'sizes'=>'',
        'price'=>0,
        'discount'=>'',
        'updated_at'=>'',
        'created_at'=>'',
        'nameCompany'=>''
    ];
    public static function getProuctByPurchase($limit=false){
        $connection=connection::connect();
        if ($limit){
            $query="SELECT products.*,companies.nameCompany FROM products,companies WHERE companies.id=products.id_company ORDER BY `purchase` DESC LIMIT $limit";
        }
        else{
            $query="SELECT products.*,companies.nameCompany FROM products,companies WHERE companies.id=products.id_company ORDER BY `purchase` DESC ";
        }
        $result=$connection->query($query);
        if ($result->num_rows){
            $cats=[];
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $product) {
                $cats[]=new manageProducts($product);
            }
            $ret=$cats;
        }
        else{
            $ret=false;
        }
        connection::disconnect($connection);
        return $ret;
    }
    public static function discountProduct($limit){
        $conn=connection::connect();
        $query="SELECT * FROM `products` ORDER BY `discount` DESC LIMIT $limit";
        $result=$conn->query($query);
        if ($result->num_rows){
            $res=array();
            foreach ($result->fetch_all(MYSQLI_ASSOC) as $product){
                $res[] = new manageProducts($product);
            }
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function convertDiscount($realPrice,$discount){
        $realPrice=substr($realPrice,0,strlen((int) $realPrice)-2);
        $formula=$realPrice*(100-(int) $discount);
        return $formula;
    }
    public static function allProduct($sql){
        $conn=connection::connect();

        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else{
            $res=false;
        }
        connection::disconnect($conn);
        return $res;
    }
    public static function selectCompany(){
        $conn=connection::connect();
        $sql="SELECT * FROM `companies`";
        $result=$conn->query($sql);
        if($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
    public static function selectCategory(){
        $conn=connection::connect();
        $sql="SELECT * FROM `category`";
        $result=$conn->query($sql);
        if ($result->num_rows){
            $res=$result->fetch_all(MYSQLI_ASSOC);
        }
        else
            $res=false;
        connection::disconnect($conn);
        return $res;
    }
}
