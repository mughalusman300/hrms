
<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<style type="text/css">

.table td, 
.table th {
    width: 1%;
}
.label-success{
    background-color: red;
    color: white;
}
</style> 
<style type="text/css" media="print">
  @page {
   size: landscape; }
   .no-print, .no-print *

        {

            display: none !important;

        }
</style>   
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Attendance</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Library</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="card col-12">
                <div class="position-absolute card-top-buttons">
                    <button class="btn btn-header-light icon-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-refresh"></i>
                    </button>
                </div>
                <?php
                            if (session()->getFlashdata('msg')) :?>
                            <div class="alert alert-success alert-dismissible fade show rounded  mt-3" role="alert">
			                 <?php echo session()->getFlashdata('msg');?>
			                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			                    <span aria-hidden="true">×</span>
			                </button>
		                    </div>
                                
                       <?php endif; ?>
                <div  class="card-body">
                	<form id='form1' action="<?php echo base_url();?>/Attendance/attendancereport" method="post">
	                    <div class="form-row">
	                        <div class="form-group col-md-3">
	                            <label><b>Department</b></label>
	                            <div class="input-group input-group-sm mb-3">
		                            <select tabindex="1" name="depid"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
	                                <option value="select">Select</option>
	                                <?php if(!empty($departments)):?>
	                                	<?php foreach($departments as  $value):?>
	                                    	<option value="<?php echo $value['depid'];?>"<?php
                                                if ($value["depid"] == $dep_type_id) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($value["department_name"]) ?></option>
		                                <?php endforeach;?>
		                            <?php endif;?>
	                                </select>
	                            </div>    
	                        </div>
	                        <div class="form-group col-md-3">
	                            <label><b>Shift</b></label>
	                            <div class="input-group input-group-sm mb-3">
		                            <select tabindex="2" name="shift"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
	                                <?php if(!empty($working_shift)):?>
	                                	<?php foreach($working_shift as   $value):?>
	                                    	<option value="<?php echo $value?>"<?php
                                                if ($value == $shift) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($value) ?></option>
		                                <?php endforeach;?>
		                            <?php endif;?>
	                                </select>
	                            </div>    
	                        </div>
	                        <div class="form-group col-md-3">
                                <label><b>Month</b></label>
                                <div class="input-group input-group-sm mb-3">
                                    <select tabindex="2" name="month"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    <option value="">Select</option>    
                                    <?php if(!empty($monthlist)):?>
                                        <?php foreach($monthlist as $m_key => $month):?>
                                            <option value="<?php echo $m_key ?>"<?php
                                                if ($month_selected == $m_key) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($month) ?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    </select>
                                </div> 
                                <?php if(!empty($errors)):?>
                                        <p style="color: red"><?php echo $errors;?></p>
                                <?php endif;?>   
                            </div>
                            <div class="form-group col-md-3">
                                <label><b>Year</b></label>
                                <div class="input-group input-group-sm mb-3">
                                    <select tabindex="2" name="year"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">  
                                    <?php if(!empty($yearlist)):?>
                                        <?php foreach($yearlist as $y_key => $year):?>
                                            <option value="<?php echo $year["year"] ?>"<?php
                                                if ($year["year"] == date("Y")) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($year["year"]); ?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    </select>
                                </div>    
                            </div>
	                        <div class="no-print form-group offset-md-11">
	                        	<button name="search" type="submit" value="submit" class="btn btn-primary btn-sm default">
	                        		<i class="simple-icon-magnifier"></i> Search</button>
	                        </div>
	                    </div> 
                    </form> 

                </div>
            </div>
