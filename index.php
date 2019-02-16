<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Intellipharm Report</title>
        
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <!-- Chart CDN-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script> 
        
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Custom styles for this template -->
        <link href="css/small-business.css" rel="stylesheet">
        
        <!--datatables-->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>  
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
        
    </head>
    <body>
        <?php
       
           include 'config.php';
            
           //Create dynamic JSON file
           $sql = $mysqli->query("select * from members order by id desc");

           //JSON array declaration
           $members = array();

           while ($row = mysqli_fetch_assoc($sql)) {
                //$members = $row ;
                $members[] = array (
                    "firstname" => $row['firstname'],
                    "surname" => $row['surname'],
                    "email" => $row['email'],
                    "gender"=> $row['gender'],
                    "joined_date"=> $row['joined_date']
                );
           }
            json_encode($members);
            $file_name = 'members.json';

        //Get Year list
        $sql_year = "SELECT DISTINCT YEAR(`joined_date`) as Year FROM `members` GROUP BY YEAR(`joined_date`)";
        $result_year = $mysqli->query($sql_year);

        //Number of sign-ups each year 
        $sql_signup_per_year = "SELECT YEAR(`joined_date`) as Year,COUNT(`joined_date`) as NewSignUps FROM `members` GROUP BY YEAR(`joined_date`)";
        $result_yearly_signup = $mysqli->query($sql_signup_per_year);
       
        ?>
        
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Intellipharm Report</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a>Report Generator</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container">
                <?php 
                //Number of sign-ups each month per year
                
                if(isset($_POST['selectyear'])){
                    $selected_year = $_POST['selectyear'];
                } else {
                    $selected_year = 2014;
                }
                
                $sql_signup_per_month = "SELECT MONTH(`joined_date`) as Month,COUNT(`joined_date`) as NewSignUps FROM `members` WHERE YEAR(`joined_date`) = '".$selected_year."' GROUP BY MONTH(`joined_date`)";
                $result_monthly_signup = $mysqli->query($sql_signup_per_month);
               
                ?>
                 <br/><br/>
                <div class="col-md-12" id="results">
                    <h4>Reports</h4>
                    <div class="row my-4">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST">
                                <fieldset>
                                    <!-- Select Basic -->
                                    <div class="form-group">
                                        <h5>Select year and generate 'Monthly Customer Sign-ups' report</h5>
                                        <div class="row col-md-12 well">
                                            <table border="0" cellpadding="10" width="100%">
                                                <tr>
                                                    <td width="25%">
                                                        <div class="col-md-12">
                                                            <select id="selectyear" name="selectyear" class="form-control">
                                                                <option value="2014">-- SELECT YEAR --</option>
                                                                <?php
                                                                while ($row = $result_year->fetch_array()) {
                                                                    echo "<option id=\"{$row['Year']}\" value=\"{$row['Year']}\">";
                                                                    echo $row['Year'];
                                                                    echo "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <!-- Button -->
                                                    <td width="25%">
                                                        <button type="submit" name="generate" class="btn btn-primary" onclick="showDiv()">Generate Report</button>
                                                    </td>
                                                </tr>
                                                <script type="text/javascript">
                                                    function showDiv() {
                                                        document.getElementById('table').style.display = "block";
                                                        $('html,body').animate({scrollTop: $("#result_table").offset().top},'slow');

                                                    }

                                                    function showResults(){
                                                        document.getElementById('results').style.display = "block";
                                                    }
                                                </script>
                                            </table>   
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <h5>Monthly sign-ups for the year <?php echo $selected_year;?></h5>
                    <br/>
                    <table border='1' id="result_table" width="100%">
                        <tr>
                            <th>Month</th>
                            <th>New Sign-ups</th>
                        </tr>
                        <?php while ($row = $result_monthly_signup->fetch_array()){ ?>
                        <tr>
                            <td>
                                <?php 
                                switch ($row['Month']) {
                                    case 1:
                                        echo "January";
                                        break;
                                    case 2:
                                        echo "February";
                                        break;
                                    case 3:
                                        echo "March";
                                        break;
                                    case 4:
                                        echo "April";
                                        break;
                                    case 5:
                                        echo "May";
                                        break;
                                    case 6:
                                        echo "June";
                                        break;
                                    case 7:
                                        echo "July";
                                        break;
                                    case 8:
                                        echo "Auguest";
                                        break;
                                    case 9:
                                        echo "September";
                                        break;
                                    case 10:
                                        echo "October";
                                        break;
                                    case 11:
                                        echo "November";
                                        break;
                                    case 12:
                                        echo "December";
                                        break;
                                    default:
                                        echo "January";
                                }
                                    
                                ?>
                            </td>
                            <td><?php echo $row['NewSignUps'] ?></td>
                        </tr>
                        <?php }?>
                    </table>
                    </br>
                </div>

        </div>
        <!-- /.container -->
        <div class="container">
            <div class="col-md-12">
                <br/><br/>
                <h4>This graph shows the number of customer sign-ups for year</h4>
                
                </br>
                <?php include_once './linegraph.html'; ?>
            </div>
            
            <div class="table-responsive">
                <br/><br/>
                <h4>Get JSON data and create HTML table using Ajax ,Jquery</h4>
                <p>You can use search option to filter results by 'first name', 'surname', 'email' and 'joined date'. Also you can sort table using column filters.</p>
                <br/>
                <table class="table table-bordered table-striped" id="employee_table">
                    <thead>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Joined Date</th>
                    </thead>
                </table>
            </div>
        </div>
         <script>
            //Generate table using json data.
            $(document).ready(function() {
                var result = (function () {
                var json = null;
                    $.ajax({
                        'async': false,
                        'global': false,
                        'url': "members.json",
                        'dataType': "json",
                        'success': function (data) {
                            json = data;
                        }
                    });
                    return json;
                })(); 
                    $('#employee_table').dataTable( {
                    columns : [
                        {data: "firstname"},
                        {data: "surname"},
                        {data: "email"},
                        {data: "gender"},
                        {data: "joined_date"}
                        ],
                          data: result
                    } );
                    
                    $(document).ready(function() {
                        $('#result_table').DataTable();
                    } );

            });
         </script>
 
        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Lisanka Nagahatenna 2019</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->

    </body>

</html>
