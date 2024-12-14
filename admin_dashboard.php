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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
</head>

<body id="body">


 <div id="slidingColumn">
    <span id="fixFinderTitle">FixFinder</span>
    <div id="fixFinderContainer"> </div>
        <button id="closeButton">Close</button>
        <div id="pins"></div> 
    
<!-- Pin Icons -->
<div class="hoverable-container" style="position: absolute; top: 80px; right: 90px;" onmouseover="showIcon('cautionIcon')" onmouseout="hideIcon('cautionIcon')">
    <div class="icon-background" style="background-image: url('img/Caution_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="cautionIcon" 
        src="img/Caution_shadow.png" 
        alt="Caution Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="cautionIcon"
        data-dragging-image="img/Caution_noshadow.png"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Hazard Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 150px; right: 80px;" onmouseover="showIcon('cleaningIcon')" onmouseout="hideIcon('cleaningIcon')">
    <div class="icon-background" style="background-image: url('img/Cleaning_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="cleaningIcon" 
        src="img/Cleaning_shadow.png" 
        alt="Cleaning Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="cleaningIcon"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Cleaning Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 220px; right: 80px;" onmouseover="showIcon('electricalIcon')" onmouseout="hideIcon('electricalIcon')">
    <div class="icon-background" style="background-image: url('img/Electrical Hazard_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="electricalIcon" 
        src="img/Electrical Hazard_shadow.png" 
        alt="Electrical Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="electricalIcon"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Electrical Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 290px; right: 43px;" onmouseover="showIcon('itIcon')" onmouseout="hideIcon('itIcon')">
    <div class="icon-background" style="background-image: url('img/IT Maintenance_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="itIcon" 
        src="img/IT Maintenance_shadow.png" 
        alt="IT Maintenance Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="itIcon"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">IT Maintenance Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 360px; right: 95px;" onmouseover="showIcon('repairIcon')" onmouseout="hideIcon('repairIcon')">
    <div class="icon-background" style="background-image: url('img/Repair_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="repairIcon" 
        src="img/Repair_shadow.png" 
        alt="Repair Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="repairIcon"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Repair Pin</span>
</div>

<div class="hoverable-container" style="position: absolute; top: 430px; right: 85px;" onmouseover="showIcon('requestIcon')" onmouseout="hideIcon('requestIcon')">
    <div class="icon-background" style="background-image: url('img/Request_symbol.png'); width: 45px; height: 45px; background-size: cover; position: absolute; opacity: 1;"></div>
    <img 
        id="requestIcon" 
        src="img/Request_shadow.png" 
        alt="Request Pin" 
        style="width: 45px; height: auto; cursor: pointer; margin: 10px; z-index: 20; opacity: 0;" 
        data-pin-type="requestIcon"
    />
    <span style="font-size: 13px; color: #ffffff; cursor: pointer;">Request Pin</span>
</div> 

<script>
    function showIcon(iconId) {
        document.getElementById(iconId).style.opacity = "1"; // Show the icon
        document.querySelector(`#${iconId}`).previousElementSibling.style.opacity = "0"; // Hide the background
    }

    function hideIcon(iconId) {
        document.getElementById(iconId).style.opacity = "0"; // Hide the icon
        document.querySelector(`#${iconId}`).previousElementSibling.style.opacity = "1"; // Show the background
    }
