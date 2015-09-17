
<?php
$this->title = 'HT';


use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][]=$this->title;
?>

<div class="btn-group" role="group" aria-label="...">
           
            <a  class="btn btn-primary" href="<?= Url::to(['ht/htpatientvisit', 'byear' => '2557']) ?>">2557</a>
            <a  class="btn btn-info" href="<?= Url::to(['ht/htpatientvisit', 'byear' => '2558']) ?>">2558</a>
          
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
                    'ht/indivhtpatientvisit/',
                    'cup'=>$model['cup'],
                    'byear'=>$byear,
                ]) ;
            }            
        ],        
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'total',
            'label'=>'จำนวนผู้ป่วย(คน) ',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'visit',
            'label'=>'รับบริการ(คน)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
         [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'visit_all',
            'label'=>'รับบริการ(ครั้ง)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
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
                'heading' => 'HT รับบริการที่สถานบริการ ปีงบประมาณ '.$byear,

                        ],
                    ]);
            ?>
<?php Pjax::end();?> 

<?php //echo Highcharts::widget([
//    'options'=>[        
//        'title'=>['text'=>'HT รับบริการที่สถานบริการ'],
//        'xAxis'=>[
//            'categories'=>$cup
//        ],
//        'yAxis'=>[
//            'title'=>['text'=>'จำนวน(คน)']
//        ],
//        'series'=>[         
//            [
//                'type'=>'column',                
//                'name'=>'เป้าหมาย(คน)',
//                'data'=>$total,
//            ],
//           [
//                'type'=>'column',                
//                'name'=>'รับบริการ(คน)',
//                'data'=>$visit,
//            ],
//            [
//                'type'=>'column',                
//                'name'=>'รับบริการ(ครั้ง)',
//                'data'=>$visit_all,
//            ],
//        ]
//    ]
//]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




