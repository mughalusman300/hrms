
<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<style type="text/css">
div{
    display: inline-block;
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
                <div class="card-body">
                	<form id='form1' action="<?php echo base_url();?>/Attendance/index" method="post">
	                    <div class="form-row">
	                        <div class="form-group col-md-4">
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
	                        <div class="form-group col-md-4">
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
	                        <div class="form-group col-md-4">
	                        	<label><b>Date</b></label>
	                            <div class="input-group input-group-sm mb-3">
									<input tabindex="3" type="date" name="date" value="<?php echo $date;?>" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
								</div>
	                        </div>
                            <!-- <div class="form-group col-md-4">
                                <label><b>Date</b></label>
                                <div class="input-group input-group-sm mb-3">
                                    <input tabindex="4" type="text" id="demo" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </div> -->
	                        <div class="form-group offset-md-11">
	                        	<button type="submit" class="btn btn-primary btn-sm default">
	                        		<i class="simple-icon-magnifier"></i> Search</button>
	                        </div>
	                    </div> 
                    </form> 

                </div>
            </div>
<?php if (isset($resultlist)) { ?>
            <div class="separator mb-5"></div>
            <div class="card col-12">
            	 <?php

	            if (!empty($resultlist)) {
                 $checked = "";
                 if (!isset($msg)) {

                    if ($resultlist[0]['emp_attendance_type_id'] != "") {

                    if ($resultlist[0]['emp_attendance_type_id'] != 5) {

                        ?>
                        <div class="alert alert-success rounded mt-3">Attendance Already Submitted You can Edit Record!</div>

                        <?php

                    } else {

                        $checked = "checked='checked'";

                        ?>

                        <div class="alert alert-warning rounded mt-3">Attendance Already Submitted As Holiday. You Can Edit Record</div>

                        <?php

                    }

                }

            }
	        ?> 
                <div class="card-top-buttons mb-0">
                	<form action="<?php echo base_url();?>/Attendance/add" method="post">

                	<div class="row justify-content-between">
	                    <div class="col-2">
                		<span class="button-checkbox">

                        <button type="button" class="btn btn-primary btn-sm default " data-color="primary"><?php echo('Mark Holiday'); ?></button>

                        <input type="checkbox" id="checkbox1" style="opacity:0;" class="hidden" name="holiday" value="checked" <?php echo $checked; ?>/>

                    </span>	                    </div>
		                <div class="col-2">
	                    	<button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm default">
		                        		<i class="iconsminds-save"></i>Save Attendance
		                    </button>
	                    </div>
	                </div>
                </div>

                <input type="hidden" name="dep_id" value="<?php echo $dep_type_id; ?>">
                <input type="hidden" name="date" value="<?php echo $date; ?>">

                <div class="card-body">              
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                            <thead class='thead-light'>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name </th>
                                <th scope="col">Department </th>
                                <th scope="col">Designation </th>
                                <th scope="col">Attendance</th>
                                <th scope="col">Note</th>
                                </tr>
                            </thead>
                            <tbody  class='thead-light'>
                               <?php

                               $row_count = 1;

		                       foreach ($resultlist as $key => $value) {

		                        $attendendence_id = $value["id"];

		                        ?>   
                                <tr>
                                <td>
                                	 <input type="hidden" name="student_session[]" value="<?php echo $value['emp_id']; ?>">

                                        <input  type="hidden" value="<?php echo $attendendence_id ?>"  name="attendendence_id<?php echo $value["emp_id"]; ?>">
                                	<?php echo $row_count;?>
                                		
                                </td>
                                <td><?php echo $value['fname']; ?> </td>
                                <td><?php echo $value['department_name']; ?> </td>
                                <td><?php echo $value['designation_name']; ?> </td>
                                <td>

                                <?php

                                $c = 1;

                                $count = 0;

                                foreach ($attendencetypeslist as $key => $type) {

                                    if ($type['key_value'] != "H") {

                                        $att_type = str_replace(" ", "_", strtolower($type['type']));
                                       
                                        if ($value["date"] != "xxx") {

                                            ?>

                                            <div class="radio radio-info radio-inline">

                                                <input <?php if ($value['emp_attendance_type_id'] == $type['id']) echo "checked"; ?>  type="radio" id="attendencetype<?php echo $value['emp_id'] . "-" . $count; ?>" value="<?php echo $type['id'] ?>" name="attendencetype<?php echo $value['emp_id']; ?>">

                                                <label for="attendencetype<?php echo $value['emp_id'] . "-" . $count; ?>">

                                                    <?php echo $type['type']; ?> 

                                                </label>

                                            </div>

                                            <?php

                                        }else {

                                            ?>



                                            <div class="radio radio-info radio-inline">

                                                <input <?php if (($c == 1) && ($resultlist[0]['emp_attendance_type_id'] != 5)) echo "checked"; ?> type="radio" id="attendencetype<?php echo $value['emp_id'] . "-" . $count; ?>" value="<?php echo $type['id'] ?>" name="attendencetype<?php echo $value['emp_id']; ?>" >

                                                <label for="attendencetype<?php echo $value['emp_id'] . "-" . $count; ?>"> 

                                                    <?php echo $type['type']; ?> 

                                                </label>



                                            </div>



                                            <?php

                                        }

                                        $c++;

                                        $count++;

                                    }

                                }

                                ?>



                            </td>
                            <?php if ($value["date"] == 'xxx') { ?> 

                                        <td><input type="text" name="remark<?php echo $value["emp_id"] ?>" ></td>
                                    <?php } else { ?>
                                        <td><input type="text" name="remark<?php echo $value["emp_id"] ?>" value="<?php echo $value["remark"]; ?>" ></td>

                                    <?php } ?>
                                </tr>
                                <?php
                                 $row_count++;
                                 }?>
                            </tbody>
                               
                            </table>
                         </div>
                        </div>   
                </form>
                </div>
           
            <?php } else {
             ?>

           <div class="alert alert-info rounded mt-3">No Record Found</div>
            <?php } ?>

<?php } ?>

    </div> 
</main>
<script type="text/javascript">
 $(document).ready(function () {
        $("#demo").datetimepicker({
                     minDate:new Date()
        });
    });
                $(document).ready(function () {

                    $.extend($.fn.dataTable.defaults, {

                        searching: false,

                        ordering: true,

                        paging: false,

                        retrieve: true,

                        destroy: true,

                        info: false

                    });

                    var table = $('.example').DataTable();

                    table.buttons('.export').remove();

                });

            </script>       

            <script type="text/javascript">





                window.onload = function xy() {
                    var ch = '<?php
                if (!empty($resultlist)) {
                    echo $resultlist[0]['emp_attendance_type_id'];
                }
                ?>';



                    if (ch == 5) {
                        $("input[type=radio]").attr('disabled', true);
                    } else {



                        $("input[type=radio]").attr('disabled', false);

                    }



                };

                $(document).ready(function () {







                    $('#checkbox1').change(function () {



                        if (this.checked) {

                            var returnVal = confirm("Are you sure?");

                            $(this).prop("checked", returnVal);



                            $("input[type=radio]").attr('disabled', true);





                        } else {

                            $("input[type=radio]").attr('disabled', false);

                            $("input[type=radio][value='1']").attr("checked", "checked");



                        }



                    });

                });





            </script>

            <script type="text/javascript">

                $(function () {

                    $('.button-checkbox').each(function () {

                        var $widget = $(this),

                                $button = $widget.find('button'),

                                $checkbox = $widget.find('input:checkbox'),

                                color = $button.data('color'),

                                settings = {

                                    on: {

                                        icon: 'fa fa-check-square'

                                    },

                                    off: {

                                        icon: 'fa fa-square'

                                    }

                                };

                        $button.on('click', function () {

                            $checkbox.prop('checked', !$checkbox.is(':checked'));

                            $checkbox.triggerHandler('change');

                            updateDisplay();

                        });

                        $checkbox.on('change', function () {

                            updateDisplay();

                        });



                        function updateDisplay() {

                            var isChecked = $checkbox.is(':checked');

                            $button.data('state', (isChecked) ? "on" : "off");

                            $button.find('.state-icon')

                                    .removeClass()

                                    .addClass('state-icon ' + settings[$button.data('state')].icon);

                            if (isChecked) {

                                $button

                                        .removeClass('btn-success')

                                        .addClass('btn-' + color + ' active');

                            } else {

                                $button

                                        .removeClass('btn-' + color + ' active')

                                        .addClass('btn-primary');

                            }

                        }



                        function init() {

                            updateDisplay();

                            if ($button.find('.state-icon').length == 0) {

                                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');

                            }

                        }

                        init();

                    });

                });

            </script>
<?= $this->endSection() ?>    