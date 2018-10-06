<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017/7/12
 * Time: 19:45
 *
 * 1：指定一个id值找到其后代的id值
 * 2：指定一个id值找到其父代的id值
 */
$arr = array
(
    array('id'=>2,'name'=>'分类2','parent_id'=>1),
    array('id'=>9,'name'=>'分类9','parent_id'=>8),
    array('id'=>1,'name'=>'分类1','parent_id'=>0),
    array('id'=>7,'name'=>'分类7','parent_id'=>0),
    array('id'=>3,'name'=>'分类3','parent_id'=>2),
    array('id'=>4,'name'=>'分类4','parent_id'=>0),
    array('id'=>6,'name'=>'分类6','parent_id'=>5),
    array('id'=>8,'name'=>'分类8','parent_id'=>7),
    array('id'=>5,'name'=>'分类5','parent_id'=>4)
);
//树状结构
function getTree($data,$parent_id=0,$level=0,$isClear=false)
{
    static $res = array();
    if($isClear === true){
        $res = array();
    }
    foreach ($data as $k=>$v)
    {
        if($v['parent_id'] == $parent_id){
            $res[] = $v;
            $v['level'] = $level;
            getTree($data,$v['id'],$level+1,false);
        }
    }
    return $res;
}

echo '<pre>';
var_dump(getTree($arr,0,0,true));

//指定一个id值找到其后代的id值
function getChildren($data,$id,$isClear=false)
{
    static $res = array();
    if($isClear === true){
        $res = array();
    }
    foreach ($data as $k=>$v){
        if($v['parent_id'] == $id){
            $res[] = $v['id'];
            getChildren($data,$v['id'],false);
        }
    }
    return $res;
}
echo '<pre>';
var_dump(getChildren($arr,2,true));

//指定一个id值找到其父代的id值
function getParent($data,$id,$isClear=false)
{
    static $res = array();
    if($isClear === true){
        $res = array();
    }
    foreach ($data as $k => $v) {
        if($v['id'] == $id){
            $res[] = $v['parent_id'];
            getParent($data,$v['parent_id'],false);
        }
    }
    return $res;
}
echo '<pre>';
var_dump(getParent($arr,9,true));




function getFarther($data,$id,$is_Clear=FALSE)
{
    static $ret = array();
    if($is_Clear == TRUE)
        $ret = array();
    foreach($data as $k=>$v)
    {
        if($v['id'] == $id)
        {
            $ret[] = $v;
            getFarther($data,$v['parent_id']);
        }
    }
    unset($ret[0]);
    return $ret;
}