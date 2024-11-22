<?php
session_start();

// Assuming that the username or full name is stored in the session after login
// Example: $_SESSION['username'] or $_SESSION['fname'] 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixFinder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/report.css">
</head>

<body id="body">

    <!-- <div id="name">
        <p id="namep"><?php echo htmlspecialchars($user_id); ?></p> 
    </div> -->

    <div id="slidingColumn">
        <button id="closeButton">Close</button>
        <div id="pins"></div>
    
        <!-- Pin Icons -->
<div class="hoverable-container" style="position: absolute; top: 135px; right: 90px;" onclick="preparePin('cautionPin')">
    <img 
        id="cautionIcon" 
        src="img/Caution_shadow.png" 
        alt="Caution Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Hazard Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 205px; right: 80px;" onclick="preparePin('cleaningPin')">
    <img 
        id="cleaningIcon" 
        src="img/Cleaning_shadow.png" 
        alt="Cleaning Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Cleaning Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 275px; right: 80px;" onclick="preparePin('electricalPin')">
    <img 
        id="electricalIcon" 
        src="img/Electrical Hazard_shadow.png" 
        alt="Electrical Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Electrical Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 345px; right: 43px;" onclick="preparePin('itPin')">
    <img 
        id="itIcon" 
        src="img/IT Maintenance_shadow.png" 
        alt="IT Maintenance Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">IT Maintenance Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 415px; right: 95px;" onclick="preparePin('repairPin')">
    <img 
        id="repairIcon" 
        src="img/Repair_shadow.png" 
        alt="Repair Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Repair Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 485px; right: 85px;" onclick="preparePin('requestPin')">
    <img 
        id="requestIcon" 
        src="img/Request_shadow.png" 
        alt="Request Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20;"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Request Pin</span>
