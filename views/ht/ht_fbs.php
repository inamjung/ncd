
<?php
$this->title = 'HT';


use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$datas = $dataProvider->getModels();
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="btn-group" role="group" aria-label="...">
           
            <a  class="btn btn-primary" href="<?= Url::to(['ht/htfbs', 'byear' => '2557']) ?>">2557</a>
            <a  class="btn btn-info" href="<?= Url::to(['ht/htfbs', 'byear' => '2558']) ?>">2558</a>
          
</div>
<?php Pjax::begin();?> 
<?php
$gridColumns = [
    ['class'=>'kartik\grid\SerialColumn'],
        
       [
            'label'=>'เครือข่ายบริการ(CUP)',
            'attribute'=>'cup',
            'format'=>'raw',
            'value'=> function($model)use($byear){
                return Html::a(Html::encode($model['cup']),[
                    'ht/indivhtfbs/',
                    'cup'=>$model['cup'],
                    'byear'=>$byear,
                ]) ;
            }            
        ],         
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'target',
            'label'=>'เป้าหมาย(คน)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'ผลงาน (คน)',
            'attribute' => 'result',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
         [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'r1',
            'label'=>'น้ำตาล<100(คน)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'น้ำตาล 100-125 (คน)',
            'attribute' => 'r2',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
         [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'น้ำตาล >125 (คน)',
            'attribute' => 'r3',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],       
        [
            'label'=>'ร้อยละ ',
            'attribute'=>'total',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
       ];           
            echo GridView::widget([
            'dataProvider' => $dataProvider,
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
            'columns' => $gridColumns,
            'responsive' => true,
            'hover' => true,
            'floatHeader' => FALSE,        
            'showPageSummary' => true,
            'panel' => [           
                'type' => GridView::TYPE_PRIMARY,
                'heading' => 'HT ได้รับการตรวจน้ำตาล ปีงบประมาณ '.$byear,
                'footer'=>'ประมวลผล ณ วันที่  : '.  date('Y-m-d',strtotime($datas[4]['sdate'])), 
                        ],
                    ]);
            ?>
<?php Pjax::end();?> 

<?php echo Highcharts::widget([
    'options'=>[        
        'title'=>['text'=>'HT ได้รับการตรวจน้ำตาล'],
        'xAxis'=>[
            'categories'=>$cup
        ],
        'yAxis'=>[
            'title'=>['text'=>'จำนวน(คน)']
        ],
        'series'=>[
            [
                'type'=>'column',
                'name'=>'เป้าหมาย',
                'data'=>$target,
            ],
            [
                'type'=>'column',
                'name'=>'ผลงาน',
                'data'=>$result,
            ],
            [
                'type'=>'column',                
                'name'=>'ร้อยละ',
                'data'=>$total,
            ],
           
            
        ]
    ]
]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




