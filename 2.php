<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document_part2</title>
</head>

<body>
    <p><a href="3.php">The third part of the work</a></p>
    
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
    // PART 1
    function importXml($path)
    {
        //connecting to XML file
        $xml = simplexml_load_file($path) or die("could not find file!");
        //connecting to BD
        $mysqli = mysqli_connect("localhost", "root", "", "test_samson");

        //IMPORT TO BD

        /* fill the table a_category as
                                        ID | name | parentID
                                        PK | ---- |    FK
        */
        foreach ($xml as $product) {
            $sections = $product->sections->section;
            if (count($sections) > 1) {
                // insert without parent
                $query = "INSERT INTO a_category (name) VALUES ('$sections[0]')"; // the first line is the main parent
                mysqli_query($mysqli, $query);
                // and the following categories have a parent
                for ($val = 1; $val < count($sections); $val++) {
                    $pre = $val - 1;
                    $query = "SELECT ID FROM a_category WHERE name = '$sections[$pre]'";
                    $parent = mysqli_fetch_row(mysqli_query($mysqli, $query)); // get as array of parent ID
                    $parentID = $parent[0]; // we have to pull the ID from the array as data
                    // insert with parent
                    $query = "INSERT INTO a_category (name, parentID) VALUES ('$sections[$val]', '$parentID')";
                    mysqli_query($mysqli, $query);
                }
            } else {
                // insert without parent
                // if there is only one entry, then it has no parent
                $query = "INSERT INTO a_category (name) VALUES ('$sections[0]')";
                mysqli_query($mysqli, $query);
            }
        }

        /* fill the table a_product as
                                        ID | code | id_category | name
                                        PK | unic |     FK      | ----
        */
        foreach ($xml as $product) {
            $code = $product['code'];
            $name = $product['name'];
            $section = $product->sections->section;
            $last = end($section); // get smallest child category
            $query = "SELECT ID FROM a_category WHERE name = '$last'";
            $category = mysqli_fetch_row(mysqli_query($mysqli, $query));
            $id_category = $category[0];
            $query = "INSERT INTO a_product (code, id_category, name) VALUES ('$code','$id_category','$name')";
            mysqli_query($mysqli, $query);
        }

        /* fill the table a_price as
                                    ID | product_code | type_price | price
                                    PK |     FK       |     -      |   -
        */
        foreach ($xml as $product) {
            $code = $product['code'];
            $price = $product->price;
            foreach ($price as $money) {
                $type_price = $money['type'];
                // exclude duplicate lines
                $query = "SELECT * FROM a_price WHERE product_code = $code AND type_price = '$type_price' AND price = $money";
                $result = mysqli_fetch_row(mysqli_query($mysqli, $query));
                if (!$result) {
                    $query = "INSERT INTO a_price (product_code, type_price, price) VALUES ('$code','$type_price','$money')";
                    mysqli_query($mysqli, $query);
                }
            }
        }

        /* fill the table a_property as 
                                        ID | product_code | name_property | val_property
                                        PK |     FK       |       -       |      -
        */
        foreach ($xml as $product) {
            $code = $product['code'];
            $property = $product->property;
            foreach ($property as $value)
                foreach ($value as $key => $val) {
                    // exclude duplicate lines
                    $query = "SELECT * FROM a_property WHERE product_code = $code AND name_property = '$key' AND val_property = '$val'";
                    $result = mysqli_fetch_row(mysqli_query($mysqli, $query));
                    if (!$result) {
                        $query = "INSERT INTO a_property (product_code, name_property, val_property) VALUES ('$code','$key','$val')";
                        mysqli_query($mysqli, $query);
                    }
                }
        }
        // close connection
        mysqli_close($mysqli);
    }
    echo "<br>";
    importXml("2.xml");

    // PART 2
    function getTree($arr, $top)
    {
        static $result = array();
        foreach ($arr as $key => $value)
            if ($value[0] == $top)
                $result[] = $value[0];
            else if ($value[2] == $top)
                getTree($arr, $value[0]);
        if (!empty($result))
            return $result;
        else return false;
    }

    function exportXml($path, $main_catalog)
    {
        // connecting to BD
        $mysqli = mysqli_connect("localhost", "root", "", "test_samson");
        // get path to XML file
        $xml_file = simplexml_load_file($path) or die("could not find file!");
        // ---
        $query = "SELECT * FROM a_category";
        $result = $mysqli->query($query);
        $categoryes = $result->fetch_all();
        $tree = getTree($categoryes, $main_catalog); // get all catalogs and sub catalogs
        echo "<br>";
        if ($tree)
            print_r($tree);
        else
            echo "Don't find any catalogs with id = $main_catalog!";
        // ---
        /*
            EXPORT FROM BD
        */
        foreach ($tree as $value) {
            $query = "SELECT code, name FROM a_product WHERE id_category = '$value'";
            $products = $mysqli->query($query)->fetch_all();
            foreach ($products as $product) {
                $product_code = $product[0];
                $product_name = $product[1];
                // add the product
                $xml_product = $xml_file->addChild('product');
                $xml_product->addAttribute("code", "$product_code");
                $xml_product->addAttribute("name", "$product_name");
                // get the price of this $product
                $query = "SELECT type_price, price FROM a_price WHERE product_code = '$product_code'";
                $prices = $mysqli->query($query)->fetch_all();
                foreach ($prices as $price) {
                    $price_type = $price[0];
                    $price_val = $price[1];
                    // add a prices tag, attr and value
                    $xml_price = $xml_product->addChild('price', $price_val);
                    $xml_price->addAttribute('type', $price_type);
                }
                // get the property of this $product
                $query = "SELECT name_property, val_property FROM a_property WHERE product_code = '$product_code'";
                $propertyes = $mysqli->query($query)->fetch_all();
                // create tag property
                $xml_property = $xml_product->addChild('property');
                foreach ($propertyes as $property) {
                    $property_name = $property[0];
                    $property_val = $property[1];
                    // add a propertyes tag and value
                    $xml_property->addChild($property_name, $property_val);
                }
                // get and add sections
                $xml_sections = $xml_product->addChild('sections');
                foreach ($tree as $val) {
                    $query = "SELECT name FROM a_category WHERE ID = '$val'";
                    $section = $mysqli->query($query)->fetch_row();
                    $section_name = $section[0];
                    $xml_sections->addChild('section', $section_name);
                }
            }
        }

        echo "<br>";
        var_dump($xml_file);
        // save in the file
        $xml_file->asXML($path);
        // close connection
        mysqli_close($mysqli);
    }
    exportXml("test.xml", 3);
    //-------------------------------------------
    ?>
</body>

</html>