</script>

        
        <!-- The Confirm Button will appear when a pin is selected -->
        <button id="confirmButton" style="display: none;" onclick="confirmPin()">Confirm</button>
    </div> 

    <button id="toggleOpacityButton">Pallete View</button>

        <!-- Modal for floor change message -->

        <div id="floorChangeModal" style="display: none;">
            <div id="modalContent">
                <p id="floorMessage"></p>
            </div>
        </div>

    <!-- Map Section -->

    <div id="hoveredIdContainer">
	<span id="hoveredId">MAP NAME</span>
    </div>

    <span id="pinIDClicked">Pin ID</span>

  
    <div id="mapContainer">
        <div id="sidebar-container"></div>

        <svg width="1080" height="1080" viewBox="0 0 1080 1080" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- First Floor -->
            <g id="firstFloor">
                <!-- College Library -->
                <image href="img/Library.png" class= map_photo x="349.5" y="267.5" width="380" height="584" opacity="1" />
                <path id="COLLEGE LIBRARY" class="allPaths" d="M349.5 267.5 H729.5 V851.5 H349.5 Z" fill="#4A55A2" stroke="black" />

                 <!-- College Library 2 -->
                 <image href="img/LibraryWay.png" class= map_photo x="203.5" y="534.5" width="148" height="53" opacity="1" />
                <path id="COLLEGE LIBRARY_2" class="allPaths" d="M203.5,534.5 h148 v53 h-148 z" fill="#4A55A2" stroke="black" />

                <!-- St. Carlo Acutis Chapel -->
                <image href="img/Chapel.png" class= map_photo x="0.5" y="267.5" width="202" height="111" opacity="1" />
                <path id="ST. CARLO ACUTIS CHAPEL" class="allPaths" d="M0.5 267.5 H202.5 V378.5 H0.5 Z" fill="#FFD0D0" stroke="black" />

                <!-- Arete Hall -->
                <image href="img/Arete.png" class= map_photo x="0.5" y="379.5" width="202" height="106" opacity="1" />
                <path id="ARETE HALL" class="allPaths" d="M0.5 379.5 H202.5 V485.5 H0.5 Z" fill="#E1ACAC" stroke="black" />

                <!-- Discussion Room -->
                <image href="img/Discussion.png" class= map_photo x="0.5" y="486.5" width="202" height="98" opacity="1" />
                <path id="DISCUSSION ROOM" class="allPaths" d="M0.5 486.5 H202.5 V584.5 H0.5 Z" fill="#CA8787" stroke="black" />

                <!-- Credo -->
                <image href="img/Credo.png" class= map_photo x="0.5" y="585.5" width="202" height="94" opacity="1" />
                <path id="CREDO" class="allPaths" d="M0.5 585.5 H202.5 V679.5 H0.5 Z" fill="#A87676" stroke="black" />

                <!-- Cafeteria -->
                <image href="img/Cafe.png" class= map_photo x="0.5" y="680.5" width="202" height="176" opacity="1" />
                <path id="CAFETERIA" class="allPaths" d="M0.5 680.5 H202.5 V856.5 H0.5 Z" fill="#835A5A" stroke="black" />

                <!-- Clinic -->
                <image href="img/Clinic.png" class= map_photo x="136.5" y="949.5" width="208" height="130" opacity="1" />
                <path id="CLINIC" class="allPaths" d="M136.5 949.5 H344.5 V1079.5 H136.5 Z" fill="#C5DFF8" stroke="black" />

                <!-- Guidance -->
                <image href="img/Guidance.png" class= map_photo x="345.5" y="949.5" width="87" height="130" opacity="1" />
                <path id="GUIDANCE" class="allPaths" d="M345.5 949.5 H432.5 V1079.5 H345.5 Z" fill="#A0BFE0" stroke="black" />

                <!-- Psych Lab -->
                <image href="img/Psych.png" class= map_photo x="671.5" y="949.5" width="206" height="130" opacity="1" />
                <path id="PSYCH LAB" class="allPaths" d="M671.5 949.5 H877.5 V1079.5 H671.5 Z" fill="#7895CB" stroke="black" />

                <!-- Stairs -->
                <image href="img/Stair.png" class= map_photo x="878.5" y="949.5" width="106" height="130" opacity="1" />
                <path id="STAIRS" class="allPaths" d="M878.5 949.5 H984.5 V1079.5 H878.5 Z" fill="black" stroke="black" />

                <!-- Comfort Rooms -->
                <image href="img/CR1.png" class= map_photo x="985.5" y="949.5" width="94" height="130" opacity="1" />
                <path id="COMFORT ROOMS" class="allPaths" d="M985.5 949.5 H1079.5 V1079.5 H985.5 Z" fill="#4A55A2" stroke="black" />

                <!-- EdTech -->
                <image href="img/Edtech.png" class= map_photo x="878.5" y="770.5" width="206" height="88" opacity="1" />
                <path id="EDTECH" class="allPaths" d="M878.5 770.5 H1079.5 V858.5 H878.5 Z" fill="#F5EFFF" stroke="black" />

                <!-- Sandbox -->
                <image href="img/SandBox.png" class= map_photo x="878.5" y="681.5" width="201" height="88" opacity="1" />
                <path id="SANDBOX" class="allPaths" d="M878.5 681.5 H1079.5 V769.5 H878.5 Z" fill="#E5D9F2" stroke="black" />

                <!-- Nexus -->
                <image href="img/Nexus.png" class= map_photo x="878.5" y="486.5" width="201" height="194" opacity="1" />
                <path id="NEXUS" class="allPaths" d="M878.5 486.5 H1079.5 V680.5 H878.5 Z" fill="#CDC1FF" stroke="black" />

                <!-- Inspire / Robotics -->
                <image href="img/Robotics.png" class= map_photo x="878.5" y="267.5" width="201" height="218" opacity="1" />
                <path id="INSPIRE / ROBOTICS" class="allPaths" d="M878.5 267.5 H1079.5 V485.5 H878.5 Z" fill="#A594F9" stroke="black" />

                <!-- Simulation Room -->
                <image href="img/Simulation.png" class= map_photo x="878.5" y="0.5" width="201" height="123" opacity="1" />
                <path id="SIMULATION ROOM" class="allPaths" d="M878.5 0.5 H1079.5 V123.5 H878.5 Z" fill="#D2E3C8" stroke="black" />

                <!-- Lecture Room 4 -->
                <image href="img/Lecture Room 4.png" class= map_photo x="666.5" y="0.5" width="211" height="123" opacity="1" />
                <path id="LECTURE ROOM 4" class="allPaths" d="M666.5 0.5 H877.5 V123.5 H666.5 Z" fill="#86A789" stroke="black" />

                <!-- Lecture Room 5 -->
                <image href="img/Lecture Room 5.png" class= map_photo x="454.5" y="0.5" width="211" height="123" opacity="1" />
                <path id="LECTURE ROOM 5" class="allPaths" d="M454.5 0.5 H665.5 V123.5 H454.5 Z" fill="#739072" stroke="black" />

                <!-- Lecture Room 6 -->
                <image href="img/Lecture Room 6.png" class= map_photo x="250.5" y="0.5" width="203" height="123" opacity="1" />
                <path id="LECTURE ROOM 6" class="allPaths" d="M250.5 0.5 H453.5 V123.5 H250.5 Z" fill="#4F6F52" stroke="black" />

                <!-- Server 3 Room -->
                <image href="img/Server 3.png" class= map_photo x="166.5" y="0.5" width="83" height="123" opacity="1" />
                <path id="SERVER 3 ROOM" class="allPaths" d="M166.5 0.5 H249.5 V123.5 H166.5 Z" fill="#3F6142" stroke="black" />

                <!-- Stairs 2 -->
                <image href="img/Stair3.png" class= map_photo x="83.5" y="0.5" width="82" height="123" opacity="1" />
                <path id="STAIRS_2" class="allPaths" d="M83.5 0.5 H165.5 V123.5 H83.5 Z" fill="black" stroke="black" />

                <!-- Comfort Rooms 2 -->
                <image href="img/CR2.png" class= map_photo x="0.5" y="0.5" width="82" height="123" opacity="1" />
                <path id="COMFORT ROOMS 2" class="allPaths" d="M0.5 0.5 H82.5 V123.5 H0.5 Z" fill="#4A55A2" stroke="black" />

