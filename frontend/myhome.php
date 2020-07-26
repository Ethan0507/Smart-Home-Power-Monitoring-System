<?php
    $conn = mysqli_connect('localhost','root','');
    mysqli_select_db($conn , 'IOT_test');
    

    if(isset($_POST['submit']))
    {
        $l = $_POST['led_limit'];
        $str = "insert into limit values ('LED','".$l."')";
        mysqli_query($conn, $str);
        echo "<script> close_limit() </script>";
    }
?>



<html>

    <head>
        <title>Welcome home</title>
        <link href="myhome.css" type='text/css' rel='stylesheet'>
    </head>

    <body >
        <div class='headerbar'>
            <h1>Home, Smart Home!</h1>
        </div>
        <div class ="sbody">

        <div class='container' align='center'>
        <div class='showbill'>
            <a href="javascript: open_current_bill()" class='showcurbill'>Current Bill</a>
            
        </div>

        <div class='curbill' id='curbill'>

            <?php $s = "select sum(Current) from tabulate"; $result = mysqli_query($conn , $s); $r = mysqli_fetch_assoc($result); $amps = $r['sum(Current)']; $bill = (($amps * 220) / 1000.0)*0.4;$unii = (($amps*220)/1000); echo "<h2>Total Units consumed: ".number_format((float)$unii, 2, '.', '')." units\n<h2>Rs. ".number_format((float)$bill, 2, '.', '')."</h2>"; ?>
            <a href='javascript: close_current_bill()' id='close'>Close</a>

        </div>
        </div>

        <div class = 'appcont'>
        <a href='javascript: open_device_info()' class='showdevinfo'>LED</a>
        
        <div class='applianceinfo' id='applianceinfo'>

            <div class='units'>
                <?php $s = "select sum(Current) from tabulate where sensor_id = 'LED'"; $result = mysqli_query($conn , $s); $r = mysqli_fetch_assoc($result); $amps = $r['sum(Current)']; $bill = (($amps * 220) / 1000.0)*0.4; $unii = (($amps*220)/1000); echo "<h2>Units consumed: ".number_format((float)$unii, 2, '.', '')." units\n<h2>Contribution to the bill by LED uptill now: Rs. ".number_format((float)$bill, 2, '.', '')."</h2>";?>
            </div>

            <div class='usage'>
                <?php  $s = "select @sdate := date_of_use , @stime := time_of_use from tabulate where flag_value = '2' and sensor_id = 'LED' order by time_of_use desc limit 1"; $result = mysqli_query($conn , $s); $r = mysqli_fetch_assoc($result); echo "<h3>The device was last turned on on: ".$r['@sdate := date_of_use']." at: ".$r['@stime := time_of_use'].".</h3>\n";
                $s = "select @edate := date_of_use , @etime := time_of_use , @fv := flag_value from tabulate where sensor_id = 'LED' order by time_of_use desc limit 1"; $result = mysqli_query($conn, $s); while ($r = mysqli_fetch_array($result)) { if($r['@fv := flag_value'] == '0') { echo "<h3>And turned off on :".$r['@edate := date_of_use']." at: ".$r['@etime := time_of_use'].".</h3>\n";} else { echo "<h3>And is still running...</h3>";}} 
                $s = "select val from limit where sensor_id = 'LED'"; $result = mysqli_query($conn, $s); $r = mysqli_fetch_assoc($result); $t = $r['val']; if($t != 0) { if ($t < $bill ) { echo "<h3>Limit reached: ".(($t/$bill)*100)."%</h3>"; } else { echo "</h3>You have exceeded your limit.</h3>";}} else { echo "<h3>Limit not set for this appliance.</h3>";} ?>
            </div>
            <a href='javascript: close_devinfo()' id='close'>Close</a>

        </div>
        <div class='appliances'>
            
            <div class='limit' id='limit'>
                <form method='post' onsubmit="return close_f()">
                    <input type='text' name='led_limit' placeholder='Set limit on this device' id='inpu'/>
                    <input type='submit' name='submits' id='submit'/>
                </form>
            </div>
        </div>
        </div>
        </div>



    </body>

    <script>
        function open_current_bill() {
			document.getElementById("curbill").style.display = "block";
		}

        function close_current_bill() {
			document.getElementById("curbill").style.display = "none";
		}

        function open_device_info() {
			document.getElementById("applianceinfo").style.display = "block";
		}

        function close_devinfo() {
			document.getElementById("applianceinfo").style.display = "none";
		}

        function close_limit() {
            document.getElementById("limit").style.display = "none";
        }

        function close_f() {
			document.getElementById("limit").style.display = "none";
            return false;
		}


    </script>
</html>

