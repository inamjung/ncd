
<?php
$this->title = 'DM';


use kartik\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][]=$this->title;
$datas = $dataProvider->getModels();
?>

<div class="btn-group" role="group" aria-label="...">
           
            <a  class="btn btn-primary" href="<?= Url::to(['dm/dmpatientvisit', 'byear' => '2557']) ?>">2557</a>
            <a  class="btn btn-info" href="<?= Url::to(['dm/dmpatientvisit', 'byear' => '2558']) ?>">2558</a>
          
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
                    'dm/indivdmpatientvisit/',
                    'cup'=>$model['cup'],
                    'byear'=>$byear
                ]) ;
            }            
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'จำนวนผู้ป่วย(คน)',
            'attribute' => 'total',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],        
       [
            'class' => 'kartik\grid\DataColumn',
           'label'=>'รับบริการ(คน)',
            'attribute' => 'visit',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ], 
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'รับบริการ(ครั้ง)',
            'attribute' => 'visit_all',
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
                'type' => GridView::TYPE_SUCCESS,
                'heading' => 'DM รับบริการที่สถานบริการ ปีงบประมาณ '.$byear,
                'footer'=>'ประมวลผล ณ วันที่  : '.  date('Y-m-d',strtotime($datas[4]['sdate'])), 
                        ],
                    ]);
            ?>
<?php Pjax::end();?> 

<?php //echo Highcharts::widget([
//    'options'=>[        
//        'title'=>['text'=>'DM รับบริการที่สถานบริการ'],
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
//            [
//                'type'=>'column',
//                'name'=>'รับบริการ(คน)',
//                'data'=>$visit,
//            ],
//            [
//                'type'=>'column',
//                'color'=>'red',
//                'name'=>'รับบริการ(ครั้ง)',
//                'data'=>$visit_all,
//            ],
//           
//            
//        ]
//    ]
//]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