<text x="540" y="540" font-size="24" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    College Library
</text>
<text x="540" y="540" font-size="24" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    College Library
</text>

<text x="101" y="325" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    St. Carlo Acutis Chapel
</text>
<text x="101" y="325" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    St. Carlo Acutis Chapel
</text>

<text x="101" y="432" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Arete Hall
</text>
<text x="101" y="432" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Arete Hall
</text>

<text x="101" y="535" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Discussion Room
</text>
<text x="101" y="535" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Discussion Room
</text>

<text x="101" y="635" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Credo
</text>
<text x="101" y="635" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Credo
</text>

<text x="101" y="768" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Cafeteria
</text>
<text x="101" y="768" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Cafeteria
</text>

<text x="240" y="1014" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Clinic
</text>
<text x="240" y="1014" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Clinic
</text>

<text x="389" y="1014" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Guidance
</text>
<text x="389" y="1014" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Guidance
</text>

<text x="774" y="1014" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Psych Lab
</text>
<text x="774" y="1014" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Psych Lab
</text>

<text x="1032" y="1014" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    CR
</text>
<text x="1032" y="1014" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    CR
</text>

<text x="978" y="817" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    EdTech
</text>
<text x="978" y="817" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    EdTech
</text>

<text x="978" y="725" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Sandbox
</text>
<text x="978" y="725" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Sandbox
</text>

