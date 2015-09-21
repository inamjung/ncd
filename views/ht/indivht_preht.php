<?php
//$this->title = 'HT รายใหม่จากกลุ่ม PreHT ปี 2558';
$this->params['breadcrumbs'][] = ['label' => 'HT รายใหม่จากกลุ่ม PreHT', 'url' => ['ht/htpreht']];

$this->params['breadcrumbs'][]=$this->title;
//use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use app\models\Tools;
use kartik\widgets\Select2;
use app\models\Registools;
use yii\data\ArrayDataProvider;
use app\models\Repairs;
use yii\helpers\Url;

?>
<div class="pull-left">
    <h4>
        <span style="background-color:#009999; color: white;padding: 5px">ปีงบประมาณ <?= $byear ?></span>
    </h4>
    <a class="btn  btn-info"
       href="<?= Url::to(['htpreht', 'cup' => $cup, 'byear' => $byear]) ?>">
        <i class="glyphicon glyphicon-chevron-left"> ย้อนกลับ</i>
    </a>
</div>
<?php 
function filter($col) {
    $filterresult = Yii::$app->request->getQueryParam('filterresult', '');
    if (strlen($filterresult) > 0) {
        if (strpos($col['result'], $filterresult) !== false) {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

$filteredData = array_filter($rawData, 'filter');
$searchModel = ['result' => Yii::$app->request->getQueryParam('$filterresult', '')];

$dataProvider = new ArrayDataProvider([

    'allModels' => $filteredData,
    'pagination' => false,
    'sort' => [
        'attributes' => count($rawData[0]) > 0 ? array_keys($rawData[0]) : array()
        ]]);


    
    $gridColumns = [
    ['class'=>'kartik\grid\SerialColumn'],        
            
        [
            'label'=>'เครือข่ายบริการ(CUP)',
            'attribute'=>'cup',
            'headerOptions' => ['class'=>'text-center'],            
        ],
         [
            'label'=>'สถานบริการ',
            'attribute'=>'hospname',
            'headerOptions' => ['class'=>'text-center'],            
        ],
        [
            'label'=>'จำนวน Pre HT(คน)',
            'attribute'=>'target',
            'headerOptions' => ['class'=>'text-center'],
            'contentOptions' => ['class'=>'text-center'],
        ],
        [
            'label'=>'จำนวนผู้ป่วย (คน)',
            'attribute'=>'result',
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
           //'showPageSummary' => true,
            'panel' => [           
                'type' => GridView::TYPE_SUCCESS,
                'heading' => 'HT รายใหม่จากกลุ่ม PreHTปี 2558',
                'footer'=>'ประมวลผล ณ วันที่  : '.  date('Y-m-d',strtotime($rawData[0]['sdate'])),
                        ],
                    ]);
            ?>

<?php
    // You only need add this,
    $this->registerJs('
        var gridview_id = ""; // specific gridview
        
        var columns = [2]; //that will grouping, start 1
 
        /*
        DON\'T EDIT HERE
 
http://www.hafidmukhlasin.com
 
        */
        var column_data = [];
            column_start = [];
            rowspan = [];
 
        for (var i = 0; i < columns.length; i++) {
            column = columns[i];
            column_data[column] = "";
            column_start[column] = null;
            rowspan[column] = 1;
        }
 
        var row = 1;
        $(gridview_id+" table > tbody  > tr").each(function() {
            var col = 1;
            $(this).find("td").each(function(){
                for (var i = 0; i < columns.length; i++) {
                    if(col==columns[i]){
                        if(column_data[columns[i]] == $(this).html()){
                            $(this).remove();
                            rowspan[columns[i]]++;
                            $(column_start[columns[i]]).attr("rowspan",rowspan[columns[i]]);
                        }
                        else{
                            column_data[columns[i]] = $(this).html();
                            rowspan[columns[i]] = 1;
                            column_start[columns[i]] = $(this);
                        }
                    }
                }
                col++;
            })
            row++;
        });
    ');
?>




