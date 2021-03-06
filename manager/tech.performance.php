<?php
/**
 * Created by PhpStorm.
 * User: akarpm
 * Date: 3/18/2016
 * Time: 8:55 PM
 */

session_start();


$inventory=217;

if(isset($_SESSION["sessionInventoryID"])) {
    $inventory = $_SESSION["sessionInventoryID"];
}

include('headernav.php');
include("managernav.php");
include("table&queryutility.php");


$year = 2015;

if(isset($_GET['submit'])) {
    $year = $_GET['year'];
}


$queryUtility = new MyQueryUtility();
$conn = $queryUtility->establishConnection();

function showTable1()
{

  global $conn,$inventory,$year,$queryUtility;

    $TechQuery =  "select rownum as rank,emp_name,excellence from(select emp_name,excellence from
(select round((count1/count2)*100,2) as excellence,r1 as technician from (select count(*) as count1,refurbished_by as r2 from products
where rating>=3 and inventory=".$inventory." and extract(year from refurbished_date)=".$year."
 group by refurbished_by),
(select count(*) as count2,refurbished_by as r1 from products where inventory=".$inventory." and
extract(year from refurbished_date)=".$year." and rating is not null group by refurbished_by)
where r1=r2 ),employee where emp_id=technician order by excellence desc)";





    $result1 = $queryUtility->runQuery($conn, $TechQuery);

    $headers = array('rank' => 'Rank',
        'emp_name' => 'Technician',
        'excellence' => 'Excellence(%))',
      );

    // Get row content.
    $data_cells = array();

    $i = 0;

    while (($row = oci_fetch_array($result1,OCI_BOTH)) != false) {
        $data_cells[$i] = $row;


        /* for ($j = 0; $j < count($headers); $j++) {
             $data_cell[$j] = $row[$j];

         }*/

        // $data_cells[$i] = $data_cell;
        //unset($data_cell);
        $i++;
    }

    $utility = new MyTableUtility();

    $utility->createTable1($headers, $data_cells);


    //close connection
    // oci_close($conn);

}

function showTable2()
{

    global $conn,$inventory,$year;



    $OrgQuery =  "select rownum as rank,org_name,avgrating from (select r.org_name, round(avg(p.rating),2)
 as avgrating from organization r,products p
where r.org_id= p.sold_by and p.inventory=".$inventory." and extract(year from entry_date)= ".$year." and rating is not null
 group by p.sold_by,r.org_name order by avgrating desc) where rownum<=10";

    $queryUtility = new MyQueryUtility();
    $result1 = $queryUtility->runQuery($conn, $OrgQuery);

    $headers = array('rank' => 'Rank',
        'org_name' => 'Organization',
        'avgrating' => 'Average Rating',
    );

    // Get row content.
    $data_cells = array();

    $i = 0;

    while (($row = oci_fetch_array($result1,OCI_BOTH)) != false) {
        $data_cells[$i] = $row;


        /* for ($j = 0; $j < count($headers); $j++) {
             $data_cell[$j] = $row[$j];

         }*/

        // $data_cells[$i] = $data_cell;
        //unset($data_cell);
        $i++;
    }

    $utility = new MyTableUtility();

    $utility->createTable1($headers, $data_cells);


    //close connection
    // oci_close($conn);

}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--    <title>Libchart vertical bars demonstration</title>-->
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
</head>
<body>

<section>
    <div id="topcontainer" style="float: left;width: 1170px;height: 470px">

        <div id="firstcontainer" style="float: left;width: 1170px;height: 50px">

            <div id="left" style="float: left;width: 1170px;height: 50px;margin-left: 5%;margin-top:1% ">

                   <form> &nbsp;
                    &nbsp;
                    &nbsp;

                    <b>Enter Year:</b>
                    <input type="text" style="width: 100px" name="year" value="<?php echo $year?>">
                    &nbsp;
                    <input type="submit" name="submit">  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;

                       <b style="color: #0069d3"> * Excellence(%): good rated products/total refurbished products</b>
                </form>



            </div>

        </div>
        <div id="secondcontainer" style="float: left;width: 1170px;height: 460px">
            <div id="technician" style="text-align=center;float: left;width: 570px;height: 450px;">
            <h4 style="padding-left: 25%"><u><b> Performance of Technicians in year<?php echo $year?></b></u></h4>
                <?php showTable1();
                ?>

            </div>
            <div id="organization" style="text-align=center;float: left;width: 570px;height: 460px;border: solid;border-width:0px ">
                <h4 style="padding-left: 25%"><b><u> Top 10 selling organizations in year<?php echo $year?></b></u></h4>
               <?php  showTable2();
            ?>
            </div>

        </div>

    </div>

</section>




</body>
</html>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     