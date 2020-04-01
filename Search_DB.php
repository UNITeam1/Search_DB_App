<?php
//sql 접속
$con = new mysqli('localhost','root','','leesy');
mysqli_set_charset($con,'utf8');

if(!$con)
{
die('Could not connect: ' . mysql_error());
//echo "에러";
}
else
{
//echo "접속성공";
//echo "<br>";
}

//comand로 파이썬 파일 실행
$command = escapeshellcmd('C:/Users/sansa/Desktop/Sansam/Study/Test2/Test.py');
$result=array();
$print=array();

//파이썬 파일의 출력문을 배열로 result 변수에 저장
exec($command,$result);


$nn=count($result);
$out=array();
//echo "<table border = '1'><th>약품명</th><th>상세</th>";
for($i=0;$i<$nn;$i=$i+1)
{
//파이썬출력문 인코딩 변환하여 out 배열에 저장
$out[$i]=iconv("UHC", "UTF-8", $result[$i]);


$sql ="select * from medicine where name = '$out[$i]'";

//output 에 쿼리문 결과 저장
$output=mysqli_query($con,$sql);


/*
오류검출용
if (!$output) {
    die('Invalid query: ' . mysqli_error($con));
}
*/

//쿼리의 결과가 존재 할 경우만 mysqli_fetch_row 함수 실행
if($output)
{
while($row= mysqli_fetch_row($output))
{
	array_push($print,array('name'=>$row[0],'eff'=>$row[1]));
	
}
}
}
echo json_encode(array("result"=>$print));
echo "</table>";
?>
