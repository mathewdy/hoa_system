
    
<?php
$root = $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/';
require_once $root . 'config.php';
// require_once $root . 'app/includes/session.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/hoa_system/app/core/init.php';


$pageTitle = 'Homeowners';
ob_start();
?>


    <?php 

        if(isset($_GET['id'])){
            $remittance_table_id = $_GET['id'];

            $sql_remittance_table = "SELECT * FROM remittance WHERE id = '$remittance_table_id '";
            $run_remittance_table = mysqli_query($conn,$sql_remittance_table);

            if(mysqli_num_rows($run_remittance_table) > 0){
                foreach($run_remittance_table as $row_tables){
                    ?>

                        <label for="">Particular:</label>
                        <p><?php echo $row_tables['particular']?></p>
                        <label for="">Amount:</label>
                        <p><?php echo $row_tables['amount']?></p>
                        <label for="">Date:</label>
                        <p><?php echo $row_tables['date']?></p>
                         <label for="">Transaction Type:</label>
                        <p><?php echo $row_tables['transaction_type']?></p>
                        <label for="">Secretary Name:</label>
                        <p><?php echo $row_tables['secretary_name']?></p>
                        <label for="">Status:</label>
                        <p>
                            <?php 
                                if($row_tables['is_approved'] == 0){
                                    echo "Pending";
                                }else{
                                    echo "Approved";
                                }
                            ?>
                        </p>


                    <?php 
                }
            }
        }

    ?>



<?php
$content = ob_get_clean();

$pageScripts = '
  <script type="module" src="/hoa_system/ui/modules/users/get.homeowners.js"></script>
';

require_once BASE_PATH . '/pages/layout.php';
?>
