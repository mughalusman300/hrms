<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/Payroll.css" />
<main onload="myFunction()">
        <div class="container-fluid" style="min-height: 393px;">
            <div class="row">
                <div class="col-12">
                    <h2>Create Payroll</h2>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div  class="card col-12 spacer">
                <div class="row spacer-5">
                    <div class="form-group col-md-4">
                        <h3><label>Staff Detail</label></h3>
                    </div> 
                    <div class="form-group col-md-8">
                        <div class="btn-group float-right">
                            <a href="<?php echo base_url() ?>/Payroll1" type="button" class="btn btn-primary btn-xs">
                                <i class="fa fa-arrow-left"></i> 
                            </a>
                        </div>
                    </div>
                </div>   
                <div class="col-md-12">
                                <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                </div>   
                <div class="card-body spacer" style="padding-top:0;">
                    <div  class="row">
                       <div class="col-md-8  col-sm-12">
                                    <div class="sfborder">  
                                        <div  class="col-md-12">
                                            <div  class="row emp-img">
                                                <div class="col-md-2">
                                                    <?php
                                                $image = $result['image'];
                                                if (!empty($image)) {
                                                    $file = $result['image'];

                                                } else {
                                                    $file = "public/asset/img/profiles/no-image.png";

                                                }
                                                ?>
                                                <img width="115" height="115" class="round5" src="<?php echo base_url() . "/" . $file ?>" alt="No Image">
                                                </div>
                                                <div class="col-md-10">
                                                 <table class="table table-sm mb0 font13">
                                                    <tbody>
                                                        <tr>
                                                            <th class="bozero"><?php echo "Name"; ?></th>
                                                            <td class="bozero"><?php echo $result["fname"] . " " . $result["lname"] ?></td>
                                                            <th class="bozero"><?php echo "Employee ID"; ?></th>
                                                            <td class="bozero"><?php echo $result["emp_card_id"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo 'Phone'; ?></th>
                                                            <td><?php echo $result["contact_no"] ?></td>
                                                            <th><?php echo 'Email'; ?></th>
                                                            <td><?php echo $result["email"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo 'Department'; ?></th>
                                                            <td>
                                                                <?php echo $result["department"] ?>      
                                                            </td>

                                                            <th><?php echo 'Designation'; ?></th>
                                                            <td><?php echo $result["designation"] ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                        </div><!--./col-md-8-->
                        <div class="col-md-4 col-sm-12">
                                <div class="sfborder relative overvisible"> 
                                    <div class="letest">
                                        <div class="rotatetest"><?php echo "attendance" ?></div>
                                    </div> 
                                    <div class="padd-en-rtl33"> 
                                        <table class="table table-sm mb0 font13" >
                                            <tr>
                                                <th  class="bozero"><?php echo 'Month'; ?></th>
                                                <?php foreach ($attendanceType as $key => $value) { ?>
                                                    <th class="bozero"><span data-toggle="tooltip" title="<?php echo $value["type"]; ?>"><?php echo strip_tags($value["key_value"]); ?></span></th>  
                                                <?php }
                                                ?>
                                            </tr>
                                            <?php
                                            foreach ($monthAttendance as $attendence_key => $attendence_value) {
                                                ?><tr>
                                                    <td><?php echo date("F", strtotime($attendence_key)); ?></td>
                                                    <td><?php echo $attendence_value['present'] ?></td>
                                                    <td><?php echo $attendence_value['late']; ?></td> 
                                                    <td><?php echo $attendence_value['absent']; ?></td> 
                                                    <td><?php echo $attendence_value['half_day']; ?></td> 
                                                    <td><?php echo $attendence_value['holiday']; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div><!--./col-md-4--> 
                            <div class="col-md-12">
                                <div style="background: #dadada; height: 1px; width: 100%; clear: both; margin-bottom: 10px;"></div>
                            </div>
                    </div>               
                </div><!-- /.card-body --> 
                <form class="form-horizontal" action="<?php echo base_url();?>/payroll1/payslip" method="post"  id="employeeform">
                        <div class="box-header">
                            <div class="row display-flex">
                                <div class="col-md-4 col-sm-4">
                                    <h3 class="box-title"><?php echo 'Allowances'; ?></h3>
                                    <button type="button" onclick="add_more()" class="plusign"><i class="fa fa-plus"></i></button>
                                    <div class="sameheight">
                                        <div class="feebox">
                                            <table class="table3" id="tableID">
                                                <tr id="row0">
                                                    <td><input type="text" class="form-control" id="allowance_type" name="allowance_type[]" placeholder="Type"></td>
                                                    <td><input onkeyup="add_allowance()" type="text" id="allowance_amount" name="allowance_amount[]" class="form-control" value="0"></td>
                                                </tr>
                                            </table>
                                        </div>  
                                    </div>
                                </div><!--./col-md-4-->
                                <div class="col-md-4 col-sm-4">
                                    <h3 class="box-title"><?php echo 'Deduction'; ?></h3>
                                    <button type="button" onclick="add_more_deduction()" class="plusign"><i class="fa fa-plus"></i></button>
                                    <div class="sameheight">
                                        <div class="feebox">
                                            <table class="table3" id="tableID2">
                                                <tr id="deduction_row0">
                                                    <td><input type="text" id="deduction_type" name="deduction_type[]" class="form-control" placeholder="Type"></td>
                                                    <td><input onkeyup="add_allowance()" type="text" id="deduction_amount" name="deduction_amount[]" class="form-control" value="0"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>  
                                </div><!--./col-md-4--> 
                                <div class="col-md-4 col-sm-4">
                                    <h3 class="box-title"><?php echo 'Payroll Summary(Rs)'; ?></h3>
                                    <button type="button" onclick="add_allowance()" class="plusign"><i class="fa fa-calculator"></i> <?php echo 'calculate'; ?></button>
                                    <div class="sameheight">
                                        <div class="payrollbox feebox">
                                            <div class="form-group">
                                                
                                                <div  class="col-sm-12">
                                                    <div class="row">
                                                        <input name="fullname" type="hidden" value="<?php echo $result["fname"] . " " . $result["lname"] ?>">
                                                        <input name="shift" type="hidden" value="<?php echo $shift;?>">
                                                        <input name="dep_type_id" type="hidden" value="<?php echo $dep_type_id;?>">
                                                        <label  class="col-sm-4 control-label"><b><?php echo 'Gross Salary'; ?></b></label>
                                                        <input onkeyup="add_allowance()"  style="background-color: white" class="col-sm-8 form-control" name="basic" value="<?php
                                                        if (!empty($gross_salary)) {
                                                            echo $gross_salary;
                                                        } else {
                                                            echo "0";
                                                        }
                                                        ?>" id="basic"  type="text" />
                                                    </div>
                                                </div>
                                            </div><!--./form-group-->
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label class="col-sm-4 control-label"><b><?php echo 'Allowances'; ?></b></label>
                                                        <input style="background-color: white" readonly="readonly" class="col-sm-8 form-control" name="total_allowance" id="total_allowance"  type="text" />
                                                    </div>
                                                </div>
                                            </div><!--./form-group-->
                                            <div class="form-group">
                                                
                                                <div class="col-sm-12 deductiondred">
                                                    <div class="row">
                                                        <label class="col-sm-4 control-label"><b><?php echo 'Deduction'; ?></b></label>
                                                        <input style="background-color: white" readonly="readonly" class="col-sm-8 form-control" name="total_deduction" id="total_deduction" type="text" style="color:#f50000" />
                                                    </div>
                                                </div>
                                            </div><!--./form-group-->
                                            <div class="form-group">
                                                
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <label class="col-sm-4 control-label"><b><?php echo 'Total'; ?></b></label>
                                                        <input style="background-color: white" readonly="readonly" class="col-sm-8 form-control" name="gross_salary" id="gross_salary" value="0" type="text" />
                                                    </div>
                                                </div>
                                            </div><!--./form-group-->
                                            <div class="form-group">
                                                
                                                <div class="col-sm-12 deductiondred">
                                                    <div class="row">
                                                        <label class="col-sm-4 control-label"><b><?php echo 'Tax'; ?></b></label>
                                                        <input style="background-color: white"  onkeyup="add_allowance()" readonly="readonly" class="col-sm-8 form-control" name="tax" id="tax" value="0" type="text" />
                                                    </div>
                                                </div>
                                            </div><!--./form-group-->
                                            <hr/>
                                            <div class="form-group">
                                                
                                                <div class="col-sm-12 net_green">
                                                    <div class="row">
                                                        <label class="col-sm-4 control-label"><b><?php echo 'Net Salary'; ?></b></label>
                                                        <input style="background-color: white" readonly="readonly" class="col-sm-8 form-control greentest"  name="net_salary" id="net_salary"  type="text" />
                                                        <span class="text-danger" id="err"></span>
                                                        <input class="form-control" name="emp_id" value="<?php echo $result["emp_id"]; ?>"  type="hidden" />
                                                        <input class="form-control" name="month" value="<?php echo $month; ?>"  type="hidden" />
                                                        <input class="form-control" name="year" value="<?php echo $year; ?>"  type="hidden" />
                                                        <input class="form-control" name="status" value="generated"  type="hidden" />
                                                    </div>    
                                                </div>
                                            </div><!--./form-group-->
                                        </div>
                                    </div> 
                                </div><!--./col-md-4--> 
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit" id="contact_submit" class="btn btn-info float-right"><?php echo 'save'; ?></button>
                                </div><!--./col-md-12--> 
                                </form>
                            </div><!--./row-->  
                        </div><!--./box-header-->
            </div>
        </div>
    </main>
<script type="text/javascript">


    window.onload = function() {
     var basic_pay = $("#basic").val();

        var allowance_type = document.getElementsByName('allowance_type[]');

        var allowance_amount = document.getElementsByName('allowance_amount[]');

//var leave_deduction = $("#leave_deduction").val();

        var tax = 0;

        var total_allowance = 0;



        var deduction_type = document.getElementsByName('deduction_type[]');

        var deduction_amount = document.getElementsByName('deduction_amount[]');



        var total_deduction = 0;



        for (var i = 0; i < allowance_amount.length; i++) {



            var inp = allowance_amount[i];



            if (inp.value == '') {



                var inpvalue = 0;

            } else {

                var inpvalue = inp.value;

            }



            total_allowance += parseInt(inpvalue);



        }



        for (var j = 0; j < deduction_amount.length; j++) {





            var inpd = deduction_amount[j];



            if (inpd.value == '') {



                var inpdvalue = 0;



            } else {



                var inpdvalue = inpd.value;

            }

            total_deduction += parseInt(inpdvalue);

        }





//total_deduction += parseInt(leave_deduction) ;



        var gross_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction);

        var gross_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction);
        var annual_salary    = gross_salary * 12;
        //console.log(annual_salary);
        if(annual_salary > 600000 && annual_salary <1200001){
            taxable_amount = annual_salary - 600000; 
            tax =  (5/100 * taxable_amount)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 1200000 && annual_salary <1800001){
            console.log("1200000");
            taxable_amount = annual_salary - 1200000;
            tax =  ((10/100 * taxable_amount)+30000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 1800000 && annual_salary <2500001){
            console.log("1800000");
            taxable_amount = annual_salary - 1800000;
            tax =  ((15/100 * taxable_amount)+90000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 2500000 && annual_salary <3500001){
            console.log("2500000");
            taxable_amount = annual_salary - 2500000;
            tax =  ((17.5/100 * taxable_amount)+195000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 3500000 && annual_salary <5000001){
            console.log("3500000");
            taxable_amount = annual_salary - 3500000;
            tax =  ((20/100 * taxable_amount)+370000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 5000000 && annual_salary <8000001){
            //console.log(annual_salary);
            taxable_amount = annual_salary - 5000000 ;
            //console.log(taxable_amount);

            tax =  ((22.5/100 * taxable_amount)+670000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else{
            $("#tax").val(0);      
        }
        var net_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction) - parseInt(tax);



        $("#total_allowance").val(total_allowance);

        $("#total_deduction").val(total_deduction);

        $("#total_allow").html(total_allowance);

        $("#total_deduc").html(total_deduction);

        $("#gross_salary").val(gross_salary);

        $("#net_salary").val(net_salary);
    };
    function add_allowance() {

        var basic_pay = $("#basic").val();

        var allowance_type = document.getElementsByName('allowance_type[]');

        var allowance_amount = document.getElementsByName('allowance_amount[]');

//var leave_deduction = $("#leave_deduction").val();

        var tax = 0;

        var total_allowance = 0;



        var deduction_type = document.getElementsByName('deduction_type[]');

        var deduction_amount = document.getElementsByName('deduction_amount[]');



        var total_deduction = 0;



        for (var i = 0; i < allowance_amount.length; i++) {



            var inp = allowance_amount[i];



            if (inp.value == '') {



                var inpvalue = 0;

            } else {

                var inpvalue = inp.value;

            }



            total_allowance += parseInt(inpvalue);



        }



        for (var j = 0; j < deduction_amount.length; j++) {





            var inpd = deduction_amount[j];



            if (inpd.value == '') {



                var inpdvalue = 0;



            } else {



                var inpdvalue = inpd.value;

            }

            total_deduction += parseInt(inpdvalue);

        }





//total_deduction += parseInt(leave_deduction) ;



        var gross_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction);

        var gross_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction);
        var annual_salary    = gross_salary * 12;
        //console.log(annual_salary);
        if(annual_salary > 600000 && annual_salary <1200001){
            taxable_amount = annual_salary - 600000; 
            tax =  (5/100 * taxable_amount)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 1200000 && annual_salary <1800001){
            console.log("1200000");
            taxable_amount = annual_salary - 1200000;
            tax =  ((10/100 * taxable_amount)+30000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 1800000 && annual_salary <2500001){
            console.log("1800000");
            taxable_amount = annual_salary - 1800000;
            tax =  ((15/100 * taxable_amount)+90000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 2500000 && annual_salary <3500001){
            console.log("2500000");
            taxable_amount = annual_salary - 2500000;
            tax =  ((17.5/100 * taxable_amount)+195000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 3500000 && annual_salary <5000001){
            console.log("3500000");
            taxable_amount = annual_salary - 3500000;
            tax =  ((20/100 * taxable_amount)+370000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else if(annual_salary > 5000000 && annual_salary <8000001){
            //console.log(annual_salary);
            taxable_amount = annual_salary - 5000000 ;
            //console.log(taxable_amount);

            tax =  ((22.5/100 * taxable_amount)+670000)/12 ;
            tax = Math.round(tax);
            $("#tax").val(tax);
        }
        else{
            $("#tax").val(0);      
        }
        var net_salary = parseInt(basic_pay) + parseInt(total_allowance) - parseInt(total_deduction) - parseInt(tax);



        $("#total_allowance").val(total_allowance);

        $("#total_deduction").val(total_deduction);

        $("#total_allow").html(total_allowance);

        $("#total_deduc").html(total_deduction);

        $("#gross_salary").val(gross_salary);

        $("#net_salary").val(net_salary);



    }

    function add_more() {



        var table = document.getElementById("tableID");

        var table_len = (table.rows.length);

        var id = parseInt(table_len);

        var row = table.insertRow(table_len).outerHTML = "<tr id='row" + id + "'><td><input type='text' class='form-control' id='allowance_type' name='allowance_type[]' placeholder='Type'></td><td><input onkeyup='add_allowance()' type='text' class='form-control' id='allowance_amount' name='allowance_amount[]'  value='0'></td><td><button type='button' onclick='delete_row(" + id + ")' class='closebtn'><i class='fa fa-minus-circle'></i></button></td></tr>";

    }



    function delete_row(id) {





        var table = document.getElementById("tableID");

        var rowCount = table.rows.length;

        $("#row" + id).html("");

//table.deleteRow(id);

    }





    function add_more_deduction() {



        var table = document.getElementById("tableID2");

        var table_len = (table.rows.length);

        var id = parseInt(table_len);

        var row = table.insertRow(table_len).outerHTML = "<tr id='deduction_row" + id + "'><td><input type='text' class='form-control' id='deduction_type' name='deduction_type[]' placeholder='Type'></td><td><input onkeyup='add_allowance()' type='text' id='deduction_amount' name='deduction_amount[]' class='form-control' value='0'></td><td><button type='button' onclick='delete_deduction_row(" + id + ")' class='closebtn'><i class='fa fa-minus-circle'></i></button></td></tr>";



    }



    function delete_deduction_row(id) {





        var table = document.getElementById("tableID2");

        var rowCount = table.rows.length;

        $("#deduction_row" + id).html("");

//table.deleteRow(id);

    }

    function getEmployeeName(role) {



        var base_url = 'http://192.168.1.77/ss4/';

        $("#name").html("<option value=''>select</option>");

        var div_data = "";

        $.ajax({

            type: "POST",

            url: base_url + "admin/staff/getEmployeeByRole",

            data: {'role': role},

            dataType: "json",

            success: function (data) {

                $.each(data, function (i, obj)

                {

                    div_data += "<option value='" + obj.name + "'>" + obj.name + "</option>";

                });

                $('#name').append(div_data);

            }

        });

    }





    function getSectionByClass(class_id, section_id) {

        if (class_id != "" && section_id != "") {

            $('#section_id').html("");

            var base_url = 'http://192.168.1.77/ss4/';

            var div_data = '<option value="">Select</option>';

            $.ajax({

                type: "GET",

                url: base_url + "sections/getByClass",

                data: {'class_id': class_id},

                dataType: "json",

                success: function (data) {

                    $.each(data, function (i, obj)

                    {

                        var sel = "";

                        if (section_id == obj.section_id) {

                            sel = "selected";

                        }

                        div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";

                    });

                    $('#section_id').append(div_data);

                }

            });

        }

    }



    $(document).ready(function () {

        var class_id = $('#class_id').val();

        var section_id = '';

        getSectionByClass(class_id, section_id);

        $(document).on('change', '#class_id', function (e) {

            $('#section_id').html("");

            var class_id = $(this).val();

            var base_url = 'http://192.168.1.77/ss4/';

            var div_data = '<option value="">Select</option>';

            $.ajax({

                type: "GET",

                url: base_url + "sections/getByClass",

                data: {'class_id': class_id},

                dataType: "json",

                success: function (data) {

                    $.each(data, function (i, obj)

                    {

                        div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";

                    });

                    $('#section_id').append(div_data);

                }

            });

        });

    });



    $("#contact_submit").click(function (event) {



        var net = $("#net_salary").val();

        if (net == "") {



            $("#err").html("Net Salary should not be empty.");

            $("#net_salary").focus();

            return false;

            event.preventDefault();

        } else {

            $("#err").html("");

        }

    });

</script>    
<?= $this->endSection() ?>    