<?php if (isset($resultlist)) { ?>
    <div class="separator mb-3"></div>
             <div style="margin: 0; padding: 0" class="card col-12">
                <div class="card-top-buttons ">
                	<div class="row justify-content-between">
	                    <div class="col-4">
                            <h3>Employee Attendance Report</h3>
                		</div>
		                <div class="col-md-4 col-sm-6">
	                    	<?php foreach ($attendencetypeslist as $key_type => $value_type) { ?>
                                            &nbsp;&nbsp;                              
                                            <b>
                                                <?php
                                                $att_type = str_replace(" ", "_", strtolower($value_type['type']));
                                                echo $att_type . ": " . $value_type['key_value'] . "";
                                                ?>
                                            </b>
                            <?php } ?>
	                    </div>
	                </div>
                   
                </div>
                <div class="card-body">              
                        <div  class="table-responsive">
                            <?php if (!empty($resultlist)):?>
                                
                            <table class="fit table table-sm">
                                <thead class=''>
                                    <tr>
                                    <th>Name </th>
                                    <th>% </th>
                                    <?php if (!empty($attendence_array)) {
                 
                                            foreach ($attendencetypeslist as $key => $value) {
                                                ?>
                                                <th colspan="" ><br/><span data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo "Total " . $value["type"]; ?>"><?php echo strip_tags($value["key_value"]); ?>
                                                    </span>
                                                </th>
                                    <?php }
                                    }
                                    ?>
                                    <?php
                                            foreach ($attendence_array as $at_key => $at_value) {
                                                if (date('D', strtotime($at_value)) == "Sun") {
                                                    ?>
                                                    <th style="background-color: #f2dede" class="tdcls text text-center">
                                                        <?php
                                                        echo date('d', strtotime($at_value)) . "<br/>" .
                                                        date('D', strtotime($at_value));
                                                        ?>
                                                    </th>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <th class="tdcls text text-center">
                                                        <?php
                                                        echo date('d', strtotime($at_value)) . "<br/>" .
                                                        date('D', strtotime($at_value));
                                                        ?>
                                                    </th>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if (empty($student_array)) {

            ?>

                                            <tr>

                                                <td colspan="32" class="text-danger text-center"><?php echo "No Record Found"; ?></td>

                                            </tr>

                                            <?php

                                        } else {



                                            $row_count = 1;

                                            $i = 0;



                                            foreach ($student_array as $student_key => $student_value) {



                                                $total_present = ($monthAttendance[$i][$student_value['id']]['present'] + $monthAttendance[$i][$student_value['id']]['late'] + $monthAttendance[$i][$student_value['id']]['half_day']);



                                                $total_days = $monthAttendance[$i][$student_value['id']]['present'] + $monthAttendance[$i][$student_value['id']]['late'] + $monthAttendance[$i][$student_value['id']]['absent'] + $monthAttendance[$i][$student_value['id']]['half_day'];





                                                // if($total_days == 0){

                                                //  $percentage = "-";

                                                // }else{

                                                //     $percentage = ($total_present/$total_days)*100 ; 

                                                // } 



                                                if ($total_days == 0) {

                                                    $percentage = -1;

                                                    $print_percentage = "-";

                                                } else {



                                                    $percentage = ($total_present / $total_days) * 100;

                                                    $print_percentage = round($percentage, 0);

                                                }



                                                if (($percentage < 75) && ($percentage >= 0)) {

                                                    $label = "class='badge badge-danger'";

                                                } else if ($percentage >= 75) {



                                                    $label = "class='badge badge-success'";

                                                } else {



                                                    $label = "class='badge badge-light'";

                                                }

                                                // echo "<label $label>". $print_percentage."</label>";

                                                ?>

                                                <tr>



                                                    <th  data-toggle="tooltip" data-placement="left" title="
                                                    <?php echo $student_value['designation_name']; ?>" ><a href="#" style="color:#333"><?php echo $student_value['name']; ?></a>

                                                        <div class="fee_detail_popover" style="display: none"><?php echo "Employee ID"; ?>: <?php echo $student_value['id']; ?></div>

                                                    </th>

                                                    <th><?php echo "<label $label>" . $print_percentage . "</label>"; //echo round($percentage,2);  ?></th>

                                                    <th><?php echo $monthAttendance[$i][$student_value['id']]['present']; ?></th>

                                                    <th><?php echo $monthAttendance[$i][$student_value['id']]['late']; ?></th>

                                                    <th><?php echo $monthAttendance[$i][$student_value['id']]['absent']; ?></th>

                                                    <th><?php echo $monthAttendance[$i][$student_value['id']]['half_day']; ?></th>

                                                    <th><?php echo $monthAttendance[$i][$student_value['id']]['holiday']; ?></th>

                <?php

                foreach ($attendence_array as $at_key => $at_value) {

                    ?>

                                                        <th class="tdcls text text-center">

                                                            <span data-toggle="popover" class="detail_popover" data-original-title="" title=""><a href="#" style="color:#333"><?php

                                                                print_r($resultlist[$at_value][$student_value['id']]['key']);

                                                                ?></a></span>

                                                            <div class="fee_detail_popover" style="display: none"><?php

                                            if (!empty($resultlist[$at_value][$student_value['id']]['remark'])) {

                                                echo $resultlist[$at_value][$student_value['id']]['remark'];

                                            }

                                                                ?></div>



                                                        </th>

                                                    <?php

                                                }

                                                ?>





                                                </tr>

                <?php

                $i++;

            }

        }

        ?>

                        
                                </tbody>
                               
                            </table>
                            <?php endif;?>
                         </div>
                        </div>   
                </div>
           

<?php } ?>

    </div> 
</main>
<script type="text/javascript">
 var base_url = '<?php echo base_url() ?>';

                function printDiv(elem) {

                    Popup(jQuery(elem).html());

                }
</script>
<?= $this->endSection() ?>    