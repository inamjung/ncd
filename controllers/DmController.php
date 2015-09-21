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

    public function actionDmscreen($byear=2558) { 
    
        $connection = Yii::$app->db;
        $data = $connection->createCommand("
            SELECT distcode, cup ,SUM(target)as target , SUM(result)as result
            ,SUM(normal)as normal
            ,SUM(risk)as risk,SUM(riskhigh) as riskhigh
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_screen 
            where byear= '$byear'
            GROUP BY cup")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $total[] = $data[$i]['total'] * 1;
            $normal[] = $data[$i]['normal'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_screen', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 
                    'total' => $total,'byear' => $byear,'normal'=>$normal
        ]);
    }    

    public function actionIndivdmscreen($cup = null,$byear=null) {

        $sql = "SELECT distcode,hospname, cup ,FORMAT(SUM(target),0)as target 
            ,Format(SUM(result),0) as result
            ,SUM(normal)as normal
            ,FORMAT(SUM(risk),0) as risk,FORMAT(SUM(riskhigh),0) as riskhigh
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_screen
            WHERE byear='$byear' and cup='$cup'
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
                    'byear'=>$byear,
                    'cup' => $cup,
        ]);
    }

    public function actionDmhba1c($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result)as result
                ,SUM(result_7)as result_7
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_hba1c
                where byear= '$byear'
                GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];
            $target[] = $data[$i]['target'] * 1;
            $result[] = $data[$i]['result'] * 1;
            $result_7[] = $data[$i]['result_7'] * 1;
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_hba1c', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total
                ,'byear' => $byear,'result_7'=>$result_7
        ]);
    }

    public function actionIndivdmhba1c($cup = null,$byear=nul) {

        $sql = "SELECT distcode,hospname, cup ,SUM(target)as target , SUM(result)as result
                ,SUM(result_7) as result_7
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_hba1c
                WHERE byear='$byear' and cup='$cup'
                GROUP BY cup";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_hba1c', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'byear'=>$byear,
                    'cup' => $cup,
                    
        ]);
    }
public function actionDmlipid($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            ,SUM(hdl) as hdl,SUM(hdl_r) as hdl_r
            ,SUM(ldl) as ldl,SUM(ldl_r) as ldl_r
            ,SUM(chol) as chol,SUM(chol_r) as chol_r
            ,SUM(tg) as tg,SUM(tg_r) as tg_r
            FROM dm_lipid where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 
            'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmlipid($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target , Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                ,FORMAT(SUM(hdl),0) as hdl,FORMAT(SUM(hdl_r),0) as hdl_r
                ,FORMAT(SUM(ldl),0) as ldl,FORMAT(SUM(ldl_r),0) as ldl_r
                ,FORMAT(SUM(chol),0) as chol,FORMAT(SUM(chol_r),0) as chol_r
                ,FORMAT(SUM(tg),0) as tg,FORMAT(SUM(tg_r),0) as tg_r                
                FROM dm_lipid WHERE byear='$byear' and cup='$cup'
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
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmmicroal($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_microalbumin where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmmicroal($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_microalbumin WHERE byear='$byear' and cup='$cup'
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
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmeye($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_eye where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmeye($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_eye
                WHERE byear='$byear' and cup='$cup'
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
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmfoot($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_foot where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmfoot($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_foot
                WHERE byear='$byear' and cup='$cup'
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
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmcontrol($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_control where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_control', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmcontrol($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_control
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_control', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmht($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_ht where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_ht', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmht($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_ht
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_ht', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmkidney($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_kidney where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_kidney', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmkidney($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_kidney
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_kidney', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmstroke($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target ,SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_stroke where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_stroke', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmstroke($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_stroke
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_stroke', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmheart($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_heart where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_heart', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total,'byear' => $byear,
        ]);
    }

    public function actionIndivdmheart($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_heart
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_heart', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmpredm($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(target)as target , SUM(result) as result
            ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
            FROM dm_predm where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
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
        return $this->render('dm_predm', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'target' => $target, 'result' => $result, 'total' => $total ,'byear' => $byear,
        ]);
    }

    public function actionIndivdmpredm($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(target),0)as target 
                ,Format(SUM(result),0) as result
                ,ROUND((SUM(result) * 100)/SUM(target),2) as total,sdate
                FROM dm_predm
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_predm', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmpatient($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
             SELECT distcode, cup ,SUM(total)as total ,sdate
            FROM dm_patient where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];            
            $total[] = $data[$i]['total'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_patient', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'total' => $total ,'byear' => $byear,
        ]);
    }

    public function actionIndivdmpatient($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total ,sdate
                FROM dm_patient
                WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_patient', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }
    
    public function actionDmpatientvisit($byear=2558) {

        $connection = Yii::$app->db;
        $data = $connection->createCommand("
           SELECT distcode, cup ,SUM(total)as total ,sdate
            ,SUM(visit) as visit
            ,SUM(visit_all) as visit_all
            FROM dm_patient_visit where byear= '$byear'
            GROUP BY cup
                        ")->queryAll();
        //เตรียมข้อมูลส่งให้กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {
            $cup[] = $data[$i]['cup'];            
            $total[] = $data[$i]['total'] * 1;
            $visit[] = $data[$i]['visit'] * 1;
            $visit_all[] = $data[$i]['visit_all'] * 1;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
        ]);
        return $this->render('dm_visit', [
                    'dataProvider' => $dataProvider,
                    'cup' => $cup, 'total' => $total,'visit_all'=>$visit_all,'visit'=>$visit,'byear' => $byear,
        ]);
    }

    public function actionIndivdmpatientvisit($cup = null,$byear=nul) {

        $sql = "SELECT distcode, cup ,hospname,FORMAT(SUM(total),0)as total ,sdate
                ,Format(SUM(visit),0) as visit
                ,Format(SUM(visit_all),0) as visit_all
                FROM dm_patient_visit
               WHERE byear='$byear' and cup='$cup'
                GROUP BY hospname";

        $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }

        return $this->render('indivdm_visit', [
                    'rawData' => $rawData,
                    'sql' => $sql,
                    'cup' => $cup,
                    'byear'=>$byear,
        ]);
    }

}