<text x="978" y="583" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Nexus
</text>
<text x="978" y="583" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Nexus
</text>

<text x="978" y="376" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Inspire / Robotics
</text>
<text x="978" y="376" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Inspire / Robotics
</text>

<text x="978" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Simulation Room
</text>
<text x="978" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Simulation Room
</text>

<text x="772" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Lecture Room 4
</text>
<text x="772" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Lecture Room 4
</text>

<text x="560" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Lecture Room 5
</text>
<text x="560" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Lecture Room 5
</text>

<text x="352" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    Lecture Room 6
</text>
<text x="352" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    Lecture Room 6
</text>

<text x="208" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    <tspan x="208" dy="0">Server</tspan>
    <tspan x="208" dy="1.2em">3 Room</tspan>
</text>
<text x="208" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    <tspan x="208" dy="0">Server</tspan>
    <tspan x="208" dy="1.2em">3 Room</tspan>
</text>

<text x="41" y="62" font-size="18" fill="black" font-family="Arial" stroke=#D3D3D3 stroke-width="6" text-anchor="middle">
    CR 2
</text>
<text x="41" y="62" font-size="18" fill="black" font-family="Arial" stroke="black" stroke-width="1.5" text-anchor="middle">
    CR 2
</text>


                <g style="cursor: pointer;" onclick="showFloor(2)">
                <image href="/img/2nd.svg" class = changefloorbutton x="1120" y="1000" width="60" height="60" />
                </g>
            </g>

            <!-- Second Floor -->
            <g id="secondFloor">
                <!-- College Library -->
                <image href="img/Library-2ndfloor.png" class= map_photo x="352.5" y="268.5" width="380" height="584" opacity="1" />
                <path id="COLLEGE LIBRARY" class="allPaths" d="M352.5,268.5 h380 v584 h-380 z" fill="#4A55A2" stroke="black" />
                
                <!-- College Library 2 -->
                <image href="img/LibraryWay-2ndfloor.png" class= map_photo x="203.5" y="534.5" width="148" height="53" opacity="1" />
                <path id="COLLEGE LIBRARY_2" class="allPaths" d="M203.5,534.5 h148 v53 h-148 z" fill="#4A55A2" stroke="black" />

                <!-- Scientia Hall 2 -->
                <image href="img/Scientia 2.png" class= map_photo x="2.5" y="949.5" width="485" height="130" opacity="1" />
                <path id="SCIENTIA HALL 2" class="allPaths" d="M2.5,949.5 h485 v130 h-485 z" fill="#C5DFF8" stroke="black" />
                
                <!-- Scientia Hall 1 -->
                <image href="img/Scientia 1.png" class= map_photo x="488.5" y="949.5" width="391" height="130" opacity="1" />
                <path id="SCIENTIA HALL 1" class="allPaths" d="M488.5,949.5 h391 v130 h-391 z" fill="#7895CB" stroke="black" />
                
                <!-- Stairs -->
                <image href="img/Stair.png" class= map_photo x="880.5" y="949.5" width="106" height="130" opacity="1" />
                <path id="STAIRS" class="allPaths" d="M880.5,949.5 h106 v130 h-106 z" fill="black" stroke="black" />
                
                <!-- Comfort Rooms -->
                <image href="img/CR1.png" class= map_photo x="987.5" y="949.5" width="94" height="130" opacity="1" />
                <path id="COMFORT ROOMS" class="allPaths" d="M987.5,949.5 h94 v130 h-94 z" fill="#4A55A2" stroke="black" />
                
                <!-- CHS -->
                <image href="img/CHS.png" class= map_photo x="880.5" y="732.5" width="201" height="125" opacity="1" />
                <path id="CHS" class="allPaths" d="M880.5,732.5 h201 v125 h-201 z" fill="#E5D9F2" stroke="black" />
                
                <!-- Skills Lab -->
                <image href="img/Skills.png" class= map_photo x="880.5" y="377.5" width="201" height="354" opacity="1" />
                <path id="SKILLS LAB" class="allPaths" d="M880.5,377.5 h201 v354 h-201 z" fill="#CDC1FF" stroke="black" />
                
                <!-- Amphitheater -->
                <image href="img/Ampitheater.png" class= map_photo x="880.5" y="268.5" width="201" height="108" opacity="1" />
                <path id="AMPHITHEATER" class="allPaths" d="M880.5,268.5 h201 v108 h-201 z" fill="#A594F9" stroke="black" />
                
                <!-- Chemistry -->
                <image href="img/Chem-2ndfloor.png" class= map_photo x="880.5" y="0.5" width="201" height="123" opacity="1" />
                <path id="CHEMISTRY" class="allPaths" d="M880.5,0.5 h201 v123 h-201 z" fill="#86A789" stroke="black" />
                
                <!-- Microbiology -->
                <image href="img/Micro-2ndfloor.png" class= map_photo x="667.5" y="0.5" width="212" height="123" opacity="1" />
                <path id="MICROBIOLOGY" class="allPaths" d="M667.5,0.5 h212 v123 h-212 z" fill="#739072" stroke="black" />
                
                <!-- Physics -->
                <image href="img/Physics-2ndfloor.png" class= map_photo x="459.5" y="0.5" width="207" height="123" opacity="1" />
                <path id="PHYSICS" class="allPaths" d="M459.5,0.5 h207 v123 h-207 z" fill="#4F6F52" stroke="black" />
                
                <!-- Anatomy -->
                <image href="img/Anatomy-2ndfloor.png" class= map_photo x="210.5" y="0.5" width="248" height="123" opacity="1" />
                <path id="ANATOMY" class="allPaths" d="M210.5,0.5 h248 v123 h-248 z" fill="#3F6142" stroke="black" />
                
                <!-- Stairs 2 -->
                <image href="img/Stair2.png" class= map_photo x="108.5" y="0.5" width="101" height="123" opacity="1" />
                <path id="STAIRS_2" class="allPaths" d="M108.5,0.5 h101 v123 h-101 z" fill="black" stroke="black" />
                
                <!-- Comfort Rooms 2 -->
                <image href="img/CR2-2ndfloor.png" class= map_photo x="2.5" y="0.5" width="105" height="123" opacity="1" />
                <path id="COMFORT ROOMS_2" class="allPaths" d="M2.5,0.5 h105 v123 h-105 z" fill="#4A55A2" stroke="black" />
                
                <!-- Lecture Room -->
                <image href="img/Lecture_Room-2ndfloor.png" class= map_photo x="0.5" y="268.5" width="202" height="111" opacity="1" />
                <path id="LECTURE ROOM" class="allPaths" d="M0.5,268.5 h202 v111 h-202 z" fill="#FFD0D0" stroke="black" />
                
                <!-- Lecture Room 2 -->
                <image href="img/Lecture_Room 2-2ndfloor.png" class= map_photo x="0.5" y="380.5" width="202" height="106" opacity="1" />
                <path id="LECTURE ROOM_2" class="allPaths" d="M0.5,380.5 h202 v106 h-202 z" fill="#E1ACAC" stroke="black" />
                
                <!-- Resources Room -->
                <image href="img/Resources.png" class= map_photo x="0.5" y="487.5" width="202" height="137" opacity="1" />
                <path id="RESOURCES ROOM" class="allPaths" d="M0.5,487.5 h202 v137 h-202 z" fill="#CA8787" stroke="black" />
                
                <!-- OVPAA -->
                <image href="img/OVPA.png" class= map_photo x="0.5" y="625.5" width="202" height="232" opacity="1" />
                <path id="OVPAA" class="allPaths" d="M0.5,625.5 h202 v232 h-202 z" fill="#835A5A" stroke="black" />
                
                <!-- OSP/Huddle -->
                <image href="img/Huddle.png" class= map_photo x="84.5" y="625.5" width="118" height="106" opacity="1" />
                <path id="OSP/HUDDLE" class="allPaths" d="M84.5,625.5 h118 v106 h-118 z" fill="#A87676" stroke="black" />

            
