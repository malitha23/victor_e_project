<?php
session_start();
require_once("db.php");
if (isset($_SESSION["a"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $productGroup = $_POST["productGroup"];
        $category = $_POST["category"];
        $condition = $_POST["condition"];
        $status = $_POST["status"];
        $weight = $_POST["weight"];
        $description = $_POST["description"];
        $consignmentStock = $_POST["consignmentStock"];
        $product_subcategory = $_POST["product_subcategory"];
        $brand = $_POST["brand"];

        if (empty($title)) {
            echo "Please enter a title.";
        } elseif (strlen($title) > 100) {
            echo "Title must not exceed 100 characters.";
        } elseif ($productGroup == 0) {
            echo "Please select a product group.";
        } elseif ($category == 0) {
            echo "Please select a category.";
        } elseif ($condition == 0) {
            echo "Please select a condition.";
        } elseif ($status == 0) {
            echo "Please select a status.";
        } elseif (empty($weight)) {
            echo "Please enter the weight.";
        } elseif (!is_numeric($weight)) {
            echo "Weight must be a number.";
        } elseif (empty($description)) {
            echo "Please enter a description.";
        } elseif (strlen($description) > 1500) {
            echo "Description must not exceed 1500 characters.";
        } elseif ($product_subcategory == 0) {
            echo "Please select a category.";
        } elseif ($brand == 0) {
            echo "Please select a Brand.";
        } else {
            $cat =  Databases::Search("SELECT * FROM `category` WHERE `group_id`='" . $productGroup . "' AND `id`='" . $category . "' ");
            $cat_num = $cat->num_rows;
            if ($cat_num == 1) {
                $sub = Databases::Search("SELECT * FROM `sub_category` WHERE `category_id`='" . $category . "' AND `id`='" . $product_subcategory . "' ");
                $sub_n = $sub->num_rows;
                if ($sub_n == 1) {
                    #
                    $lastid = 0;
                    date_default_timezone_set('Asia/Colombo'); // Set timezone to Sri Jayawardenepura Kotte, Sri Lanka
                    $date = date('Y-m-d H:i:s');
                    $lastid = Databases::IUD("INSERT INTO `product` (`title`, `description`, `delete_id`, `condition_id`, `status_id`, `consignment_stock`, `weight`, `date`, `sub_category_id`, `brand_id`)
                     VALUES ('" . $title . "', '" . $description . "', '0', '" . $condition . "', '" . $status . "', '" . $consignmentStock . "', '" . $weight . "', '" . $date . "', '" . $product_subcategory . "', '" . $brand . "');");
                    if ($lastid > 0) {
                        #imae hadle
                        $targetDir = "product_image/";
                        $img1 = $img2 = $img3 = null;

                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }

                        function uploadImage($inputName, $targetDir)
                        {
                            if (!isset($_FILES[$inputName]) || $_FILES[$inputName]["error"] != 0) {
                                return null;
                            }
                            $fileName = time() . "_" . basename($_FILES[$inputName]["name"]);
                            $targetFilePath = $targetDir . $fileName;
                            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFilePath)) {
                                return $fileName;
                            }
                            return null;
                        }
                        $product_id = $lastid;
                        $img1 = uploadImage("img1", $targetDir);
                        $img2 = uploadImage("img2", $targetDir);
                        $img3 = uploadImage("img3", $targetDir);


                        if ($img1 === null && $img2 === null && $img3 === null) {
                            echo 1;
                        } else {
                            $images = array_filter([$img1, $img2, $img3]);
                            foreach ($images as $index => $img) {
                                $name = "Image " . ($index + 1);
                                Databases::IUD("INSERT INTO `picture` (`path`, `product_id`, `name`) 
    VALUES ('" . $img . "', '" . $product_id . "', '" . $name . "');");
                            }
                            echo 2;
                        }
                    }
                    #
                } elseif ($sub_n > 1) {
                    echo "Error";
                } else {
                    echo "The product category and subcategory do not match.";
                }
            } elseif ($cat_num > 1) {
                echo "Error";
            } else {
                echo "The product category and group do not match.";
            }
        }
        class imageup
        {
            function imageup($lastid)
            {
                // Image Upload Handling
            }
        }
    } else {
        echo "something else";
    }
} else {
}
