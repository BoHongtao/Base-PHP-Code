<?php
/**
 * Created by PhpStorm.
 * User: BoHongtao
 * Date: 2018/10/26
 * Time: 14:53
 */

class Person{
    private $friend;
    public $name;
    public $gender;

    public function say(){
        echo $this->name."is ".$this->gender;
    }

    public function __construct($nama,$gender){
        $this->nama = $nama;
        $this->gender = $gender;
    }

    public function get($name){
        if(isset($this->name))
            return $this->name;
        echo "未设置";
    }
}
$person_1 = new Person('Ming','boy');

// 反射获取类的原型
$obj = new ReflectionClass('person');

$className = $obj->getName();

$Methods = $Properties = array();

foreach($obj->getProperties() as $v)
{
    $Properties[$v->getName()] = $v;
}

foreach($obj->getMethods() as $v)
{
     $Methods[$v->getName()] = $v;
}
echo "class {$className}\n{\n";

is_array($Properties)&&ksort($Properties);

foreach($Properties as $k => $v)
{
    echo "\t";
    echo $v->isPublic() ? ' public' : '',$v->isPrivate() ? ' private' : '',
    $v->isProtected() ? ' protected' : '',
    $v->isStatic() ? ' static' : '';
    echo "\t{$k}\n";
}
echo "\n";
if(is_array($Methods)) ksort($Methods);
foreach($Methods as $k => $v)
{
    echo "\tfunction {$k}(){}\n";
}
echo "}\n";