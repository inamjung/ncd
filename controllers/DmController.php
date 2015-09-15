<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\User;

class DmController extends Controller {

    public $enableCsrfValidation = false;

    public function actionDmscreen() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,FORMAT(SUM(risk),0) as risk,FORMAT(SUM(riskhigh),0) as riskhigh
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM dm_screen
            GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_screen', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmscreen($cup = null) {

        $sql = "SELECT distcode,hospname, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,FORMAT(SUM(risk),0) as risk,FORMAT(SUM(riskhigh),0) as riskhigh
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM dm_screen
            WHERE cup='$cup'
            GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_screen', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }

    public function actionDmhba1c() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM dm_hba1c
                GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_hba1c', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmhba1c($cup = null) {

        $sql = "SELECT distcode,hospname, cup ,SUM(target)as target , SUM(result)as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM dm_hba1c
                WHERE cup='$cup'
                GROUP BY hospcode";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_hba1c', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }
public function actionDmlipid() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            ,FORMAT(SUM(hdl),0) as hdl,FORMAT(SUM(hdl_r),0) as hdl_r
            ,FORMAT(SUM(ldl),0) as ldl,FORMAT(SUM(ldl_r),0) as ldl_r
            ,FORMAT(SUM(chol),0) as chol,FORMAT(SUM(chol_r),0) as chol_r
            ,FORMAT(SUM(tg),0) as tg,FORMAT(SUM(tg_r),0) as tg_r
            FROM dm_lipid GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_lipid', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmlipid($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                ,FORMAT(SUM(hdl),0) as hdl,FORMAT(SUM(hdl_r),0) as hdl_r
                ,FORMAT(SUM(ldl),0) as ldl,FORMAT(SUM(ldl_r),0) as ldl_r
                ,FORMAT(SUM(chol),0) as chol,FORMAT(SUM(chol_r),0) as chol_r
                ,FORMAT(SUM(tg),0) as tg,FORMAT(SUM(tg_r),0) as tg_r                
                FROM dm_lipid WHERE cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_lipid', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }
    
    public function actionDmmicroal() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM dm_microalbumin
            GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_microal', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmmicroal($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM dm_microalbumin WHERE cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_microal', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }
    
    public function actionDmeye() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM dm_eye
            GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_eye', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmeye($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM dm_eye
                WHERE cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_eye', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }
    
    public function actionDmfoot() {

        $connection = Yii::$app->db;
        $data = $connection->createCommand('
             SELECT distcode, cup ,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total
            FROM dm_foot
            GROUP BY cup
                        ')->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_foot', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
        ]);
    }

    public function actionIndivdmfoot($cup = null) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total
                FROM dm_foot
                WHERE cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_foot', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
        ]);
    }

}
