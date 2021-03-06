<?php

namespace Test3;

use Exception;

class newBase
{
    static private $count = 0;
    static private $arSetName = array();
    private $name;
    protected $value;

    /**
     * @param string $name
     */
    function __construct(int $name = 0)
    {
        if (empty($name)) {
            // если передан пустой аргумент
            while (array_search(self::$count, self::$arSetName) !== false) { // строгая проверка при возврате первого элемента массива
                // проверка наличия статичного self::$count в статичном массиве self::$arSetName
                // если такой count существует в массиве, то увеличиваем его на единицу
                ++self::$count;
            }
            // как только count не будет содержаться в массиве, присваиваем его к аргументу $name
            $name = self::$count;
        }
        // присваиваем переданный аргумент в $this->name и добавляем в массив
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name . '*';
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }

    public function __sleep()
    {
        // return ['value'];
        return array('value');
    }

    /**
     * @return string
     */
    public function getSave(): string
    {
        $value = serialize($this->value); // возвращает string
        // sizeof необходим array
        // return $this->name . ':' . sizeof($value) . ':' . $value;
        return $this->name . ':' . sizeof((array)$value) . ':' . $value; // sizeof('string') = 1
    }

    /**
     * @param string $value
     * @return newBase
     */
    static public function load(string $value): newBase
    {
        $arValue = explode(':', $value);
        // setValue возвращает void (пустоту), поэтому сначала нужно создать объект и установить value, потом уже вернуть объект
        $result = new newBase($arValue[0]);
        $result->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
            + strlen($arValue[1]) + 1), $arValue));
        return $result;
//        return (new newBase($arValue[0]))
//            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
//                + strlen($arValue[1]) + 1), $arValue[1]));
    }
}

class newView extends newBase
{
    private $type = null;
    private $size = 0;
    //private $property = null;
    protected $property = null;

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
    }

    public function setProperty($value): newView
    {
        $this->property = $value;
        return $this;
    }

    private function setType()
    {
        $this->type = gettype($this->value);
    }

    private function setSize()
    {
        if (is_subclass_of($this->value, newView::class)) {
            // $this->size = parent::getSize() + 1 + strlen($this->property);
            $this->size = (int)parent::getSize() + 1 + strlen($this->property);
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = strlen($this->value);
        }
    }

    /**
     * @return string[]
     */
    public function __sleep()
    {
        // property is privat
        return ['property'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getName(): string
    {
        // name is private
        //if (empty($this->name)) {
        if (empty(parent::getName())) {
            throw new Exception("The object doesn't have name");
        }
        //return '"' . $this->name  . '": ';
        return '"' . parent::getName() . '": ';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type . ';';
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }

    public function getInfo()
    {
        try {
            echo $this->getName()
                . $this->getType()
                . $this->getSize()
                . "\r\n";
        } catch (Exception $exc) {
            echo 'Error: ' . $exc->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getSave(): string
    {
        if ($this->type == 'test') {
            //$this->value = $this->value->getSave();
            $this->value = parent::getSave();
        }
        return parent::getSave() . serialize($this->property);
    }

    /**
     * @param string $value
     * @return newView
     */
    static public function load1(string $value): newView//newBase
    {
        $arValue = explode(':', $value);
        $result = new newView($arValue[0]);
        $result->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
            + strlen($arValue[1]) + 1), $arValue));
        $result->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
            + strlen($arValue[1]) + 1 + $arValue)));
        return $result;
//        return (new newBase($arValue[0]))
//            ->setValue(unserialize(substr($value, strlen($arValue[0]) + 1
//                + strlen($arValue[1]) + 1), $arValue[1]))
//            ->setProperty(unserialize(substr($value, strlen($arValue[0]) + 1
//                + strlen($arValue[1]) + 1 + $arValue[1])))ж
    }
}


function gettype($value): string
//function typeget($value): string
{
    if (is_object($value)) {
        $type = get_class($value);
        do {
            //if (strpos($type, "Test3\newBase") !== false) {
            if (strpos($type, "Test3\\newBase") !== false) {
                return 'test';
            }
        } while ($type = get_parent_class($type));
    }
    return gettype($value);
}


$obj = new newBase('12345');
$obj->setValue('text');

// $obj2 = new \Test3\newView('O9876');
$obj2 = new newView('09876');
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();

$save = $obj2->getSave();

$obj3 = newView::load($save);

var_dump($obj2->getSave() == $obj3->getSave());
