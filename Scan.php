<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>BeatBlast-Scanner</title>
  <style>
          body {
            background: #ff5518 !important;
          }
          #reader__scan_region {
            background: #ff5518 !important;
          }

          h1 {
            text-align: center;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
          }

          #reader {
            width: 95vw;
            border: 0px !important;
          }

          .btn{
            background-color: #1d1d1f;
            font-family: "Source Sans Pro", sans-serif;
            color: #f5f5f7;
            text-align: center;
            margin-top: 13px;
            font-size: 2vh;
            border-radius: 50px;
            padding-left: 5vh;
            padding-right: 5vh;
            padding-top: 1.3vh;
            padding-bottom: 1.3vh;
            border: 1px solid #1d1d1f;
            transition: ease-in 0.2s;
          }
          .btn2{
            background-color: #1d1d1f;
            font-family: "Source Sans Pro", sans-serif;
            color: #f5f5f7;
            text-align: center;
            margin-top: 13px;
            font-size: 2vh;
            border-radius: 50px;
            padding-left: 5vh;
            padding-right: 5vh;
            padding-top: 1.3vh;
            padding-bottom: 1.3vh;
            border: 1px solid #1d1d1f;
            transition: ease-in 0.2s;
            width:30vw;
            align-self: center;
          }

          #reader button {
            background-color: #1d1d1f;
            font-family: "Source Sans Pro", sans-serif;
            color: #f5f5f7;
            text-align: center;
            margin-top: 13px;
            font-size: 2vh;
            border-radius: 50px;
            padding-left: 5vh;
            padding-right: 5vh;
            padding-top: 1.3vh;
            padding-bottom: 1.3vh;
            border: 1px solid #1d1d1f;
            transition: ease-in 0.2s;
          }

          .input {
            border-radius: 10px;
            outline: 2px solid #FEBF00;
            border: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: #e2e2e2;
            outline-offset: 3px;
            padding: 10px 1rem;
            transition: 0.25s;
          }
          .result {
            background-color: green;
            color: #fff;
            padding: 20px;
          }
          
          #result{
            margin-top:30px;
            margin-bottom:30px;
          }

          .container {
            display: flex;
            flex-direction: column;
            width: 95vw;
          }

          .col {
            width: 95vw;
          }

          #reader__scan_region {
            background: white;
          }

          #reader__dashboard_section_swaplink {
            display: none !important;
          }

          .col.text {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* text-align: center;  */
            font-family: Verdana, Geneva, Tahoma, sans-serif;
          }

          form{
            display:flex;
            flex-direction:column;
            width:60vw;
            align-self: center;
            margin-top: 50px;
          }
          
          .red{
            color:red;
          }

  </style>
</head>

<body>
  <!-- partial:index.partial.html -->
  <h1>Beat Blast</h1>

  <!-- QR SCANNER CODE BELOW  -->
  <div class="container">
    <div class="col">
      <div id="reader"></div>
    </div>
    <div class="col text">
      <div id="result">
      </div>
    </div>
    <button id="t" class="btn2">Check</button>
    <form action="">
      <input type="text" name="ticketname" class="input" id="inputtext" readonly>
      <button type="submit" class="btn">save</button>
    </form>




  </div>

  <?php
if (isset($_GET["ticketname"])) {
    $ticketname = $_GET['ticketname'];
    $servername = "localhost";
    $username = "u803788286_amanmehta";
    $password = "Amanmehta258";
    $dbname = "u803788286_beatblast";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sqla = "SELECT * FROM ticket2023 WHERE TId = '$ticketname'";
    $result = mysqli_query($conn, $sqla);
    $check = mysqli_fetch_array($result);

    if (isset($check)) {
        if ($ticketname != "" && $result->num_rows > 0) {
            $sqlCheckAvailability = "SELECT Availability FROM ticket2023 WHERE TId = '$ticketname'";
            $resultCheckAvailability = mysqli_query($conn, $sqlCheckAvailability);
            $rowCheckAvailability = mysqli_fetch_assoc($resultCheckAvailability);
            
            if ($rowCheckAvailability['Availability'] == 'Used') {
              echo "<h1 class='red'>Ticket Already Used</h1>";
              // header("Refresh:0; url=scan.php");
              $conn->close();
            } 
            else if($rowCheckAvailability['Availability'] == 'Available') {
              $sql = "UPDATE ticket2023 
                      SET 
                      Availability = 'Used'
                      WHERE
                      TId = '$ticketname';";
              $result = $conn->query($sql);
              $conn->close();

              header("Refresh:0; url=Scan.php");
              
            }
            else{
              echo "<h1 class='red'>There is some error</h1>";
              $conn->close();
            }

        }
    }
}
?>

  <!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.2.0/html5-qrcode.min.js'></script>
  <script>
    var tButton = document.getElementById("t");
    var txt = document.getElementById("inputtext");
          
    tButton.addEventListener("click", function () {
      var resultElement = document.querySelector(".result")
      var variable=resultElement.textContent;
      document.getElementById("inputtext").value = variable;

      console.log(variable);
    });

  </script>
  <script src="js/scan_script.js"></script>

</body>

</html>