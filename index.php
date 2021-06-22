<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table,
        td,
        th {
            padding: 5px;
            margin: 5px;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
    </style>

</head>

<body>
    <?php
    // 1st TASK----------------------------------
    // this func finds prime numbers between args $start and $end
    function FindSimple($start, $end)
    {
        // check args
        if (!is_int($start) || !is_int($end)) {
            return null;
        }
        // create void array for simple nums
        $simple = array();
        // one of the slowest algorithms
        // O(N * N/2)
        for ($i = $start; $i <= $end; $i++) {
            $flag = true;
            for ($j = 2; $j <= $i / 2; $j++)
                if ($i % $j == 0) {
                    $flag = false;
                    // next num, because this one is no longer simple
                    break;
                }
            if ($flag)
                // if we can't divide by any number, then this one is prime
                $simple[] = $i;
        }
        return $simple;
    }
    echo "<h3>1st task: </h3>";
    echo "<h4>Result of function FindSimple: </h4>";
    print_r(FindSimple(1, 20));
    //-------------------------------------------

    // 2nd TASK----------------------------------
    function CreateTrapeze($a)
    {
        // the argument must be an array and must be a multiple of 3
        if (!is_array($a) || (count($a) % 3 != 0))
            return null;

        $trapezeList = [];
        $j = 0;
        for ($i = 0; $i < count($a) / 3; $i++) {
            // from every third element we create an array
            $trapezeList[] = array(
                'a' => $a[$j],
                'b' => $a[$j + 1],
                'c' => $a[$j + 2]
            );
            // go to the next triple of elements
            $j += 3;
        }
        return $trapezeList;
    }
    echo "<h3>2nd task: </h3>";
    echo "<h4>Result of function CreateTrapeze: </h4>";
    $someArr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]; // from this array we make trapezes
    print_r(CreateTrapeze($someArr));
    //-------------------------------------------

    // 3rd TASK----------------------------------
    function SquareTrapeze(&$a)
    {
        foreach ($a as $key => &$value)
            // add area for the each trapeze
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
        $result = array();
        foreach ($a as $key => $value)
            if ($value['S'] <= $b)
                // if square of trapeze is smaller than $b, we add to the result
                $result[] = $value['S'];
        return $result;
    }
    echo "<h3>4th task: </h3>";
    echo "<h4>Result of function getSizeForLimit: </h4>";
    print_r(getSizeForLimit($trapezes, 60));
    //-------------------------------------------

    // 5th TASK----------------------------------
    function getMin($a)
    {
        if (!is_array($a))
            return null;

        $min = current($a);
        foreach ($a as $key => $value) {
            if (is_int($value) || is_float($value)) {
                if ($min > $value)
                    $min = $value;
            } else return null;
        }
        return $min;
    }
    echo "<h3>5th task: </h3>";
    echo "<h4>Result of function getMin: </h4>";
    echo "min = ", getMin([72, -31, 42.11, 53, 54.23, -66.1111e10, 34, -19, -66.1112e11]);
    //-------------------------------------------

    // 6th TASK----------------------------------
    function printTrapeze($a)
    {
        echo "<table>";
        // make header for table
        echo "<tr>
                 <th>a</th>
                 <th>b</th>
                 <th>h</th>
                 <th>S</th>
             </tr>";
        // create table
        foreach ($a as $key => $value) {
            if ($key % 2 == 0) {
                echo "<tr bgcolor='#c0c0c0'>";
                    foreach ($value as $val) {
                        echo "<td>$val</td>";
                    }
                echo "</tr>";
            }
            else {
                echo "<tr>";
                    foreach ($value as $val) {
                        echo "<td>$val</td>";
                    }
                echo "</tr>";
            }
        }
        echo "</table>";
    }
    echo "<h3>6th task: </h3>";
    echo "<h4>Result of function printTrapeze: </h4>";
    printTrapeze($trapezes);
    //-------------------------------------------

    // 7th TASK----------------------------------

    //-------------------------------------------
    ?>
</body>

</html>