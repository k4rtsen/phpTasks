<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document_part2</title>
</head>

<body>
    <?php
    // 1st task ---------------------------------
    // flips a substring in a string at the second position
    function convertString(string $str, string $substr): string
    {
        // if exist the second position
        if (substr_count($str, $substr) < 2)
            return $str;
        // find second position
        $pos = strpos($str, $substr, strpos($str, $substr) + 1);
        // result
        return substr_replace($str, strrev($substr), $pos, strlen($substr));
    }
    $str = "coca-cola";
    $substr = "co";
    echo "<h3>1st task: </h3>";
    echo "<h4>Result of function convertString: </h4>";
    $str = convertString($str, $substr);
    echo $str;
    //-------------------------------------------

    // 2nd task ---------------------------------
    function mySortForKey(array &$a, $b = null)
    {
        // checks
        // you must set key $b
        if ($b == null) throw new Exception("you must set key for array");
        // and also specify the correct key
        foreach ($a as $key => $value)
            if (!array_key_exists($b, $value)) throw new Exception("An array haven't key $b");
        // algorithm sort
        for ($i = 0; $i < count($a); $i++)
            for ($j = 0; $j < count($a); $j++)
                if ($a[$i][$b] < $a[$j][$b]) {
                    $temp = $a[$i];
                    $a[$i] = $a[$j];
                    $a[$j] = $temp;
                }
        // return true;
    }

    $someArr = [[
        'a' => 1,
        'b' => 7
    ], [
        'a' => 6,
        'b' => 4
    ], [
        'a' => 3,
        'b' => 3
    ]];
    echo "<h3>2nd task: </h3>";
    echo "<h4>Result of function mySortForKey: </h4>";
    mySortForKey($someArr, 'b');
    print_r($someArr);
    //-------------------------------------------

    // Last task---------------------------------
    function importXml($path)
    {
        //connecting to XML file
        $xml = simplexml_load_file($path) or die("could not find file!");
        //connecting to BD
        $mysqli = mysqli_connect("localhost", "root", "", "test_samson");
        /*
        IMPORT TO BD
        */
        // fill the table a_category
        foreach ($xml as $product) {
            $sections = $product->sections->section;
            foreach ($sections as $value) {
                $query = "SELECT * FROM a_category";
                $categories = mysqli_query($mysqli, $query);
                $flag = true;
                // checking for identical lines
                foreach ($categories as $cat)
                    if ($cat['name'] == $value) $flag = false;
                if ($flag) {
                    $query = "INSERT INTO a_category (name) VALUES ('$value')";
                    $result = mysqli_query($mysqli, $query);
                    echo $value;
                } else continue;
            }
        }
        // fill the table a_product
        foreach ($xml as $product) {
            $query = "SELECT * FROM a_category";
            $categories = mysqli_query($mysqli, $query);
            $section = $product->sections->section;
            // checking for identical lines
            $query = "SELECT * FROM a_product";
            $products = mysqli_query($mysqli, $query);
            $flag = true;
            foreach ($products as $p)
                if ($p['code'] == $product['code'] && $p['name'] == $product['name'])
                    $flag = false;
            // definition of fields
            if ($flag) {
                foreach ($section as $sec)
                    foreach ($categories as $cat)
                        if ($sec == $cat['name'])
                            $id = $cat['ID'];
                $code = $product['code'];
                $name = $product['name'];
                $query = "INSERT INTO a_product (code, product_type, name) VALUES ('$code', '$id', '$name')";
                $result = mysqli_query($mysqli, $query);
            } else continue;
        }
        // fill the table a_price
        foreach ($xml as $product) {
            $price = $product->price;
            $query = "SELECT * FROM a_price";
            $a_price = mysqli_query($mysqli, $query);
            // checking for identical lines
            foreach ($price as $pr) {
                $flag = true;
                foreach ($a_price as $a_pr)
                    if (
                        $product['code'] == $a_pr['product_code'] &&
                        $pr['type'] == $a_pr['typePrice'] &&
                        $pr == $a_pr['price']
                    ) {
                        $flag = false;
                        break;
                    }
                if ($flag) {
                    $product_code = $product['code'];
                    $type_price = $pr['type'];
                    $query = "INSERT INTO a_price (product_code, typePrice, price) VALUES ('$product_code', '$type_price', '$pr')";
                    $result = mysqli_query($mysqli, $query);
                } else continue;
            }
        }
        // fill the table a_property
        foreach ($xml as $product) {
            $property = $product->property;
            foreach ($property as $value) {
                foreach ($value as $key => $val) {
                    $query = "SELECT * FROM a_property";
                    $a_property = mysqli_query($mysqli, $query);
                    $flag = true;
                    $product_code = $product['code'];
                    $name_property = $key;
                    $val_property = $val;
                    foreach ($a_property as $a_pr)
                        if (
                            $a_pr['product_code'] == $product_code && $a_pr['name_property'] == $name_property && $a_pr['val_property'] == $val_property
                        ) {
                            $flag = false;
                            break;
                        }
                    if ($flag) {
                        $query = "INSERT INTO a_property (product_code, name_property, val_property) VALUES ('$product_code', '$name_property', '$val_property')";
                        $result = mysqli_query($mysqli, $query);
                    }
                }
            }
        }
    }
    echo "<br>";
    importXml("2.xml");
    //-------------------------------------------
    ?>
</body>

</html>