<text x="540" y="550" font-size="24" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    College Library
</text>
<text x="540" y="550" font-size="24" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    College Library
</text>

<text x="240" y="1020" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Scientia Hall 2
</text>
<text x="240" y="1020" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Scientia Hall 2
</text>

<text x="685" y="1020" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Scientia Hall 1
</text>
<text x="685" y="1020" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Scientia Hall 1
</text>

<text x="1032" y="1014" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    CR1
</text>
<text x="1032" y="1014" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    CR1
</text>

<text x="980" y="785" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    CHS
</text>
<text x="980" y="785" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    CHS
</text>

<text x="980" y="550" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Skills Lab
</text>
<text x="980" y="550" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Skills Lab
</text>

<text x="980" y="330" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Amphitheater
</text>
<text x="980" y="330" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Amphitheater
</text>

<text x="980" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Chemistry
</text>
<text x="980" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Chemistry
</text>

<text x="775" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Microbiology
</text>
<text x="775" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Microbiology
</text>

<text x="565" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Physics
</text>
<text x="565" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Physics
</text>

<text x="335" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Anatomy
</text>
<text x="335" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Anatomy
</text>

<text x="50" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    CR 2
</text>
<text x="50" y="62" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    CR 2
</text>

<text x="100" y="335" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Lecture Room
</text>
<text x="100" y="335" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Lecture Room
</text>

