<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    // 1st TASK----------------------------------
    // this func finds prime numbers between args $start and $end
    function FindSimple($start, $end)
    {
        if (!is_int($start) || !is_int($end)) {
            return NULL;
        }

        $simple = array();

        for ($i = $start; $i <= $end; $i++) {
            $flag = true;
            for ($j = 2; $j <= $i / 2; $j++)
                if ($i % $j == 0)
                    $flag = false;
            if ($flag)
                $simple[] = $i;
        }
        return $simple;
    }
    echo "<h3>1st task: </h3>";
    echo "<h4>Result of function FindSimple: </h4>";
    print_r(FindSimple(1, 15));
    //-------------------------------------------

    // 2nd TASK----------------------------------
    function CreateTrapeze($a)
    {
        if ( !is_array($a) || (count($a) % 3 != 0))
            return NULL;

        $trapezeList = [];
        $j = 0;
        for ($i = 0; $i < count($a) / 3; $i++) {
            $trapezeList[] = array(
                'a' => $a[$j],
                'b' => $a[$j + 1],
                'c' => $a[$j + 2]
            );
            $j += 3;
        }
        return $trapezeList;
    }
    echo "<h3>2nd task: </h3>";
    echo "<h4>Result of function CreateTrapeze: </h4>";
    $someArr = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    print_r(CreateTrapeze($someArr));
    //-------------------------------------------

    // 3rd TASK----------------------------------
    function SquareTrapeze(&$a)
    {
        foreach ($a as $key => &$value)
            $value["S"] = (($value['a'] + $value['b']) / 2) * $value['c'];
    }
    
    $trapezes = CreateTrapeze($someArr);
    SquareTrapeze($trapezes);
    echo "<h3>3rd task: </h3>";
    echo "<h4>Result of function SquareTrapeze: </h4>";
    print_r($trapezes);
    //-------------------------------------------

    // 4th TASK----------------------------------
    function getSizeForLimit($a, $b)
    {
    }

    //-------------------------------------------

    // 5th TASK----------------------------------
    function getMin($a)
    {
    }

    //-------------------------------------------

    // 6th TASK----------------------------------
    function printTrapeze($a)
    {
    }

    //-------------------------------------------

    // 7th TASK----------------------------------

    //-------------------------------------------
    ?>
</body>

</html>