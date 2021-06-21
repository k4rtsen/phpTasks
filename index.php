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
    // this func finds prime numbers between args $start and $end
    function FindSimple($start, $end)
    {
        if (!is_int($start) || !is_int($end)) {
            return false;
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
    echo "<h3>1 task: </h3>";
    echo "<h4>Result of function FindSimple: </h4>";
    print_r(FindSimple(1, 12));

    ?>
</body>

</html>