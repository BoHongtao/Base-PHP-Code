<?php

namespace app\models;

use app\behavior\myBehavior;
use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $article_title
 * @property string $article_author
 * @property string $article_key
 * @property string $article_desc
 * @property string $article_content
 * @property integer $article_hit
 * @property string $article_tag
 * @property integer $is_publish
 * @property integer $is_recommend
 * @property string $main_pic
 */
class Article extends Base
{
    const MY_EVENT = 'my_event';
    public function behaviors()
    {
        return [
            // 匿名行为，只有行为类名
            myBehavior::className(),
            // 匿名行为，配置数组
            [
                'class' => myBehavior::className(),
                'prop' => 'value',
            ],
            // 命名行为，只有行为类名
            'myBehavior2' => myBehavior::className(),
            // 命名行为，配置数组
            'myBehavior3' => [
                'class' => myBehavior::className(),
                'prop' => 'value',
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'article_title', 'article_author', 'article_key', 'article_desc', 'article_content', 'article_hit', 'article_tag', 'is_publish', 'is_recommend'], 'required'],
            [['category_id', 'article_hit', 'is_publish', 'is_recommend'], 'integer'],
            [['article_content'], 'string'],
            [['article_title', 'article_key','main_pic'], 'string', 'max' => 64],
            [['article_author'], 'string', 'max' => 32],
            [['article_desc'], 'string', 'max' => 200],
            [['article_tag'], 'string', 'max' => 20],
            [['status','time'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '栏目ID',
            'article_title' => '标题',
            'article_author' => '作者',
            'article_key' => '关键字',
            'article_desc' => '文章简介',
            'article_content' => '文章内容',
            'article_hit' => '点击数',
            'article_tag' => '文档标签',
            'is_publish' => '是否发布',
            'is_recommend' => '是否推荐',
            'main_pic' => '文章主图',
            'file'=>'文章主图'
        ];
    }
    public function getCategory()
    {
        return $this->hasOne(Category::className(),['id'=>'category_id'])->select('category_name');
    }
}
