<?php
include('session.php');
include('profiledb.php');
   if(!isset($_SESSION["loggedin"]) === true){
   header("location: ../index.html");
   exit;
}
$value = $_GET['val'];
$res = "";
$sql="SELECT * FROM answers WHERE questionid = $value";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
while($row = mysqli_fetch_assoc($result)) {
$res= $res."<span id='ansdisp'>"."id: " . $row["answerid"]." <br>Name: " . $row["answeredby"]. "<br><b> " . $row["answer"]. "</b><br>"."</span>";
}
} else {
$res= "<span id='ansdispnone'>No one has Answered yet! Why dont you give it a try</span>";
}
?>
<html">   
   <head>
      	<title>Dashboard</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://kit.fontawesome.com/a076d05399.js"></script>
      	<link rel="stylesheet" type="text/css" href="../css/dashboardstyle.css">
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
      	<meta name="viewport" content="width=device-width, initial-scale=1">
   </head>
   <body>
   	<div id="wrapper">
   		<div id="header">
   				<div id="sitename">
   					<span id="namesite"><a href="dashboard.php?msg=0">NAMMA AREA</a></span>
   				</div>
   				<div id="userpanel">
   					<span id="uname">
   						Welcome, <?php echo $login_session; ?>
   					</span>
						<div class="dropdown">
							<button class="dropbtn"><i class="fa fa-cog fa-spin"></i></button>
							<div class="dropdown-content">
								<a href="logout.php">Logout</a>
							</div>
						</div>
   				</div>
   		</div>
   		<div id="content">
            <div id="question-disp">
               Thread
               <?php
               $sql="SELECT * FROM questions WHERE questionid=$value";
               $result = mysqli_query($conn, $sql);
               if (mysqli_num_rows($result) > 0) {
               		$sql2="SELECT * FROM votes WHERE questionid=$value AND username='$login_session'";
               		$result2 = mysqli_query($conn, $sql2);
               		$row = mysqli_fetch_assoc($result);
                  	if(mysqli_num_rows($result2)>0){
                  		$row2 = mysqli_fetch_assoc($result2);
	                  	if($row2["liked"]==1){
	                    	echo "<span id='quesdisplay'>"."ID: " . $row["questionid"]." <br><b> " . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Asked by: ".$row["askedby"]."<br><div class='liked highlight'><i class='fas fa-thumbs-up'></i></div><div class='disliked'><i class='fas fa-thumbs-down'></i></div></span>";
	                	}
	                	elseif ($row2['disliked']==1) {
	                		echo "<span id='quesdisplay'>"."ID: " . $row["questionid"]." <br><b> " . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Asked by: ".$row["askedby"]."<br><div class='liked'><i class='fas fa-thumbs-up'></i></div><div class='highlight disliked'><i class='fas fa-thumbs-down'></i></div></span>";
	                	}
	                	else{
                			echo "<span id='quesdisplay'>"."ID: " . $row["questionid"]." <br><b> " . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Asked by: ".$row["askedby"]."<br><div class='liked'><i class='fas fa-thumbs-up'></i></div><div class='disliked'><i class='fas fa-thumbs-down'></i></div></span>";
                		}
	                }
                	else{
                		echo "<span id='quesdisplay'>"."ID: " . $row["questionid"]." <br><b> " . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Asked by: ".$row["askedby"]."<br><div class='liked'><i class='fas fa-thumbs-up'></i></div><div class='disliked'><i class='fas fa-thumbs-down'></i></div></span>";
                	}
    
               	} else {
                	echo "<span id='quesdisp'>"."Error, try again!"."</span>";
               	}
               ?>
            </div>
            <div id="answers">
            		<?php
            		echo $res;
            		?>
            </div>
            <br>
            <div id="ansques">
               <form method="post" id="askquestion-form"action="submitanswers.php?id=<?php echo $value; ?>">
                  <input type="text" name="postansr" autocomplete="off" id="askques-text" placeholder="Type something to answer." />
                  <br>
                  <input type="submit" name="postansrsubm" id="askques-subm">
               </form>
            </div>
   		</div>
   	</div>
      <script type="text/javascript" src="../java/questionfetchscript.js">
      </script>
   </body>
</html>