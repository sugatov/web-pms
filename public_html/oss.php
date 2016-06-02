<?php
use Opensoft\SimpleSerializer\Metadata\Annotations as Serializer;
class E
{
    private static $idCnt = 0;

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("integer")
     */
    protected $id;

    public function __construct()
    {
        self::$idCnt += 1;
        $this->id = self::$idCnt;
        write('construct: ' . get_class($this));
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($val)
    {
        $this->id = $val;
    }
}

class E1 extends E
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $name;
    public function getName()
    {
        return $this->name;
    }
    public function setName($val)
    {
        $this->name = $val;
    }

    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("E2")
     * @Serializer\Replace
     */
    protected $e2;
    public function getE2()
    {
        write('getE2');
        var_dump($this->e2);
        return $this->e2;
    }
    public function setE2($val)
    {
        write('setE2');
        var_dump($val);
        $this->e2 = $val;
    }

}

class E2 extends E
{
    /**
     * @Serializer\Expose(true)
     * @Serializer\Type("string")
     */
    protected $description;
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($val)
    {
        $this->description = $val;
    }
}


function write($text) {
    echo $text . PHP_EOL;
}

$SL = require __DIR__ . '/../source/lib/bootstrap.php';

$e1 = new E1();
$e2 = new E2();
$e2->setDescription('e2 descr');
$e1->setName('e1 name');
$e1->setE2($e2);


/*$json = $SL['serializer']->serialize($e1);
write($json);*/

$json = '{"id":1,"name":"e1 name","e2":{"id":2,"description":"e2 descr"}}';

// $e1 = new E1();
$SL['serializer']->unserialize($json, $e1);
print_r($e1);
