<?php
session_start();
//error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
 

  <title>Emergancy Ambulance Hiring Portal || Tracking Page</title>


  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
  
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>

<body>

  <?php include_once('includes/header.php');?>

  <main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Ambulance Tracking</h2>
          <ol>
            <li><a href="index.php" href="#hero">Home</a></li>
            <li>Ambulance Tracking</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page">
      <div class="container">
       <?php
$id = $_GET['id'];   
$ret = mysqli_query($con, "SELECT tblambulancehiring.*,tblambulance.AmbRegNum, tblambulance.DriverName,tblambulance.DriverContactNumber FROM tblambulancehiring 
    left join tblambulance on tblambulance.AmbRegNum=tblambulancehiring.AmbulanceRegNo  WHERE tblambulancehiring.ID = '$id'");


while ($row = mysqli_fetch_array($ret)) {
   $arnum = $row['AmbulanceRegNo'];
?>
<table class="table table-bordered mg-b-0">
    <tr>
        <th colspan="6" style="font-size:20px;color:blue;text-align: center;">
            View Request Details of #<?php echo $row['BookingNumber']; ?></th>
        
    </tr>
    <tr>
        <th>Patient Name</th>
        <td><?php echo $row['PatientName']; ?></td>
        <th>Relative Name</th>
        <td><?php echo $row['RelativeName']; ?></td>
    </tr>
    <tr>
    <th>Relative Contact Number</th>
    <td><?php  echo $row['RelativeConNum'];?></td>
    <th>Hiring Date</th>
    <td><?php  echo $row['HiringDate'];?></td>
    
  </tr>
  <tr>
    <th>Hiring Time</th>
    <td><?php  echo $row['HiringTime'];?></td>
     <th>Booking Date</th>
     <td><?php  echo $row['BookingDate'];?></td>
     <tr>
        <tr>
    <th>Address</th>
    <td><?php  echo $row['Address'];?></td>
    <th>City</th>
    <td><?php  echo $row['City'];?></td>
  </tr>
   <tr>
    <th>State</th>
    <td><?php  echo $row['State'];?></td>
    <th>Message</th>
    <td><?php  echo $row['Message'];?></td>
  </tr>
    <!-- Display other request details -->

    <?php
    $atype = $row['AmbulanceType'];  
    $ambulanceTypeText = "";
    switch ($atype) {
        case "1":
            $ambulanceTypeText = "Basic Life Support (BLS) Ambulances";
            break;
        case "2":
            $ambulanceTypeText = "Advanced Life Support (ALS) Ambulances";
            break;
        case "3":
            $ambulanceTypeText = "Non-Emergency Patient Transport Ambulances";
            break;
        case "4":
            $ambulanceTypeText = "Boat Ambulance";
            break;
        default:
            $ambulanceTypeText = "Unknown";
            break;
    }
    ?>
    <tr>
        <th>Ambulance Type</th>
        <td colspan="3"><?php echo $ambulanceTypeText; ?></td>
    </tr>
    <!-- Display other request details -->

    <?php if ($row['Remark'] != ''): ?>
    <tr>
        <th>Remark</th>
        <td><?php echo $row['Remark']; ?></td>
        <?php if ($row['Status'] != ''): ?>
        <th>Status</th>
        <td><?php echo $row['Status']; ?></td>
        <?php endif; ?>
    </tr>
  
    </tr>
    <?php endif; ?>
     <?php if ($row['Status'] != ''){ ?>
    <tr>     
       <th>Driver Name</th>
        <td><?php echo $row['DriverName']; ?></td>
         <th>Driver Contact Number</th>
        <td><?php echo $row['DriverContactNumber']; ?></td>
      </tr>
 <?php }else {?>
  <tr>     
       <th>Driver Name</th>
        <td>Not Assigned Yet</td>
         <th>Driver Contact Number</th>
        <td>Not Assigned Yet</td>
      </tr><?php }?>
</table>

<?php
}
?>

<?php 
  $bookingnum=$_GET['bookingnum'];
$query1=mysqli_query($con,"SELECT Remark,Status,UpdationDate,BookingNumber,AmbulanceRegNum FROM tbltrackinghistory

    where BookingNumber='$bookingnum'");
$count=mysqli_num_rows($query1);
if($count>0){
     ?>
 <div class="col-12">
        <table class="table table-bordered" border="1" width="100%">
                                        <tr>
                                            <th colspan="6" style="text-align:center;">Tracking History</th>
                                        </tr>
                                        <tr>
                                            <th>Remark</th>
                                            <th>Status</th>
                                            <th>Ambulance Registration Number </th>
                                            <th>Action Date</th>
                                        </tr>
<?php 
while($row1=mysqli_fetch_array($query1))
{
?>  

<tr>
<td><?php echo htmlentities($row1['Remark']);?></td>
                 <td> <?php   $pstatus=$row1['Status'];  
                 if($pstatus==""){ ?>
<span>New</span>
 <?php } elseif($pstatus=="Assigned"){ ?>
<span>Assigned</span>
 <?php } elseif($pstatus=="On the way"){ ?>
<span>On the Way</span>
 <?php } elseif($pstatus=="Pickup"){ ?>
<span>Patient Pick</span>
 <?php } elseif($pstatus=="Reached"){ ?>
<span>Patient Reached Hospital</span>
 <?php } elseif($pstatus=="Rejected"){ ?>
<span>Rejected</span>

<?php } ?>
</td>
<td><?php echo htmlentities($row1['AmbulanceRegNum']);?></td>
<td><?php echo htmlentities($row1['UpdationDate']);?></td>
             
</tr>
<?php } ?>

</table>
<?php } ?>
      </div>
    </section>

  </main><!-- End #main -->
  <?php
// Fetch the home location from the database
$id = $_GET['id'];
$homeLocationQuery = mysqli_query($con, "SELECT Address, City, State FROM tblambulancehiring WHERE ID = '$id' LIMIT 1");
$homeLocation = mysqli_fetch_assoc($homeLocationQuery);

if ($homeLocation) {
    // Format the home address for geocoding
    $homeAddress = $homeLocation['Address'] . ', ' . $homeLocation['City'] . ', ' . $homeLocation['State'];
} else {
    $homeAddress = '';  // Fallback in case no address is found
}
?>
<h1 class="text-center">Live Ambulance Location</h1>
  
  <!-- Leaflet OpenStreetMap Integration -->
<div id="map" style="height: 500px; width: 100%;"></div>


<?php include_once('includes/footer.php');?><!-- Vendor JS Files -->
<script>
  let map, homeMarker, ambulanceMarker, ambulancePos, interval;

  function initMap() {
    const homeAddress = "<?php echo $homeAddress; ?>";

    // Use Nominatim API to geocode the home address
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${homeAddress}`)
      .then(response => response.json())
      .then(data => {
        if (data.length > 0) {
          const homeLat = parseFloat(data[0].lat);
          const homeLon = parseFloat(data[0].lon);
          const homePos = [homeLat, homeLon];

          // Initialize the map
          map = L.map('map').setView(homePos, 15);

          // Set up OpenStreetMap tiles
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
          }).addTo(map);



          // Marker for the home
          var homeIcon = L.icon({
            iconUrl: 'assets/icons/home.png', // Path to your ambulance icon
            iconSize: [32, 32], // Size of the icon
            iconAnchor: [20, 40], // Point of the icon which will correspond to marker's location
            popupAnchor: [0, -40] // Point from which the popup should open relative to the iconAnchor
          });

          // Marker for the ambulance using the custom ambulance icon
          homeMarker = L.marker(homePos, { icon: homeIcon })
            .addTo(map)
            .bindPopup('Home')
            .openPopup();

          // Start ambulance at a random location near the home
          ambulancePos = [
            homeLat + (Math.random() * 0.01 - 0.005), // Random lat near home
            homeLon + (Math.random() * 0.01 - 0.005), // Random lon near home
          ];

          // Marker for the ambulance
          var ambulanceIcon = L.icon({
            iconUrl: 'assets/icons/ambulance.png', // Path to your ambulance icon
            iconSize: [40, 40], // Size of the icon
            iconAnchor: [20, 40], // Point of the icon which will correspond to marker's location
            popupAnchor: [0, -40] // Point from which the popup should open relative to the iconAnchor
          });

          // Marker for the ambulance using the custom ambulance icon
          ambulanceMarker = L.marker(ambulancePos, { icon: ambulanceIcon })
            .addTo(map)
            .bindPopup('Ambulance');



          // Move the ambulance towards the home
          moveAmbulance(homePos);
        } else {
          alert('Home location not found.');
        }
      })
      .catch(error => console.log('Error:', error));
  }

  function moveAmbulance(homePos) {
    // Move the ambulance closer to the home every second
    interval = setInterval(() => {
      const stepLat = (homePos[0] - ambulancePos[0]) * 0.1;
      const stepLon = (homePos[1] - ambulancePos[1]) * 0.1;

      ambulancePos[0] += stepLat;
      ambulancePos[1] += stepLon;

      // Update the ambulance marker position
      ambulanceMarker.setLatLng(ambulancePos);

      // Stop the ambulance when it's close enough to the home
      if (Math.abs(homePos[0] - ambulancePos[0]) < 0.000001 && Math.abs(homePos[1] - ambulancePos[1]) < 0.000001) {
        clearInterval(interval);
      }
    }, 1000);
  }

  // Initialize the map when the page loads
  window.onload = initMap;
</script>

<!-- Load Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>