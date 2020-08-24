<?php
   include('session.php');
   include('profiledb.php');
   if(!isset($_SESSION["loggedin"]) === true){
   header("location: ../index.html");
   exit;
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
   <body id="bodi">
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
								<a href="#" id="myprofiletag">My Profile</a>
								<a href="logout.php">Logout</a>
							</div>
						</div>
   				</div>
               <div class="menu-hamb">
               <div class="bar1"></div>
               <div class="bar2"></div>
               <div class="bar3"></div>
               </div>
   		</div>
   		<div id="content">
            <div class="overlay">
               <div class="overlay-menu">
                  <br>
                  <ul>
                     <li id="menu-question">Questions</li><hr>
                     <li id="menu-top">Top Voted</li><hr>
                     <li id="menu-review">Reviews</li><hr>
                     <li id="menu-event">Events</li><hr>
                  </ul>
               </div>
            </div>
   			<div id="questions">
   				Latest Threads
               <?php
               $sql="SELECT * FROM questions WHERE area='$locat' ORDER BY dateposted desc";
               $result = mysqli_query($conn, $sql);
               if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                     $quesid=$row['questionid'];
                     $sql1="SELECT * FROM votes WHERE questionid=$quesid AND liked=1";
                     $ress=mysqli_query($conn,$sql1);
                     if($ress){
                     echo "<span id='quesdisp'>"."ID: " . $row["questionid"]." <br><b>" . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Upvotes:".mysqli_num_rows($ress)."<br></span>";
                     }
                  }
               } else {
                  echo "<span id='quesdispnone'>"."No questions to show now!"."</span>";
               }

               ?>      
            </div>
            <div id="myprofile">
               
            </div>
            <div id="askquestions">
               <form id="askquestion-form" method="post" action="askquestion.php">
                  <input type="text" name="askquestext" id="askques-text" placeholder="Whats on your mind?" autocomplete="off" /><br>
                  <input type="submit" name="askquessubm" id="askques-subm"/>
               </form>
            </div>
            <div class="cardprofile"></div>
            <div id="topvotes">
               Top Voted
               <?php
               $sql="SELECT * FROM questions WHERE questionid IN (SELECT questionid FROM votes WHERE liked=1) AND area='$locat' GROUP BY questionid ORDER BY count(*)";
               $result = mysqli_query($conn, $sql);
               if (mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                     $quesid=$row['questionid'];
                     $sql1="SELECT * FROM votes WHERE questionid=$quesid AND liked=1";
                     $ress=mysqli_query($conn,$sql1);
                     if($ress){
                     echo "<span id='quesdisp'>"." <br><b>" . $row["question"]. "</b><br>Date asked: " . $row["dateposted"]. "<br>Upvotes:".mysqli_num_rows($ress)."<br></span>";
                     }
                  }
               } else {
                  echo "<span id='quesdispnone'>"."No questions to show now!"."</span>";
               }

               ?> 
               
            </div>
            <div id="chatroom">
               <i style='font-size:1.4vw' class='fa fa-envelope'></i>
               Local Chat Room
            </div>
            <div id="chatmessage">
               <div id="messages-his">
                  <?php
                  if($_GET['msg']==1){
                     $mess=$_GET["messagedata"];
                     $sq="INSERT INTO messages (user,message) VALUES ('$login_session','$mess')";
                     if (mysqli_query($conn, $sq)){
                        echo "<script>alert('Messages cannot be sent now!')</script>";
                     }
                     else{
                        echo "<script>alert('Messages sent!')</script>";
                     }
                     header("Location: dashboard.php?msg=0");
                  }
                  $sql="SELECT * FROM messages";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0) {
                     while($row = mysqli_fetch_assoc($result)) {
                        echo "<span id='msgdisp'>"."Date: " . $row["dateposted"]." <br><b>" . $row["user"]. "</b><br>Message: " . $row["message"]. "<br>"."</span>";
                     }
                  } else {
                     echo "<span id='msgdisp'>No messages to show now!</span>";
                  }

                  ?>
               </div>
               <span id="chatmsgclose">X</span>
               <textarea placeholder="Enter your message here." id="messagetext"></textarea>
               <i class="fa fa-paper-plane" id="sendbutton"></i>
               <i class="fa fa-trash" id="trashbutton"></i>
            </div>
   		</div>
   	</div>
      <script type="text/javascript" src="../java/dashboardscript.js">
      </script>
   </body>
</html>