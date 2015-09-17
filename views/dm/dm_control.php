
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
?>
<div class="alert alert-info" role="alert">     
<h3><span class="label label-info">ระบบสารสนเทศผู้ป่วยโรคเบาหวาน ปี <?php echo $byear; ?></span></h3>

</div>
<div class="btn-group" role="group" aria-label="...">
           
            <a  class="btn btn-primary" href="<?= Url::to(['dm/dmcontrol', 'byear' => '2557']) ?>">2557</a>
            <a  class="btn btn-info" href="<?= Url::to(['dm/dmcontrol', 'byear' => '2558']) ?>">2558</a>
          
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
                    'dm/indivdmcontrol/',
                    'cup'=>$model['cup'],
                    'byear'=>$byear,
                ]) ;
            }            
        ],         
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'target',
            'label'=>'จำนวนตรวจน้ำตาล(คน)',
            'format'=>'integer',
            'pageSummary' => true,
            'vAlign' => 'middle',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'label'=>'ควบคุมได้ (<=7)(คน)',
            'attribute' => 'result',
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
                'type' => GridView::TYPE_SUCCESS,
                'heading' => 'DM ที่ควบคุมได้2ครั้งสุดท้าย',

                        ],
                    ]);
            ?>
<?php Pjax::end();?> 

<?php //echo Highcharts::widget([
//    'options'=>[        
//        'title'=>['text'=>'DM ที่ควบคุมได้2ครั้งสุดท้าย'],
//        'xAxis'=>[
//            'categories'=>$cup
//        ],
//        'yAxis'=>[
//            'title'=>['text'=>'จำนวน(คน)']
//        ],
//        'series'=>[
//            [
//                'type'=>'column',
//                'name'=>'เป้าหมาย',
//                'data'=>$target,
//                
//            ],
//            [
//                'type'=>'column',
//                'name'=>'ผลงาน',
//                'data'=>$result,
//                 
//            ],
//            [
//                'type'=>'column',
//                'color'=>'red',
//                'name'=>'ร้อยละ',
//                
//            ],
//           
//            
//        ]
//    ]
//]);?>


<div class="footerrow" style="padding-top: 60px">
   
</div>




