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
    function convertString(string $str, string $substr) : string
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
    function mySortForKey(array &$a, $b = null) {
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
        ],[ 'a' => 6,
            'b' => 4
        ],[ 'a' => 3,
            'b' => 3
        ]];
    echo "<h3>2nd task: </h3>";
    echo "<h4>Result of function mySortForKey: </h4>";
    mySortForKey($someArr, 'b');
    print_r($someArr);
    //-------------------------------------------
    ?>
</body>

</html>