</div>
        <!-- Add other icons similarly -->
        
        <!-- The Confirm Button will appear when a pin is selected -->
        <button id="confirmButton" style="display: none;" onclick="confirmPin()">Confirm</button>
    </div>
    
    <!-- Map Section -->

    <div id="mapContainer">
        <div id="sidebar-container"></div>

        <svg width="1080" height="1080" viewBox="0 0 1080 1080" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- First Floor -->
            <g id="firstFloor">
                <path id="COLLEGE LIBRARY" class="allPaths" d="M349.5 267.5 H729.5 V851.5 H349.5 Z" fill="#4A55A2" stroke="black" />
                <path id="ST. CARLO ACUTIS CHAPEL" class="allPaths" d="M0.5 267.5 H202.5 V378.5 H0.5 Z" fill="#FFD0D0" stroke="black" />
                <path id="ARETE HALL" class="allPaths" d="M0.5 379.5 H202.5 V485.5 H0.5 Z" fill="#E1ACAC" stroke="black" />
                <path id="DISCUSSION ROOM" class="allPaths" d="M0.5 486.5 H202.5 V584.5 H0.5 Z" fill="#CA8787" stroke="black" />
                <path id="CREDO" class="allPaths" d="M0.5 585.5 H202.5 V679.5 H0.5 Z" fill="#A87676" stroke="black" />
                <path id="CAFETERIA" class="allPaths" d="M0.5 680.5 H202.5 V856.5 H0.5 Z" fill="#835A5A" stroke="black" />
                <path id="CLINIC" class="allPaths" d="M136.5 949.5 H344.5 V1079.5 H136.5 Z" fill="#C5DFF8" stroke="black" />
                <path id="GUIDANCE" class="allPaths" d="M345.5 949.5 H432.5 V1079.5 H345.5 Z" fill="#A0BFE0" stroke="black" />
                <path id="PSYCH LAB" class="allPaths" d="M671.5 949.5 H877.5 V1079.5 H671.5 Z" fill="#7895CB" stroke="black" />
                <path id="STAIRS" class="allPaths" d="M878.5 949.5 H984.5 V1079.5 H878.5 Z" fill="black" stroke="black" />
                <path id="COMFORT ROOMS" class="allPaths" d="M985.5 949.5 H1079.5 V1079.5 H985.5 Z" fill="#4A55A2" stroke="black" />
                <path id="EDTECH" class="allPaths" d="M878.5 770.5 H1079.5 V858.5 H878.5 Z" fill="#F5EFFF" stroke="black" />
                <path id="SANDBOX" class="allPaths" d="M878.5 681.5 H1079.5 V769.5 H878.5 Z" fill="#E5D9F2" stroke="black" />
                <path id="NEXUS" class="allPaths" d="M878.5 486.5 H1079.5 V680.5 H878.5 Z" fill="#CDC1FF" stroke="black" />
                <path id="INSPIRE / ROBOTICS" class="allPaths" d="M878.5 267.5 H1079.5 V485.5 H878.5 Z" fill="#A594F9" stroke="black" />
                <path id="SIMULATION ROOM" class="allPaths" d="M878.5 0.5 H1079.5 V123.5 H878.5 Z" fill="#D2E3C8" stroke="black" />
                <path id="LECTURE ROOM 4" class="allPaths" d="M666.5 0.5 H877.5 V123.5 H666.5 Z" fill="#86A789" stroke="black" />
                <path id="LECTURE ROOM 5" class="allPaths" d="M454.5 0.5 H665.5 V123.5 H454.5 Z" fill="#739072" stroke="black" />
                <path id="LECTURE ROOM 6" class="allPaths" d="M250.5 0.5 H453.5 V123.5 H250.5 Z" fill="#4F6F52" stroke="black" />
                <path id="SERVER 3 ROOM" class="allPaths" d="M166.5 0.5 H249.5 V123.5 H166.5 Z" fill="#3F6142" stroke="black" />
                <path id="STAIRS_2" class="allPaths" d="M83.5 0.5 H165.5 V123.5 H83.5 Z" fill="black" stroke="black" />
                <path id="COMFORT ROOMS_2" class="allPaths" d="M0.5 0.5 H82.5 V123.5 H0.5 Z" fill="#4A55A2" stroke="black" />

                <text x="540" y="540" font-size="24" fill="black" font-family="Arial" id="libraryText" text-anchor="middle">
                    College Library
                </text>
                <text x="101" y="325" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    St. Carlo Acutis Chapel
                </text>
                <text x="101" y="432" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Arete Hall
                </text>
                <text x="101" y="535" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Discussion Room
                </text>
                <text x="101" y="635" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Credo
                </text>
                <text x="101" y="768" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Cafeteria
                </text>
                <text x="240" y="1014" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Clinic
                </text>
                <text x="389" y="1014" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Guidance
                </text>
                <text x="774" y="1014" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Psych Lab
                </text>
                
                <text x="1032" y="1014" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    CR
                </text>
                <text x="978" y="817" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    EdTech
                </text>
                <text x="978" y="725" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Sandbox
                </text>
                <text x="978" y="583" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Nexus
                </text>
                <text x="978" y="376" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Inspire / Robotics
                </text>
                <text x="978" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Simulation Room
                </text>
                <text x="772" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Lecture Room 4
                </text>
                <text x="560" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Lecture Room 5
                </text>
                <text x="352" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Lecture Room 6
                </text>
                <text x="208" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    <tspan x="208" dy="0">Server</tspan>
                    <tspan x="208" dy="1.2em">3 Room</tspan>
                </text>
                <text x="41" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    CR 2
                </text>         

            <g style="cursor: pointer;" onclick="showFloor(2)">
                <image href="/img/2nd.svg" x="1120" y="1000" width="60" height="60" />
            </g>
            </g>

            <!-- Second Floor -->
            <g id="secondFloor">
                <path id="COLLEGE LIBRARY" class="allPaths" d="M352.5,268.5 h380 v584 h-380 z" fill="#4A55A2" stroke="black" />
                <path id="COLLEGE LIBRARY_2" d="M203.5,534.5 h148 v53 h-148 z" fill="#4A55A2" stroke="black" />
                <path id="SCIENTIA HALL 2" class="allPaths" d="M2.5,949.5 h485 v130 h-485 z" fill="#C5DFF8" stroke="black" />
                <path id="SCIENTIA HALL 1" class="allPaths" d="M488.5,949.5 h391 v130 h-391 z" fill="#7895CB" stroke="black" />
                <path id="STAIRS" class="allPaths" d="M880.5,949.5 h106 v130 h-106 z" fill="black" stroke="black" />
                <path id="COMFORT ROOMS" class="allPaths" d="M987.5,949.5 h94 v130 h-94 z" fill="#4A55A2" stroke="black" />
                <path id="CHS" class="allPaths" d="M880.5,732.5 h201 v125 h-201 z" fill="#E5D9F2" stroke="black" />
                <path id="SKILLS LAB" class="allPaths" d="M880.5,377.5 h201 v354 h-201 z" fill="#CDC1FF" stroke="black" />
                <path id="AMPHITHEATER" class="allPaths" d="M880.5,268.5 h201 v108 h-201 z" fill="#A594F9" stroke="black" />
                <path id="CHEMISTRY" class="allPaths" d="M880.5,0.5 h201 v123 h-201 z" fill="#86A789" stroke="black" />
                <path id="MICROBIOLOGY" class="allPaths" d="M667.5,0.5 h212 v123 h-212 z" fill="#739072" stroke="black" />
                <path id="PHYSICS" class="allPaths" d="M459.5,0.5 h207 v123 h-207 z" fill="#4F6F52" stroke="black" />
                <path id="ANATOMY" class="allPaths" d="M210.5,0.5 h248 v123 h-248 z" fill="#3F6142" stroke="black" />
                <path id="STAIRS_2" class="allPaths" d="M108.5,0.5 h101 v123 h-101 z" fill="black" stroke="black" />
                <path id="COMFORT ROOMS_2" class="allPaths" d="M2.5,0.5 h105 v123 h-105 z" fill="#4A55A2" stroke="black" />
                <path id="LECTURE ROOM" class="allPaths" d="M0.5,268.5 h202 v111 h-202 z" fill="#FFD0D0" stroke="black" />
                <path id="LECTURE ROOM_2" class="allPaths" d="M0.5,380.5 h202 v106 h-202 z" fill="#E1ACAC" stroke="black" />
                <path id="RESOURCES ROOM" class="allPaths" d="M0.5,487.5 h202 v137 h-202 z" fill="#CA8787" stroke="black" />
                <path id="OVPAA" class="allPaths" d="M0.5,625.5 h202 v232 h-202 z" fill="#835A5A" stroke="black" />
                <path id="OSP/HUDDLE" class="allPaths" d="M84.5,625.5 h118 v106 h-118 z" fill="#A87676" stroke="black" />
            
                <text x="540" y="550" font-size="24" fill="black" font-family="Arial" text-anchor="middle">
                    College Library
                </text>
                <text x="240" y="1020" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Scientia Hall 2
                </text>
                <text x="685" y="1020" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Scientia Hall 1
                </text>
                <text x="1032" y="1014" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    CR1
                </text>
                <text x="980" y="785" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    CHS
                </text>
                <text x="980" y="550" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Skills Lab
                </text>
                <text x="980" y="330" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Amphitheater
                </text>
                <text x="980" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Chemistry
                </text>
                <text x="775" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Microbiology
                </text>
                <text x="565" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Physics
                </text>
                <text x="335" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Anatomy
                </text>
                <text x="50" y="62" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    CR 2
                </text>
                <text x="100" y="335" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Lecture Room
                </text>
                <text x="100" y="445" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Lecture Room 2
                </text>
                <text x="100" y="570" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    Resources Room
                </text>
                <text x="100" y="770" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                    OVPAA 
                </text>
                <text x="145" y="680" font-size="16" fill="black" font-family="Arial" text-anchor="middle">
                OSP/Huddle
                </text>
                <g style="cursor: pointer;" onclick="showFloor(1)">
                    <image href="/img/1st.svg" x="1120" y="1000" width="60" height="60" />
                </g>
            </g>
        </svg>
    </div>

    <body class="report_details">
    <!-- <div class="d-flex justify-content-center align-items-center vh-100"> -->
    <button class="open-button" onclick="openForm()">new report</button>
    <div class="form-popup" id="myForm">
    	
   <form id="reportForm" class="form-container" action="php/rep.php" method="post" enctype="multipart/form-data">
            <div class="report">
    		<h1 class="display-4  fs-1">Report</h1><br>
            <label><p>Report here your concern.<p></label>
    		<?php if(isset($_GET['error'])){ ?>
    		<div class="alert alert-danger" role="alert">
			  <?php echo $_GET['error']; ?>
			</div>
		    <?php } ?>

		    <?php if(isset($_GET['success'])){ ?>
    		<div class="alert alert-success" role="alert">
			  <?php echo $_GET['success']; ?>
			</div>
		    <?php } ?>

            <div class="mb-3">
		    <label class="form-label">Name:</label>
		    <input type="text" 
		           class="form-control"
		           name="user"
		           value="<?php 
                                // Pre-fill with session data or allow user input
                                if (isset($_SESSION['fname']) && isset($_SESSION['lname'])) {
                                    echo htmlspecialchars($_SESSION['fname'] . ' ' . $_SESSION['lname']);
                                } elseif (isset($_SESSION['fname'])) {
                                    echo htmlspecialchars($_SESSION['fname']);
                                } else {
                                    echo '';
                                }
                           ?>">
		  </div>

		  <div class="report-title">
		    <label class="form-label">Title</label>
		    <input type="text" class="form-control" name="title"
		           value="<?php echo (isset($_GET['title']))?$_GET['title']:"" ?>">
		  </div>

		  <div class="mb-3">
    <label class="form-label">Enter Details:</label>
    <textarea rows="10" class="form-control" cols="40" name="details" placeholder="Write your details here..">
        <?php echo isset($_GET['details']) ? $_GET['details'] : ""; ?>
    </textarea>
</div>


		  <div class="report-type">
		    <label class="form-label">Type of Report</label>
		    <select id="reportType" name="type" class="form-control">
                            <option value="">Select Report Type</option>
                            <option value="caution">Caution</option>
                            <option value="cleaning">Cleaning</option>
                            <option value="electrical-hazard">Electrical Hazard</option>
                            <option value="it-maintenance">IT Maintenance</option>
                            <option value="repair">Repair</option>
                            <option value="request">Request</option>
                        </select>
		  </div>

		  <div class="mb-3">
		    <label class="form-label">Upload a file:</label>
		    <input type="file" 
		           class="form-control"
		           name="image">
		  </div>
		  <div class="date-picker-section">
                        <label for="reportDate" class="date-label">Report Date:</label>
                        <input type="date"  name="date" class="date-picker">
                    </div>
		  <button type="submit" class="btn btn-primary" id="submitButton" >Submit</button>
          <button type="button" class="btn cancel" id="cancelRequestButton">Cancel Request</button>

		</form>
    </div>
    
    <script src="js/studSidebar.js"></script>
    <script src="js/app.js"></script>
    <script src="js/submit.js"></script>

</body>

</html>