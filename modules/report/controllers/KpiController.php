<?php

namespace app\modules\report\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class KpiController extends Controller {

    public function actionReport1() {
        $connection = Yii::$app->db_test;
        $data = $connection->createCommand('
               SELECT
year(t.date3)+543 AS yy,
month(t.date3) AS mm,
Count(t.hn) AS cnt555,
months.months_name_th as mm2
FROM
item_tiger_lc AS t
INNER JOIN months ON months.months_id = month(t.date3)
WHERE t.date3 <>""
GROUP BY yy,mm
ORDER BY yy,mm
            ')->queryAll();

        //กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {

            $yy[] = $data[$i]['yy'];
            $mm[] = $data[$i]['yy'] . '-' . $data[$i]['mm'];
            $cnt555[] = $data[$i]['cnt555'] + 0; //$data[$i]['cnt555'];
        }
//                print_r($cnt555);  
//                 print_r($cnt);  
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['yy', 'mm2', 'cnt555']
            ],
        ]);

        return $this->render('report1', [
                    'dataProvider' => $dataProvider,
                    'yy' => $yy,
                    'mm' => $mm,
                    'cnt555' => $cnt555,
        ]);
    }

    public function actionReport2() {
        $connection = Yii::$app->db_test;
        $data = $connection->createCommand('
           SELECT year(t.date1_1)+543 as yy,
            month(t.date1_1) as mm,
            COUNT(t.HN) as cnt,
            months.months_name_th as mm2
            FROM item_tomor_board t  
INNER JOIN months ON months.months_id = month(t.date1_1)            
WHERE t.date1_1 <>""
            GROUP BY yy,mm
            ORDER BY yy,mm
            ')->queryAll();

        //กราฟ
        for ($i = 0; $i < sizeof($data); $i++) {

            $yy[] = $data[$i]['yy'];
            $mm[] = $data[$i]['yy'] . '-' . $data[$i]['mm'];
            $cnt[] = $data[$i]['cnt'] + 0;
        }
        //   print_r($cnt);   
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['yy', 'mm2', 'cnt']
            ],
        ]);

        return $this->render('report2', [
                    'dataProvider' => $dataProvider,
                    'yy' => $yy,
                    'mm' => $mm,
                    'cnt' => $cnt,
        ]);
    }

    public function actionReport_kpi() {
        $connection = Yii::$app->db_test;
          if(isset($_POST['year'])){
                 $year= $_POST['year']; 
           //  '".$_POST['year']."' 
          
          }  else {
           $year=   date("Y")+543;
          }


        $data = $connection->createCommand('
        SELECT
year(t.date_key)+543 AS yy,
month(t.date_key) AS mm,
t.user_key,
Count(t.cid) AS cnt555,
months.months_name_th as mm2,
t.type_from
FROM
patient AS t
INNER JOIN months ON months.months_id = month(t.date_key)
WHERE t.date_key <>"" and year(t.date_key)+543='.$year.'
GROUP BY type_from, user_key,yy,mm
ORDER BY yy,mm
            ')->queryAll();
//echo $year;
        ////////////////////////////////////////////
        //  $arraytype_from = array();
        //    $arraytype_from[] = '';

        $dataYy = $connection->createCommand('
        SELECT
        year(t.date_key)+543 AS yy
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY yy
        ')->queryAll();

        $dataType = $connection->createCommand('
        SELECT
        t.type_from
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY type_from
        ')->queryAll();

        foreach ($dataType as $valueType) {

            $dataValue = $connection->createCommand('
            SELECT
            year(t.date_key)+543 AS yy,
            month(t.date_key) AS mm,
            t.user_key,
            Count(t.cid) AS cnt,
            months.months_name_th as mm2,
            t.type_from
            FROM
            patient AS t
            INNER JOIN months ON months.months_id = month(t.date_key)
            WHERE t.date_key <>"" AND t.type_from="' . $valueType['type_from'] . '" and year(t.date_key)+543='.$year.'
            GROUP BY type_from,yy,mm
            ORDER BY mm
            ')->queryAll();

            foreach ($dataValue as $value) {
                $yy = $value['yy'];
                $mm = $value['mm'];

                $yy_mm = $yy . '-' . $mm;

                //echo '<br>' . $yy_mm . '/' . $valueType['type_from'] . '/' . $value['cnt'];
                //echo '-----';
                for ($i =0; $i <= 12; $i++) {
                    $y_m = $year.'-' . $i;
                 //if($i==0){$i=1;}  
    

                    if ($yy_mm == $y_m) {
                        //$varray[$i] = $value['cnt']+0;
                        
                        $arraytype_from[$valueType['type_from']][$i] = $value['cnt']+0;
                    } else {
                        //$varray[$i] = 0 ;
                        if (!empty($arraytype_from[$valueType['type_from']][$i])) {
                            $ch = $arraytype_from[$valueType['type_from']][$i];
                            //echo 'ch:' . $ch;
                            if ($arraytype_from[$valueType['type_from']][$i] > 0) {
                                
                            } else {
                                $arraytype_from[$valueType['type_from']][$i] = 0;
                            }
                        } else {
                            //if($i>=1){
                            $arraytype_from[$valueType['type_from']][$i] = 0;
                            //}
                        }
                    }
                 
                    //echo '<br>' . $y_m . '/' .  $arraytype_from[$valueType['type_from']][$i];
                }
            }
 
        }
    //    print_r($arraytype_from);
        $mount = [[],'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
            'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['user_key', 'yy', 'mm2', 'cnt555']
            ],
        ]);
        if (empty($arraytype_from[$valueType['type_from']])) {
//            echo '<script type="text/javascript">';
//            echo 'alert("ไม่มีข้อมูล ที่ค้นหาครับ !!!")';
//            echo '</script>';
             $arraytype_from=[null];
              Yii::$app->session->setFlash('danger', 'ไม่มีข้อมูล ที่ค้นหาครับ !!!');
              return $this->render('report_kpi', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                        'mm' => $mount,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        } else {
              Yii::$app->session->setFlash('success', 'ค้นหา เรียบร้อยแล้ว');
            return $this->render('report_kpi', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                        'mm' => $mount,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        }

        //กราฟ
//        for($i=0;$i< sizeof($data1); $i++)
//                {
//             $user_key[]=$data1[$i]['user_key'];
//            $yy[]=$data1[$i]['yy'];
//              $mm1[]=$data1[$i]['yy'].'-'.$data1[$i]['mm'].'-'.$data1[$i]['user_key'];
//                $cnt1[]=$data1[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//                    for($i=0;$i< sizeof($data2); $i++)
//                {
//             $user_key[]=$data2[$i]['user_key'];
//            $yy[]=$data2[$i]['yy'];
//              $mm2[]=$data2[$i]['yy'].'-'.$data2[$i]['mm'].'-'.$data2[$i]['user_key'];
//                $cnt2[]=$data2[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//                         for($i=0;$i< sizeof($data3); $i++)
//                {
//             $user_key[]=$data3[$i]['user_key'];
//            $yy[]=$data3[$i]['yy'];
//              $mm3[]=$data3[$i]['yy'].'-'.$data3[$i]['mm'].'-'.$data3[$i]['user_key'];
//                $cnt3[]=$data3[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//                         for($i=0;$i< sizeof($data4); $i++)
//                {
//             $user_key[]=$data4[$i]['user_key'];
//            $yy[]=$data4[$i]['yy'];
//              $mm4[]=$data4[$i]['yy'].'-'.$data4[$i]['mm'].'-'.$data4[$i]['user_key'];
//                $cnt4[]=$data4[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//                         for($i=0;$i< sizeof($data5); $i++)
//                {
//             $user_key[]=$data5[$i]['user_key'];
//            $yy[]=$data5[$i]['yy'];
//              $mm5[]=$data5[$i]['yy'].'-'.$data5[$i]['mm'].'-'.$data5[$i]['user_key'];
//                $cnt5[]=$data5[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//                         for($i=0;$i< sizeof($data6); $i++)
//                {
//             $user_key[]=$data6[$i]['user_key'];
//            $yy[]=$data6[$i]['yy'];
//              $mm6[]=$data6[$i]['yy'].'-'.$data6[$i]['mm'].'-'.$data6[$i]['user_key'];
//                $cnt6[]=$data6[$i]['cnt555']+0;//$data[$i]['cnt555'];
//
//                }
//        for ($i = 0; $i < sizeof($data); $i++) {
//            $user_key[] = $data[$i]['user_key'];
//            $yy[] = $data[$i]['yy'];
//            $mm[] = $data[$i]['yy'] . '-' . $data[$i]['mm'] . '-' . $data[$i]['user_key'] . '-' . $data[$i]['type_from'];
//            $mm55[] = $data[$i]['yy'] . '-' . $data[$i]['mm'];
//            $cnt[] = $data[$i]['cnt555'] + 0; //$data[$i]['cnt555'];
//        }
//        //  print_r($mm55);
//        //    print_r($cnt1);
//        //    print_r($cnt2);
//        $dataProvider = new ArrayDataProvider([
//            'allModels' => $data,
//            'sort' => [
//                'attributes' => ['user_key', 'yy', 'mm2', 'cnt555']
//            ],
//        ]);
//
//        return $this->render('report_key_m', [
//                    'dataProvider' => $dataProvider,
//                    'yy' => $yy,
//                    'mm' => $mm, 'mm55' => $mm55,
//                    // 'mm1'=>$mm1, 'mm2'=>$mm2, 'mm3'=>$mm3, 'mm4'=>$mm4, 'mm5'=>$mm5, 'mm6'=>$mm6,'mm55'=>$mm55,
//                    'cnt' => $cnt,
//                    //, 'cnt1'=>$cnt1, 'cnt2'=>$cnt2, 'cnt3'=>$cnt3, 'cnt4'=>$cnt4, 'cnt5'=>$cnt5, 'cnt6'=>$cnt6,
//                    'user_key' => $user_key,
//        ]);
    }

    public function actionReport_key_m() {
          if(isset($_POST['mm'])||isset($_POST['year'])){
                 $mm= $_POST['mm']; 
                 $year=$_POST['year']; 
                 
               //   '01'=>'มกราคม','02'=> 'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน', '05'=>'พฤษภาคม', '06'=>'มิถุนายน',
           // '07'=>'กรกฎาคม', '08'=>'สิงหาคม', '09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'
                 
                     if($mm=='01')
                   {
                      $mm_name= "มกราคม";
                   }
                      if($mm=='02')
                   {
                      $mm_name= "กุมภาพันธ์";
                   }
                      if($mm=='03')
                   {
                      $mm_name= "มีนาคม";
                   }
                      if($mm=='04')
                   {
                      $mm_name= "เมษายน";
                   }
                      if($mm=='05')
                   {
                      $mm_name= "พฤษภาคม";
                   }
                      if($mm=='06')
                   {
                      $mm_name= "มิถุนายน";
                   }
                      if($mm=='07')
                   {
                      $mm_name= "กรกฎาคม";
                   }
                      if($mm=='08')
                   {
                      $mm_name= "สิงหาคม";
                   }
                      if($mm=='09')
                   {
                      $mm_name= "กันยายน";
                   }
                      if($mm=='10')
                   {
                      $mm_name= "ตุลาคม";
                   }
                      if($mm=='11')
                   {
                      $mm_name= "พฤศจิกายน";
                   }
                      if($mm=='12')
                   {
                      $mm_name= "ธันวาคม";
                   }
          
          }  else {
           $mm=   date("m");
             $year=   date("Y")+543;
             
               if($mm=='01')
                   {
                      $mm_name= "มกราคม";
                   }
                      if($mm=='02')
                   {
                      $mm_name= "กุมภาพันธ์";
                   }
                      if($mm=='03')
                   {
                      $mm_name= "มีนาคม";
                   }
                      if($mm=='04')
                   {
                      $mm_name= "เมษายน";
                   }
                      if($mm=='05')
                   {
                      $mm_name= "พฤษภาคม";
                   }
                      if($mm=='06')
                   {
                      $mm_name= "มิถุนายน";
                   }
                      if($mm=='07')
                   {
                      $mm_name= "กรกฎาคม";
                   }
                      if($mm=='08')
                   {
                      $mm_name= "สิงหาคม";
                   }
                      if($mm=='09')
                   {
                      $mm_name= "กันยายน";
                   }
                      if($mm=='10')
                   {
                      $mm_name= "ตุลาคม";
                   }
                      if($mm=='11')
                   {
                      $mm_name= "พฤศจิกายน";
                   }
                      if($mm=='12')
                   {
                      $mm_name= "ธันวาคม";
                   }
          }
  $connection = Yii::$app->db_test;
          
        $data = $connection->createCommand('
        SELECT
year(t.date_key)+543 AS yy,
month(t.date_key) AS mm,
day(t.date_key)as dd,
t.user_key,
Count(t.cid) AS cnt555,
months.months_name_th as mm2,
t.type_from
FROM
patient AS t
INNER JOIN months ON months.months_id = month(t.date_key)
WHERE t.date_key <>"" and year(t.date_key)+543='.$year.' and month(t.date_key)='.$mm.'
GROUP BY type_from, user_key,yy,mm,dd
ORDER BY yy,mm
            ')->queryAll();
//echo $year;
        ////////////////////////////////////////////
        //  $arraytype_from = array();
        //    $arraytype_from[] = '';

        $dataYy = $connection->createCommand('
        SELECT
        year(t.date_key)+543 AS yy
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY yy
        ')->queryAll();

        $dataType = $connection->createCommand('
        SELECT
        t.type_from
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY type_from
        ')->queryAll();

        foreach ($dataType as $valueType) {

            $dataValue = $connection->createCommand('
            SELECT
            year(t.date_key)+543 AS yy,
            month(t.date_key) AS mm,
            day(t.date_key)as dd,
            t.user_key,
            Count(t.cid) AS cnt,
            months.months_name_th as mm2,
            t.type_from
            FROM
            patient AS t
            INNER JOIN months ON months.months_id = month(t.date_key)
            WHERE t.date_key <>"" AND t.type_from="' . $valueType['type_from'] . '" and year(t.date_key)+543='.$year.' and month(t.date_key)='.$mm.'
            GROUP BY type_from, user_key,yy,mm,dd
            ORDER BY mm
            ')->queryAll();

            foreach ($dataValue as $value) {
                $yy = $value['yy'];
                $mm = $value['mm'];
                $dd = $value['dd'];
                $yy_mm = $yy . '-' . $mm. '-' . $dd;

                //echo '<br>' . $yy_mm . '/' . $valueType['type_from'] . '/' . $value['cnt'];
                //echo '-----';
                
                for ($i =0; $i <= 31; $i++) {
                  //  if($i<10){$i='0'.$i;}
                    $y_m = $year.'-' .$mm.'-' . $i;
                 //if($i==0){$i=1;}  


                    if ($yy_mm == $y_m) {
                        //$varray[$i] = $value['cnt']+0;
                        //   echo $valueType['type_from'];
                        $arraytype_from[$valueType['type_from']][$i] = $value['cnt']+0;
                    } else {
                        //$varray[$i] = 0 ;
                        if (!empty($arraytype_from[$valueType['type_from']][$i])) {
                            $ch = $arraytype_from[$valueType['type_from']][$i];
                            //echo 'ch:' . $ch;
                            if ($arraytype_from[$valueType['type_from']][$i] > 0) {
                                
                            } else {
                                $arraytype_from[$valueType['type_from']][$i] = 0;
                            }
                        } else {
                            //if($i>=1){
                            $arraytype_from[$valueType['type_from']][$i] = 0;
                            //}
                        }
                    }
                // if(empty($arraytype_from[$valueType['type_from']][$i])){$arraytype_from=[null];}
                 //   echo '<br>' . $y_m . '/' .  $arraytype_from[$valueType['type_from']][$i];
                }
            }
 
        }
   //  if(empty($arraytype_from)){$arraytype_from=[null];}
  //  print_r($arraytype_from);
        $day=[[],'1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17',
            '18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['user_key', 'yy', 'mm2', 'cnt555']
            ],
        ]);
   
        if (empty($arraytype_from)) {
           //  print_r($arraytype_from);
             //   print_r("ไม่มีข้อมูล ที่ค้นหาครับ !!!");
         //   echo '<script type="text/javascript">';
         //   echo 'alert("ไม่มีข้อมูล ที่ค้นหาครับ !!!")';
          //  echo '</script>';
              Yii::$app->session->setFlash('danger', 'ไม่มีข้อมูล ที่ค้นหาครับ !!!');
            $arraytype_from=[null];
              return $this->render('report_key_m', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                       'mm' => $mm_name,
                   'day' => $day,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        } 
        else {  // print_r($arraytype_from);
                // print_r(" ที่ค้นหาครับ !!!");
                Yii::$app->session->setFlash('success', 'ค้นหา เรียบร้อยแล้ว');
            return $this->render('report_key_m', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                        'mm' => $mm_name,
                  'day' => $day,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        }
    }

    public function actionReport_key_d() {
          if(isset($_POST['date'])){
                 $dd= $_POST['date']; 
    
$newdate = strtotime ($dd);
 $year = date ('Y', $newdate )+543;
 $mm = date ('m', $newdate );
 $dd = date ('d', $newdate );

                 
                     if($mm=='01')
                   {
                      $mm_name= "มกราคม";
                   }
                      if($mm=='02')
                   {
                      $mm_name= "กุมภาพันธ์";
                   }
                      if($mm=='03')
                   {
                      $mm_name= "มีนาคม";
                   }
                      if($mm=='04')
                   {
                      $mm_name= "เมษายน";
                   }
                      if($mm=='05')
                   {
                      $mm_name= "พฤษภาคม";
                   }
                      if($mm=='06')
                   {
                      $mm_name= "มิถุนายน";
                   }
                      if($mm=='07')
                   {
                      $mm_name= "กรกฎาคม";
                   }
                      if($mm=='08')
                   {
                      $mm_name= "สิงหาคม";
                   }
                      if($mm=='09')
                   {
                      $mm_name= "กันยายน";
                   }
                      if($mm=='10')
                   {
                      $mm_name= "ตุลาคม";
                   }
                      if($mm=='11')
                   {
                      $mm_name= "พฤศจิกายน";
                   }
                      if($mm=='12')
                   {
                      $mm_name= "ธันวาคม";
                   }
          
          }  else {
               $dd=   date("d");
           $mm=   date("m");
             $year=   date("Y")+543;
             
               if($mm=='01')
                   {
                      $mm_name= "มกราคม";
                   }
                      if($mm=='02')
                   {
                      $mm_name= "กุมภาพันธ์";
                   }
                      if($mm=='03')
                   {
                      $mm_name= "มีนาคม";
                   }
                      if($mm=='04')
                   {
                      $mm_name= "เมษายน";
                   }
                      if($mm=='05')
                   {
                      $mm_name= "พฤษภาคม";
                   }
                      if($mm=='06')
                   {
                      $mm_name= "มิถุนายน";
                   }
                      if($mm=='07')
                   {
                      $mm_name= "กรกฎาคม";
                   }
                      if($mm=='08')
                   {
                      $mm_name= "สิงหาคม";
                   }
                      if($mm=='09')
                   {
                      $mm_name= "กันยายน";
                   }
                      if($mm=='10')
                   {
                      $mm_name= "ตุลาคม";
                   }
                      if($mm=='11')
                   {
                      $mm_name= "พฤศจิกายน";
                   }
                      if($mm=='12')
                   {
                      $mm_name= "ธันวาคม";
                   }
          }
  $connection = Yii::$app->db_test;
          
        $data = $connection->createCommand('
        SELECT
year(t.date_key)+543 AS yy,
month(t.date_key) AS mm,
day(t.date_key)as dd,
t.user_key,
Count(t.cid) AS cnt555,
months.months_name_th as mm2,
t.type_from
FROM
patient AS t
INNER JOIN months ON months.months_id = month(t.date_key)
WHERE t.date_key <>"" and year(t.date_key)+543='.$year.' and month(t.date_key)='.$mm.' and day(t.date_key)='.$dd.'
GROUP BY type_from, user_key,yy,mm,dd
ORDER BY yy,mm
            ')->queryAll();
////echo $year;
        ////////////////////////////////////////////
        //  $arraytype_from = array();
        //    $arraytype_from[] = '';

        $dataYy = $connection->createCommand('
        SELECT
        year(t.date_key)+543 AS yy
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY yy
        ')->queryAll();

        $dataType = $connection->createCommand('
        SELECT
        t.type_from
        FROM
        patient AS t
        WHERE t.date_key <>"" 
        GROUP BY type_from
        ')->queryAll();
//
        foreach ($dataType as $valueType) {

            $dataValue = $connection->createCommand('
            SELECT
            year(t.date_key)+543 AS yy,
            month(t.date_key) AS mm,
            day(t.date_key)as dd,
            t.user_key,
            Count(t.cid) AS cnt,
            months.months_name_th as mm2,
            t.type_from
            FROM
            patient AS t
            INNER JOIN months ON months.months_id = month(t.date_key)
            WHERE t.date_key <>"" AND t.type_from="' . $valueType['type_from'] . '" and year(t.date_key)+543='.$year.' and month(t.date_key)='.$mm.' and day(t.date_key)='.$dd.'
            GROUP BY type_from, user_key,yy,mm,dd
            ORDER BY mm
            ')->queryAll();

   foreach ($dataValue as $value) {
                $yy = $value['yy'];
                $mm = $value['mm'];
                $dd = $value['dd'];
$i =0;
//             for ($i =0; $i <= 31; $i++) {
//                  //  if($i<10){$i='0'.$i;}
//                    $y_m = $year.'-' .$mm.'-' . $i;
//                 //if($i==0){$i=1;}  
//
//
//                    if ($yy_mm == $y_m) {
//                        //$varray[$i] = $value['cnt']+0;
//                        //   echo $valueType['type_from'];
                        $arraytype_from[$valueType['type_from']][$i] = $value['cnt']+0;
//                    } else {
//                        //$varray[$i] = 0 ;
//                        if (!empty($arraytype_from[$valueType['type_from']][$i])) {
//                            $ch = $arraytype_from[$valueType['type_from']][$i];
//                            //echo 'ch:' . $ch;
//                            if ($arraytype_from[$valueType['type_from']][$i] > 0) {
//                                
//                            } else {
//                                $arraytype_from[$valueType['type_from']][$i] = 0;
//                            }
//                        } else {
//                            //if($i>=1){
//                            $arraytype_from[$valueType['type_from']][$i] = 0;
//                            //}
//                        }
//                    }
                // if(empty($arraytype_from[$valueType['type_from']][$i])){$arraytype_from=[null];}
                 //   echo '<br>' . $y_m . '/' .  $arraytype_from[$valueType['type_from']][$i];
//                }
            
   }
        }
 //if(empty($arraytype_from)){$arraytype_from=[null];}
 // print_r($arraytype_from);
//        $day=[[],'1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17',
//            '18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => [
                'attributes' => ['user_key', 'yy', 'mm2', 'cnt555']
            ],
        ]);
//   
        $dd2=['วันที่ '.$dd.' เดือน '.$mm_name.' ปี '.$year];
        if (empty($arraytype_from)) {
        
              Yii::$app->session->setFlash('danger', 'ไม่มีข้อมูล ที่ค้นหาครับ !!!');
            $arraytype_from=[null];
              return $this->render('report_key_d', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                       'mm' => $mm_name,
                   'day' => $dd,
                    'day2' => $dd2,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        } 
        else {  // print_r($arraytype_from);
                // print_r(" ที่ค้นหาครับ !!!");
                Yii::$app->session->setFlash('success', 'ค้นหา เรียบร้อยแล้ว');
            return $this->render('report_key_d', [
                        'dataProvider' => $dataProvider,
                        'arraytype_from' => $arraytype_from,
                        'mm' => 'วันที่ '.$mm_name,
                  'day' => $dd,
                'day2' => $dd2,
                        'dataType' => $dataType,
                  'year'=>$year,
            ]);
        }
    }

    public function actionPdf(){
        return $this->render('pdf');
    }





}
