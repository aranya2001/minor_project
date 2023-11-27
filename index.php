<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
}

$email = $_SESSION["user"];
require "database.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:100,300,400,600" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <title>Income Expense Tracker</title>
        <link rel ="icon" type="image/png" href="images/favicon.jpg">
    </head>
    <body>
        <?php
            if (isset($_POST["submit"])) {
                $inc_exp = $_POST["inc_exp"];
                $purpose = $_POST["purpose"];
                $amount = $_POST["amount"];
                $date = $_POST["date"];
                $month = date("F", strtotime($date));
                $year = date("Y", strtotime($date));
                $sql = "INSERT INTO in_ex (`email`, `purpose`, `amount`, `inc_exp`, `date`, `mm`, `yyyy`) VALUES('$email', '$purpose', '$amount', '$inc_exp', '$date', '$month', '$year')";
                $conn->query($sql) == true;
                $conn->close();
            }
        ?>
        <div class="top">
            <div>
                <h1 id="bTitle" class="budgetInner">Net Income</h1>
                <h2 id="bValue" class="budgetInner"></h2>
                
                <div class="clearfix budgetInner" id="budget_income">
                    <h3 class="budget_text budget_key">Income</h3>
                    <h3 class="budget_text budget_value" id="inValue"></h3>
                </div>
                
                <div class="clearfix budgetInner" id="budget_expense">
                    <h3 class="budget_text budget_key">Expense</h3>
                    <h3 class="budget_text budget_value clearfix" id="exValue"></h3>
                </div>
            </div>
        </div>
        
        
        
        <div class="add">
            <form method="post" action="index.php">
                <select name="inc_exp">
                    <option value="inc" selected>Income</option>
                    <option value="exp">Expense</option>
                </select>
                <input type="text" name="purpose" id="prps" placeholder="Purpose" required>
                <input type="date" id="dt" name="date" placeholder="Date" required>
                <input type="number" name="amount" id="amnt" placeholder="Amount" required>
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
            </form>
        </div>
        
        <div class="container clearfix">
            <div id="my">
                <form action="index.php" method="post">
                    <div id="toggle">
                        <label onclick="getElementById('myToggle').checked=false">Monthly</label>
                        <label class="switch">
                          <input type="checkbox" id="myToggle" name="myToggle">
                          <span class="slider round"></span>
                        </label>
                        <label onclick="getElementById('myToggle').checked=true">Yearly</label>
                    </div>
                    <div id="choose">
                        <select name="month" id="mSelect">
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                        <input class="date-own" type="text" id="year" name="year" required>
                        <input type="submit" class="btn btn-primary" value="Show" name="show" id="show" onclick="ieb()">
                    </div>
                </form>
            </div>
            <div id="report">
                <?php
                    if (isset($_POST["show"])) {
                        @$myToggle = $_POST["myToggle"];
                        $mm = $_POST["month"];
                        $yyyy = $_POST["year"];
                        if ($myToggle == false) {
                            $sqlI = "SELECT purpose, amount, date FROM in_ex WHERE email = '$email' AND mm  = '$mm' AND yyyy = '$yyyy' AND inc_exp = 'inc'";
                            $totIn = "SELECT SUM(amount) FROM in_ex WHERE email = '$email' AND inc_exp = 'inc' AND mm = '$mm' AND yyyy ='$yyyy'";
                        }
                        else {
                            $sqlI = "SELECT purpose, amount, date FROM in_ex WHERE email = '$email' AND yyyy = '$yyyy' AND inc_exp = 'inc'";
                            $totIn = "SELECT SUM(amount) FROM in_ex WHERE email = '$email' AND inc_exp = 'inc' AND yyyy = '$yyyy'";
                        }
                        $resultI = mysqli_query($conn, $sqlI);
                        $resIn = mysqli_query($conn, $totIn);
                        $rowIn = mysqli_fetch_assoc($resIn);
                        $income = $rowIn['SUM(amount)'];
                ?>
                <div class="inex" id="income">
                    <h2 id="titleI">Income</h2>
                    <table class="table table-hover">
                        <tr>
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        <tr>
                            <?php
                                while($row = mysqli_fetch_assoc($resultI))
                                {
                            ?>
                            <td><?php echo $row['purpose'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['date'];?></td>
                        </tr>
                        <?php
                                }
                        ?>
                    </table>
                </div>
                            
                            
                            
                <div class="inex" id="expense">
                    <h2 id="titleE">Expense</h2>
                    <?php
                        if ($myToggle == false) {
                            $sqlE = "SELECT purpose, amount, date FROM in_ex WHERE email = '$email' AND mm = '$mm' AND yyyy = '$yyyy' AND inc_exp = 'exp'";
                            $totEx = "SELECT SUM(amount) FROM in_ex WHERE email = '$email' AND inc_exp = 'exp' AND mm = '$mm' AND yyyy = '$yyyy'";
                        }
                        else {
                            $sqlE = "SELECT purpose, amount, date FROM in_ex WHERE email = '$email' AND yyyy = '$yyyy' AND inc_exp = 'exp'";
                            $totEx = "SELECT SUM(amount) FROM in_ex WHERE email = '$email' AND inc_exp = 'exp' AND yyyy = '$yyyy'";
                        }
                        $resultE = mysqli_query($conn, $sqlE);
                        $resEx = mysqli_query($conn, $totEx);
                        $rowEx = mysqli_fetch_assoc($resEx);
                        $expense = $rowEx['SUM(amount)'];
                    ?>
                    <table class="table table-hover">
                        <tr>
                            <th>Purpose</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                        <tr>
                            <?php
                                $budget = $income - $expense;

                                while($row = mysqli_fetch_assoc($resultE))
                                {
                            ?>
                            <td><?php echo $row['purpose'];?></td>
                            <td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['date'];?></td>
                        </tr>
                        <?php
                                }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div id="logout">
                <form method="post" action="logout.php">
                    <input type="submit" class="btn btn-primary" value="Logout" name="logout">
                </form>
            </div>
        </div>
    <script src="assets/js/script.js"></script>
    <script>
        document.getElementById("inValue").innerHTML = <?php echo $income;?>;
        document.getElementById("exValue").innerHTML = <?php echo $expense;?>;
        document.getElementById("bValue").innerHTML = <?php echo $budget;?>;
    </script>
    </body>
</html>