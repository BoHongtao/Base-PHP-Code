<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2018/2/26
 * Time: 16:57
 */

namespace app\controllers;
use app\behavior\myBehavior;
use app\components\Utils;
use app\events\LogEvent;
use app\models\Article;
use app\models\Category;
use app\models\Operlog;
use Yii;
use yii\web\UploadedFile;

class ArticleController extends BaseController{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionData($article_title='')
    {
        $category_id = Yii::$app->request->get('category_id','');
        $query = Article::find()->where(['status'=>1]);
        $category_id and $query->andWhere(['category_id'=>$category_id]);
        $article_title and $query->andWhere(['like','article_title',$article_title]);
        $pager = $this->Pager($query,'article/data');
        $articleInfo = $query->offset($pager->offset)->limit($pager->limit)->asArray()->all();
        foreach ($articleInfo as $k=>&$v){
            $v['category_name'] = Category::find()->select('category_name')->where(['id'=>$v['category_id']])->scalar();
        }
        return $this->renderPartial('_list',[
            'articleInfo'=>$articleInfo,
            'pager'=>$pager,
            'category_id'=>$category_id
        ]);
    }
    public function actionAdd($id = '')
    {
        $model = new Article();
        $category_name = Category::find()->where(['id'=>$id])->select('category_name')->scalar();
        if(Yii::$app->request->isAjax){
            $this->returnJson();
            if(!$model->load(Yii::$app->request->post()))
                return ['code'=>0,'msg'=>$this->getMsg($model)];
            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file){
                $filename = $model->upload();
                $model->main_pic = $filename;
            }
            if(!$model->save())
                return ['code'=>0,'msg'=>$this->getMsg($model)];
            return ['code'=>200];
        }
        $categoryInfo = Category::find()->where(['status'=>1])->select('id,category_name')->asArray()->all();
        $info = [];
        foreach ($categoryInfo as $k=>$v){
            $info[$v['id']] = $v['category_name'];
        }
        $id and $model->category_id = $id;
        return $this->render('add',[
            'category_name'=>$category_name,
            'model'=>$model,
            'categoryInfo'=>$info
        ]);
    }

    public function actionUpdate($id='')
    {
        $id and $model = Article::findOne(['id'=>$id]);
        if(Yii::$app->request->isAjax){
            $this->returnJson();
            if(!$model->load(Yii::$app->request->post()))
                return ['code'=>0,'msg'=>$this->getMsg($model)];
            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file){
                $filename = $model->upload();
                $model->main_pic = $filename;
            }
            if(!$model->save())
                return ['code'=>0,'msg'=>$this->getMsg($model)];
            return ['code'=>200];
        }
        $categoryInfo = Category::find()->where(['status'=>1])->select('id,category_name')->asArray()->all();
        $info = [];
        foreach ($categoryInfo as $k=>$v){
            $info[$v['id']] = $v['category_name'];
        }
        return $this->render('update',[
            'model'=>$model,
            'id'=>$id,
            'categoryInfo'=>$info,
        ]);
    }


    public function actionDel()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id', '');
            $this->returnJson();
            if ($id && Article::updateAll(['status' => 0], ['id' => $id])){
                $key = Article::find()->where(['id'=>$id])->select('article_title')->scalar();
                recycler($id,'app\models\Article','文章',$key);
                $event = new LogEvent();
                $event->article_id = $id;
                $this->trigger(self::EVENT_DEL_ARTICLE,$event);
                return ['code' => 200];
            }else{
                return ['code' => 0, 'msg' => '删除失败'];
            }
        }
    }
    public function actionDetail()
    {
        $this->layout = 'main_large_frame';
        $id = Yii::$app->request->get('id','');
        $id and $article_detail = Article::find()->select('article_content')->where(['id'=>$id])->scalar();
        return $this->render('detail',[
            'article_detail'=>$article_detail
        ]);
    }


    //提取文章关键词并返回
    public function actionGetkey()
    {
        $url = "http://api.bosonnlp.com/keywords/analysis?top_k=3";
        if(Yii::$app->request->isAjax){
            $this->returnJson();
            $content = Yii::$app->request->post('content','');
            if($content){
                $jsonarr = json_encode($content);
                $data = json_decode(Utils::httpPost(['Content-Type: application/json', 'Content-Length: ' . strlen($jsonarr),'X-Token:gpWVq61j.23867.OwRQ6xlzqOfv'], $url, $jsonarr));
                $key = '';
                foreach ($data as $k=>$v){
                    $key = $key.$v[1].',';
                }
                return [
                    'code'=>200,
                    'data'=>substr($key,0,strlen($key)-1)
                ];
            }
        }
       return '';
    }

    public function actionBind()
    {
        $article = new Article();
//        $article->attachBehavior('myBehavior',new myBehavior());

        $article->attachBehavior('myBehavior',new myBehavior());
        $article->attachBehavior('myBehavior2',myBehavior::className());
        $article->attachBehavior('myBehavior4', [
            'class' => MyBehavior::className(),
            'prop' => 'value',
        ]);
        $rs = $article->foo();
        var_dump($rs);
    }

    public function actionValidate($id = '')
    {
        $id and $model = Article::findOne(['id' => $id]) or $model = new Article();
        if ($model->load(Yii::$app->request->post())) {
            $this->returnJson();
            return \yii\bootstrap\ActiveForm::validate($model);
        }
    }
}