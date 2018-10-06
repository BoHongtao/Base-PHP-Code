<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/7/11
 * Time: 23:00
 */
class Stack
{
    public $stack = array();
    //栈顶指针
    public $top = 0;

    public function __construct($maxsize)
    {
        $this->maxsize = $maxsize;
    }

    //入栈(num是入栈的元素)
    public function push($num)
    {
        //判断栈是否满了
        $max = $this->maxsize-1;
        if($this->top == $max){
            return false;
        }else{
            //入栈栈顶指针加1
            $this->stack[$this->top] = $num;
            echo '入栈下标'.$this->top.'入栈元素:'.$num.'<br>';
            ++$this->top;
        }
    }
    //出栈
    public function  pop()
    {
        //判断栈是否为空栈
        if($this->top==0){
            return false;
        }else{
            --$this->top;
            $num = $this->stack[$this->top];

            $this->stack[$this->top] =null;
            echo '出栈下标'.$this->top.'出栈元素'.$num.'<br>';
            //返回出栈元素
            return $num;
        }
    }
    //判断栈是否为空,空的话返回false,不空返回true
    public function is_empty()
    {
        if($this->top == 0){
            return false;
        }else{
            return true;
        }
    }
}

$stack = new Stack(20);
$stack->push(3);
$stack->push(5);
$stack->push(8);
$stack->pop();
$stack->pop();
$stack->pop();
var_dump($stack->is_empty());

echo'<br>';
echo '<hr>';

//应用阶段
$str1 = '(3+5)*5+(4*7+2';
for($i = 0 ; $i < strlen($str1);++$i){
    if($str1[$i] == '('){
        $stack->push('(');
        var_dump($stack->stack);
        echo "<br>";
    }
    echo "<br>";
    echo '当前遍历的元素是'.$str1[$i];
    echo "<br>";
    if($str1[$i] == ')'){
        $stack->pop('(');
        var_dump($stack->stack);
        echo "<br>";
    }
}

//栈不空->括号不匹配
if($stack->is_empty() == false){
    echo '括号匹配';
}else{
    echo '括号不匹配';
}