<text x="100" y="445" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Lecture Room 2
</text>
<text x="100" y="445" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Lecture Room 2
</text>

<text x="100" y="570" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    Resources Room
</text>
<text x="100" y="570" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    Resources Room
</text>

<text x="100" y="770" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    OVPAA
</text>
<text x="100" y="770" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    OVPAA
</text>

<text x="145" y="680" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke=#D3D3D3 stroke-width="6" paint-order="stroke fill">
    OSP/Huddle
</text>
<text x="145" y="680" font-size="18" fill="black" font-family="Arial" text-anchor="middle" stroke="black" stroke-width="1.5" paint-order="stroke fill">
    OSP/Huddle
</text>


                <g style="cursor: pointer;" onclick="showFloor(1)">
                <image href="/img/1st.svg" class = changefloorbutton x="1120" y="1000" width="60" height="60" />
                </g>
            </g>
        </svg>
    </div>

<script>
    function loadFromDatabase() {
    fetch('save_to_localstorage.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                // Store data from the DB into localStorage
                localStorage.setItem(item.key, JSON.stringify(item.value)); // item.value is now an object, no extra encoding needed
            });
            renderLocalStorage(); // Re-render the table with new data
        })
        .catch(error => {
            console.error('Error loading data from database:', error);
        });
}

// Call the function as soon as the page loads
document.addEventListener('DOMContentLoaded', function() {
    loadFromDatabase();
});
</script>

    <script src="js/adminSidebar.js"></script>
    <script src="js/app.js"></script>
    <script src="js/toggle_button.js"></script>
    <script src="js/hover_svg.js"></script>
    <script src="js/zone.js"></script>
    <script src="js/fetch_pin.js"></script>
</body>

</html>
