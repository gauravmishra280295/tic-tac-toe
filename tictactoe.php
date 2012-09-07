<html>
<head>
<title> Hello! </title>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>
<body>
<?php
$src="Full path where you installed the game(ex. http:\\www.yourdomain.com\tictactoe.php)";
if(empty($ipadd)){$ipadd=$_SERVER['SERVER_ADDR'];}
function win($what,$ipadd){
	echo "You $what!!<br /><a href='$src'>Play again!</a></body></html>";
	$sql="DELETE FROM tic_tac WHERE ipadd='$ipadd';";
	$res=mysql_query($sql);
	$sql="OPTIMIZE TABLE tic_tac";
	$res=mysql_query($sql);
	exit();
}
$db=mysql_connect("localhost", "DATABASE_USER_NAME", "DATABASE_PASSWORD") or die ('I cannot connect to the database  because: ' . mysql_error());
$mydb=mysql_select_db("DATABASE_TABLE");
if(!empty($_POST['user'])){
	$user=$_POST['user'];
	$sql="SELECT * FROM tic_tac WHERE ipadd='$ipadd'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res) < 1){
		$sql="INSERT INTO tic_tac(ipadd,usermove,commove) VALUES('$ipadd','','')";
		$result=mysql_query($sql);
		$sql="SELECT * FROM tic_tac WHERE ipadd='$ipadd'";
		$res=mysql_query($sql);
	}
	$row=mysql_fetch_array($res);
	if($user=='x'||$user=='X'){$com='O';}
	if($user=='o'||$user=='O'||$user=='0'){$user='O';$com='X';}
	$user=strtoupper($user);
	if(empty($_POST['move'])){
		echo 'U r playng with ',$user,' and comp with ',$com,'<br />Take ur keypad as grid & start playing by replying with grid number<br />E.g.: 4 for 2 row 1 column<br />';
	}
	$grid=array();
	$grid[0]=array('   ','   ','   ');
	$grid[1]=array('   ','   ','   ');
	$grid[2]=array('   ','   ','   ');
	if(!empty($_POST['move'])){
		$usermove=explode(',',$row['usermove']);
		$commove=explode(',',$row['commove']);
		$postusermove=$row['usermove'];
		$postcommove=$row['commove'];
		$taken="";
		foreach($usermove as $value){$taken.=",".$value;}
		foreach($commove as $value){$taken.=",".$value;}
		$usermove=$_POST['move'];
		$pos=strpos($taken,$usermove);
		if($pos!==false){
			echo '<br />This position is not empty!!';
			echo '<form action="'.$src.'" method="post">';
			echo 'Your option<input type="text" name="move" />';
			echo '<input type="hidden" name="user" value="',$user,'" />';
			echo '<input type="hidden" name="ipadd" value="',$ipadd,'" />';
			echo '<input type="submit" value="send" /></form>';
			echo '</body></html>';
			exit();
		}
		if(!empty($row['usermove'])){$postusermove=$row['usermove'].','.$usermove;}
		else{$postusermove=$usermove;}
		$usermove=explode(',',$postusermove);
		$commove=explode(',',$row['commove']);
		$taken="";
		foreach($usermove as $value){$taken.=",".$value;}
		foreach($commove as $value){$taken.=",".$value;}
		$take=explode(',',$taken);
		$tictacToe = array(1,2,3,4,5,6,7,8,9);
		$available=array();
		$available = array_diff($tictacToe,$take);
		$moves=explode(',',$postusermove);
		foreach($moves as $value){
			switch($value){
				case '1':$grid[0][0]=' '.$user.' ';
					break;
				case '2':$grid[0][1]=' '.$user.' ';
					break;
				case '3':$grid[0][2]=' '.$user.' ';
					break;
				case '4':$grid[1][0]=' '.$user.' ';
					break;
				case '5':$grid[1][1]=' '.$user.' ';
					break;
				case '6':$grid[1][2]=' '.$user.' ';
					break;
				case '7':$grid[2][0]=' '.$user.' ';
					break;
				case '8':$grid[2][1]=' '.$user.' ';
					break;
				case '9':$grid[2][2]=' '.$user.' ';
					break;
			}
		}
		$cmoves=explode(',',$row['commove']);
		foreach($cmoves as $value){
			switch($value){
				case '1':$grid[0][0]=' '.$com.' ';
					break;
				case '2':$grid[0][1]=' '.$com.' ';
					break;
				case '3':$grid[0][2]=' '.$com.' ';
					break;
				case '4':$grid[1][0]=' '.$com.' ';
					break;
				case '5':$grid[1][1]=' '.$com.' ';
					break;
				case '6':$grid[1][2]=' '.$com.' ';
					break;
				case '7':$grid[2][0]=' '.$com.' ';
					break;
				case '8':$grid[2][1]=' '.$com.' ';
					break;
				case '9':$grid[2][2]=' '.$com.' ';
					break;
			}
		}
		$ran=0;
		//For user
		if(($grid[0][1]==$grid[0][2])&&$grid[0][1]!='   '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[1][0]==$grid[2][0])&&$grid[1][0]!='   '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[1][1]==$grid[2][2])&&$grid[1][1]!='   '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[0][0]==$grid[0][2])&&$grid[0][0]!='   '&&$grid[0][1]=='   '){$ran=2;}
		if(($grid[1][1]==$grid[2][1])&&$grid[1][1]!='   '&&$grid[0][1]=='   '){$ran=2;}
		if(($grid[0][0]==$grid[0][1])&&$grid[0][0]!='   '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][2]==$grid[2][2])&&$grid[1][2]!='   '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][1]==$grid[2][0])&&$grid[1][1]!='   '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][1]==$grid[1][2])&&$grid[1][1]!='   '&&$grid[1][0]=='   '){$ran=4;}
		if(($grid[0][0]==$grid[2][0])&&$grid[0][0]!='   '&&$grid[1][0]=='   '){$ran=4;}
		if(($grid[1][0]==$grid[1][2])&&$grid[1][0]!='   '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][1]==$grid[2][1])&&$grid[0][1]!='   '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][0]==$grid[2][2])&&$grid[0][0]!='   '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][2]==$grid[2][0])&&$grid[0][2]!='   '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[1][0]==$grid[1][1])&&$grid[1][0]!='   '&&$grid[1][2]=='   '){$ran=6;}
		if(($grid[0][2]==$grid[2][2])&&$grid[0][2]!='   '&&$grid[1][2]=='   '){$ran=6;}
		if(($grid[2][1]==$grid[2][2])&&$grid[2][1]!='   '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[0][0]==$grid[1][0])&&$grid[0][0]!='   '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[0][2]==$grid[1][1])&&$grid[0][2]!='   '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[2][0]==$grid[2][2])&&$grid[2][0]!='   '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[0][1]==$grid[1][1])&&$grid[0][1]!='   '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[0][1]==$grid[1][1])&&$grid[0][1]!='   '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[2][0]==$grid[2][1])&&$grid[2][0]!='   '&&$grid[2][2]=='   '){$ran=9;}
		if(($grid[0][2]==$grid[1][2])&&$grid[0][2]!='   '&&$grid[2][2]=='   '){$ran=9;}
		if(($grid[0][0]==$grid[1][1])&&$grid[0][0]!='   '&&$grid[2][2]=='   '){$ran=9;}
		//For computer
		if(($grid[0][1]==$grid[0][2])&&$grid[0][1]==' '.$com.' '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[1][0]==$grid[2][0])&&$grid[1][0]==' '.$com.' '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[1][1]==$grid[2][2])&&$grid[1][1]==' '.$com.' '&&$grid[0][0]=='   '){$ran=1;}
		if(($grid[0][0]==$grid[0][2])&&$grid[0][0]==' '.$com.' '&&$grid[0][1]=='   '){$ran=2;}
		if(($grid[1][1]==$grid[2][1])&&$grid[1][1]==' '.$com.' '&&$grid[0][1]=='   '){$ran=2;}
		if(($grid[0][0]==$grid[0][1])&&$grid[0][0]==' '.$com.' '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][2]==$grid[2][2])&&$grid[1][2]==' '.$com.' '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][1]==$grid[2][0])&&$grid[1][1]==' '.$com.' '&&$grid[0][2]=='   '){$ran=3;}
		if(($grid[1][1]==$grid[1][2])&&$grid[1][1]==' '.$com.' '&&$grid[1][0]=='   '){$ran=4;}
		if(($grid[0][0]==$grid[2][0])&&$grid[0][0]==' '.$com.' '&&$grid[1][0]=='   '){$ran=4;}
		if(($grid[1][0]==$grid[1][2])&&$grid[1][0]==' '.$com.' '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][1]==$grid[2][1])&&$grid[0][1]==' '.$com.' '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][0]==$grid[2][2])&&$grid[0][0]==' '.$com.' '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[0][2]==$grid[2][0])&&$grid[0][2]==' '.$com.' '&&$grid[1][1]=='   '){$ran=5;}
		if(($grid[1][0]==$grid[1][1])&&$grid[1][0]==' '.$com.' '&&$grid[1][2]=='   '){$ran=6;}
		if(($grid[0][2]==$grid[2][2])&&$grid[0][2]==' '.$com.' '&&$grid[1][2]=='   '){$ran=6;}
		if(($grid[2][1]==$grid[2][2])&&$grid[2][1]==' '.$com.' '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[0][0]==$grid[1][0])&&$grid[0][0]==' '.$com.' '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[0][2]==$grid[1][1])&&$grid[0][2]==' '.$com.' '&&$grid[2][0]=='   '){$ran=7;}
		if(($grid[2][0]==$grid[2][2])&&$grid[2][0]==' '.$com.' '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[0][1]==$grid[1][1])&&$grid[0][1]==' '.$com.' '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[0][1]==$grid[1][1])&&$grid[0][1]==' '.$com.' '&&$grid[2][1]=='   '){$ran=8;}
		if(($grid[2][0]==$grid[2][1])&&$grid[2][0]==' '.$com.' '&&$grid[2][2]=='   '){$ran=9;}
		if(($grid[0][2]==$grid[1][2])&&$grid[0][2]==' '.$com.' '&&$grid[2][2]=='   '){$ran=9;}
		if(($grid[0][0]==$grid[1][1])&&$grid[0][0]==' '.$com.' '&&$grid[2][2]=='   '){$ran=9;}
		if(!$ran){
			$ran = array_rand($available);
			$ran=$available[$ran];
			unset($available);
		}
		if($ran){
			if(!empty($row['commove'])){$postcommove=$row['commove'].','.$ran;}
			else{$postcommove=$ran;}
		}
		$cmoves=explode(',',$postcommove);
		foreach($cmoves as $value){
			switch($value){
				case '1':$grid[0][0]=' '.$com.' ';
					break;
				case '2':$grid[0][1]=' '.$com.' ';
					break;
				case '3':$grid[0][2]=' '.$com.' ';
					break;
				case '4':$grid[1][0]=' '.$com.' ';
					break;
				case '5':$grid[1][1]=' '.$com.' ';
					break;
				case '6':$grid[1][2]=' '.$com.' ';
					break;
				case '7':$grid[2][0]=' '.$com.' ';
					break;
				case '8':$grid[2][1]=' '.$com.' ';
					break;
				case '9':$grid[2][2]=' '.$com.' ';
					break;
			}
		}
		echo '<br /><pre>';
		echo $grid[0][0],'|',$grid[0][1],'|',$grid[0][2],'<br />';
		echo '---|---|---<br />';
		echo $grid[1][0],'|',$grid[1][1],'|',$grid[1][2],'<br/>';
		echo '---|---|---<br />';
		echo $grid[2][0],'|',$grid[2][1],'|',$grid[2][2],'</pre><br />';
		if(($grid[0][0]==$grid[0][1])&&($grid[0][1]==$grid[0][2])&&($grid[0][0]!='   ')){
			$wi=trim($grid[0][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[1][0]==$grid[1][1])&&($grid[1][1]==$grid[1][2])&&($grid[1][0]!='   ')){
			$wi=trim($grid[1][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[2][0]==$grid[2][1])&&($grid[2][1]==$grid[2][2])&&($grid[2][0]!='   ')){
			$wi=trim($grid[2][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[0][0]==$grid[1][0])&&($grid[1][0]==$grid[2][0])&&($grid[0][0]!='   ')){
			$wi=trim($grid[0][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[0][1]==$grid[1][1])&&($grid[1][1]==$grid[2][1])&&($grid[0][1]!='   ')){
			$wi=trim($grid[0][1]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[0][2]==$grid[1][2])&&($grid[1][2]==$grid[2][2])&&($grid[0][2]!='   ')){
			$wi=trim($grid[0][2]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[0][0]==$grid[1][1])&&($grid[1][1]==$grid[2][2])&&($grid[0][0]!='   ')){
			$wi=trim($grid[0][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
		if(($grid[0][2]==$grid[1][1])&&($grid[1][1]==$grid[2][0])&&($grid[2][0]!='   ')){
			$wi=trim($grid[2][0]);
			if($wi==$user){
				win('win',$ipadd);
			}
			if($wi==$com){
				win('loose',$ipadd);
			}
		}
	}
	if($postusermove&&$postcommove){
		$usermove=explode(',',$postusermove);
		$commove=explode(',',$postcommove);
		$taken="";
		foreach($usermove as $value){$taken.=",".$value;}
		foreach($commove as $value){$taken.=",".$value;}
		$take=explode(',',$taken);
		$totals=count($take);
		if($totals==10){
			$sql="DELETE FROM tic_tac WHERE ipadd='$ipadd';";
			$res=mysql_query($sql);
			echo 'Match Draw!!<br /><a href="'.$src.'">Play again.</a></body></html>';
			exit();
		}
	}
	if(empty($_POST['move'])){
		echo '<br /><pre>';
		echo '   |   |   <br />';
		echo '---|---|---<br />';
		echo '   |   |   <br/>';
		echo '---|---|---<br />';
		echo '   |   |   </pre><br />';
	}
	$sql="UPDATE tic_tac SET usermove='$postusermove', commove='$postcommove' WHERE ipadd='$ipadd';";
	$res=mysql_query($sql);
	echo '<form action="'.$src.'" method="post">';
	echo 'Your option<input type="text" name="move" />';
	echo '<input type="hidden" name="user" value="',$user,'" />';
	echo '<input type="hidden" name="ipadd" value="',$ipadd,'" />';
	echo '<input type="submit" value="send" /></form>';
	echo '</body></html>';
	exit();
}
$sql="DELETE FROM tic_tac WHERE ipadd='$ipadd';";
$res=mysql_query($sql);
echo 'Wellcome, choose youre cue<br/>';
echo '<form action="'.$src.'" method="post">';
echo 'X or O<input type="text" size=1 name="user" />';
echo '<input type="hidden" name="ipadd" value="'.$ipadd.'" />';
echo '<input type="submit" value="choose" /></form>';
?>
</body>
</html>