 <?php

ini_set('max_execution_time', 1000); //300 seconds = 5 minutes
$date_time = date('d-m-Y   h:i');

$header = "  
    <div></div>
	<table width='100%'>
		<tr valign='top'>
			<td align='center'>
				<div class='header-text bold'>
					<h2><B>ศูนย์ความร่วมมือ โรงพยาบาลร้อยเอ็ด</B></h2>
				</div>
			</td>
		</tr>
	</table>	
    ";

// to member
$header .= "

    ";

$content = "

    <table width='100%' cellspacing='3' cellpadding='5'>
        <thead>
            <tr style='TEXT-ALIGN: center; BACKGROUND-COLOR: #e6e4e5' >
                <td width='15%'>รหัส</td>
                <td width='85%'>ชื่อคำนำหน้า</td>
            </tr>
        </thead>
        <tbody>";

$sql='select cid,fname from patient';

$rw = Yii::$app->db->createCommand($sql)->queryAll();
$i = 1;
foreach ($rw as $ds) {
    $content .= "
        <tr colspan=5>
            <td >$ds[cid]</td>
            <td >$ds[fname]</td>
        </tr>";
    $i++;
}
$content .= "
        </tbody>
    </table>
    <hr>
    <div align='right'>
    $date_time
        </div>
    <br />";

$html = $content ;

//==============================================================
//==============================================================
//==============================================================

//include_once '../MPDF/mpdf.php'; // path
 include_once '../vendor/kartik-v/MPDF/mpdf.php';
 $mpdf = new mPDF('th','A4','0', 'THSaraban');
$mpdf->SetDisplayMode('fullpage');
 //$mpdf->SetHeader('ศูนย์ความร่วมมือ โรงพยาบาลร้อยเอ็ด||วันที่จัดทำ '.date("d-m-Y H:i:s").'');
 $mpdf->SetHeader($header.'||วันที่จัดทำ '.date("d-m-Y H:i:s").'');
 $mpdf->SetFooter('© Mr.Suttha Prasongsap||แผ่นที่ {PAGENO}');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================
?>

