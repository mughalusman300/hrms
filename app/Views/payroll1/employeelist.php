
<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<!-- <link rel="stylesheet" href="<?= base_url(); ?>/public/asset/css/Payroll.css" /> -->
<style type="text/css">
.moprint{color: #fff; font-size: 16px;margin-right: 20px;}
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
                    <h1>Payroll</h1>
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
                            <div class="alert alert-danger alert-dismissible fade show rounded  mt-3" role="alert">
                             <?php echo session()->getFlashdata('msg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            </div>  
                    <?php endif; ?>
                    <?php
                            if (session()->getFlashdata('successmsg')) :?>
                            <div class="alert alert-success alert-dismissible fade show rounded  mt-3" role="alert">
                             <?php echo session()->getFlashdata('successmsg');?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            </div>  
                    <?php endif; ?>
                <div  class="card-body">
                    <form id='form1' action="<?php echo base_url();?>/Payroll1" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label><b>Department</b></label>
                                <div class="input-group input-group-sm mb-3">
                                    <select tabindex="1" name="depid"  class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                    <option value="">Select</option>
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
                                       <?php if(isset($month)){                                      
                                        $month_selected = date("F", strtotime($month));
                                            } else {
                                                $month_selected = date("F", strtotime("-1 month"));
                                            }
                                        ?>    
                                        <?php foreach($monthlist as $m_key => $month):?>
                                            <option value="<?php echo $m_key ?>"<?php
                                                if ($month_selected == $m_key) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($month) ?></option>
                                        <?php endforeach;?>
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
                                                if ($year["year"] == $years) {
                                                    echo "selected =selected";
                                                }
                                                ?>><?php print_r($year["year"]); ?></option>
                                        <?php endforeach;?>
                                    <?php endif;?>
                                    </select>
                                </div>    
                            </div>
                            <div class="no-print  ml-auto">
                                <button name="search" type="submit" value="submit" class="btn btn-primary btn-sm">
                                    <i class="simple-icon-magnifier"></i> Search</button>
                            </div>
                        </div> 
                    </form> 
                </div>
            </div>
<?php if (isset($resultlist)):?>
    <div class="separator mb-3"></div>
            <div style="margin: 0; padding: 0" class="card col-12">
                <div class="card-top-buttons ">
                    <div class="row justify-content-between">
                        <div class="col-4">
                            <h3>Employee List</h3>
                        </div>
                        <div class="col-md-4 col-sm-6">
                          
                        </div>
                    </div>
                   
                </div>
                <div class="card-body">              
                        <div  class="table-responsive">

                                
                            <table  class="fit table table-sm">
                                <col style="width: 10%;" />
                                <col style="width: 15%;" />
                                <col style="width: 15%;" />
                                <col style="width: 15%;" />
                                <col style="width: 15%;" />
                                <col style="width: 10%;" />
                                <col style="width: 20%;" />
                                <thead class=''>
                                    <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Mobile No </th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                    $count = 1;

                                    foreach ($resultlist as $staff) {

                                        $status = $staff["status"];



                                        if ($staff["status"] == "paid") {

                                            $label = "class='badge badge-success'";

                                            $wstatus = $payroll_status[$staff["status"]];

                                        } else if ($staff["status"] == "generated") {

                                            $label = "class='badge badge-warning'";

                                            $wstatus = $payroll_status[$staff["status"]];

                                        } else {

                                            $label = "class='badge badge-light'";

                                            $wstatus = $payroll_status["not_generate"];

                                        }

                                        ?>

                                        <tr>

                                            <td><?php echo $staff['emp_card_id']; ?></td>

                                            <td><?php echo $staff['fname'] . " " . $staff['lname']; ?></td>

                                            <td><?php echo $staff['department']; ?></td>

                                            <td><?php echo $staff['designation']; ?></td>

                                            <td><?php echo $staff['contact_no']; ?></td>

                                            <td><small <?php echo $label; ?>><?php echo $wstatus; ?></small></td>

                                            <?php if ($status == "paid") { ?>

                                                <td  class=" no-print">

                                                    <a href="javascript:void" onclick="getPayslip('<?php echo $staff["payslip_id"]; ?>')"  role="button" class="btn  btn-success btn-xs checkbox-toggle edit_setting" data-toggle="tooltip" title="<?php echo 'Payslip View'; ?>" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?php echo 'View'; ?> <?php echo'Payslip'; ?></a>
                                                     <a href="<?php echo base_url() ?>/Payroll1/revertpayroll/<?php echo $staff["payslip_id"] . "/" . $month_selected . "/" . date("Y") . "/".$shift."/".$dep_type_id ?>" class="btn btn-default btn-xs" onclick="return confirm('Are you sure you want to revert this record')" title="Revert">
                                                         <i class="fa fa-undo"> </i>
                                                    </a>

                                                <?php } ?></td>

                                                <?php if ($status == "generated") { ?>

                                                <td class="no-print">

                                                     <a href="#" onclick="getRecord('<?php echo $staff["emp_id"] ?>')" role="button" class="btn btn-warning  btn-xs checkbox-toggle edit_setting" data-toggle="tooltip" title="<?php echo 'Proceed to Payment'; ?>" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"><?php echo 'Proceed  Pay'; ?></a>                                                   
                                                    <a href="<?php echo base_url() ?>/Payroll1/deletepayroll/<?php echo $staff["payslip_id"] . "/" . $month_selected . "/" . date("Y") . "/".$shift."/".$dep_type_id ?>" class="btn btn-default btn-xs" onclick="return confirm('Are you sure you want to revert this record')" title="Revert">
                                                         <i class="fa fa-undo"> </i>

                                                    </a>
                                                <?php 
                                            }
                                            ?></td>
                                                <?php if ($staff["payslip_id"] == 0) { ?>
                                                <td class=" no-print">

<a class="btn btn-primary btn-xs  checkbox-toggle edit_setting" role="button" href="<?php echo base_url() . "/Payroll1/create/" . $month_selected . "/" . $years . "/" . $staff["emp_id"]. "/".$shift."/".$dep_type_id ?>"><?php echo "Generate"; ?> <?php echo "Payroll"; ?></a>   

                                                </td>

                                        <?php } ?>

                                        </tr>

                                        <?php

                                    }

                                    $count++;

                                    ?>              
                                </tbody>
                               
                            </table>

                         </div>
                        </div>   
                </div>
           
             </div> 
<?php endif;?>
</main>
<div id="proceedtopay" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="background-color: #0a89bb; color: white; height: 5px" class="modal-header">
                <h5 class="modal-title"><?php echo "Proceed To Pay"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="schsetting_form" action="<?php echo site_url('admin/payroll/paymentSuccess') ?>">
                    <div class="form-row">
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label for="exampleInputEmail1">
                                <?php echo "Staff Name"; ?></label>
                            <input type="text" name="emp_name" readonly class="form-control" id="emp_name">
                        </div>
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label for="exampleInputEmail1"><?php echo "Payment Amount"; ?></label>
                            <input type="text" name="amount" readonly class="form-control" id="amount">
                        </div>
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label for="exampleInputEmail1">
                                <?php echo "Month Year"; ?></label> 

                            <input id="monthid" name="month" readonly placeholder="" type="text" class="form-control" />
                            <input  name="paymentmonth" placeholder="" type="hidden" class="form-control" />
                            <input name="paymentyear" placeholder="" type="hidden" class="form-control" />
                            <input name="paymentid" placeholder="" type="hidden" class="form-control" />
                        </div>
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label for="exampleInputEmail1"><?php echo "Payment Mode"; ?></label><br/><span id="remark">
                            </span>
                            <select name="payment_mode" id="payment_mode"  class="form-control">
                               <?php
                                foreach ($payment_mode as $pkey => $pvalue) {
                                    ?>
                                    <option value="<?php echo $pkey ?>"><?php echo $pvalue ?></option>
                                <?php
                                }
                                ?>
                            </select>               
                        </div>
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <label for="exampleInputEmail1"><?php echo "Payment Date"; ?></label><br/><span id="remark"> </span>
                            <input type="text" readonly="readonly" name="payment_date" id="payment_date" class="form-control" value="<?php echo date("m/d/Y") ?>">
                        </div>
                        <div class="input-group-sm mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-5">
                            <label for="exampleInputEmail1"><?php echo "Note"; ?></label><br/><span id="remark"> </span>
                            <textarea name="remarks" class="form-control" ></textarea>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button type="button" class="btn btn-primary submit_schsetting float-right" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing"> <?php echo 'Save'; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="payslipview" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div style="background-color: #0a89bb; color: white; height: 5px" class="modal-header">
                <h4 class="modal-title"><?php echo "Details "; ?> <span id="print"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body" id="testdata" >

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {

        Popup(jQuery(elem).html());

    }
    function getRecord(id) {
        // alert("<?php echo $month_selected ?>");
        $('#proceedtopay').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
        $('input[name="amount"]').val('');
        $('input[name="emp_name"]').val('');
        $('input[name="paymentid"]').val('');
        $('input[name="paymentmonth"]').val('');
        $('input[name="paymentyear"]').val('');
        $('#monthid').val('');
        var month = '<?php echo $month_selected ?>';
        var year = '<?php echo date('Y'); ?>';
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + '/payroll1/paymentRecord',
            type: 'POST',
            data: {emp_id: id, month: month, year: year},
            dataType: "json",
            success: function (result) {
                $('input[name="amount"]').val(result.result.net_salary);
                $('input[name="emp_name"]').val(result.result.fname + ' ' + result.result.lname + ' (' + result.result.emp_card_id + ')');
                $('input[name="paymentid"]').val(result.result.id);
                $('input[name="paymentmonth"]').val(month);
                $('input[name="paymentyear"]').val(year);
                $('#monthid').val(month + '-' + year);
            }
        });



        $('#payment_date').datepicker({
            format: date_format,
            autoclose: true
        });
    }
function getPayslip(id) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + '/payroll1/payslipView',
            type: 'POST',
            data: {payslipid: id},
            //dataType: "json",
            success: function (result) {
                $("#print").html("<a href='#' class='pull-right modal-title moprint' onclick='printData(" + id + ")'  title='Print'><i class='fa fa-print'></i></a>");
                $("#testdata").html(result);
            }
        });
        $('#payslipview').modal({
            show: true,
            backdrop: 'static',
            keyboard: false
        });
    }
    ;
    function printData(id) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + '/payroll1/payslipView',
            type: 'POST',
            data: {payslipid: id},
            //dataType: "json",
            success: function (result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }
      function popup(data)

    {

        var base_url = '<?php echo base_url() ?>';

        var frame1 = $('<iframe />');

        frame1[0].name = "frame1";

        frame1.css({"position": "absolute", "top": "-1000000px"});

        $("body").append(frame1);

        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;

        frameDoc.document.open();

        //Create a new HTML document.

        frameDoc.document.write('<html>');

        frameDoc.document.write('<head>');

        frameDoc.document.write('<title></title>');

        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + '/public/asset/css/vendor/bootstrap.min.css">');

        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + '/public/asset/fontawesome/css/all.min.css">');

        frameDoc.document.write('</head>');

        frameDoc.document.write('<body>');

        frameDoc.document.write(data);

        frameDoc.document.write('</body>');

        frameDoc.document.write('</html>');

        frameDoc.document.close();

        setTimeout(function () {

            window.frames["frame1"].focus();

            window.frames["frame1"].print();

            frame1.remove();

        }, 500);





        return true;

    }
    function getEmployeeName(role) {
        var base_url = '<?php echo base_url() ?>';
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
    function create(id) {
        var month = '<?php
if (isset($_POST["month"])) {
    echo $_POST["month"];
}
?>';
        var year = '<?php
if (isset($_POST["year"])) {
    echo $_POST["year"];
}
?>';
        $("#month").val(month);
        $("#year").val(year);
        $("#staffid").val(id);
        $("#formsubmit").submit();
    }
    $(document).on('click', '.submit_schsetting', function (e) {
        var $this = $(this);
        $this.button('loading');
        var check="Pass";
        var payment_mode="";
        if($("#payment_mode").val()!=""){
        payment_mode=$("#payment_mode").val();
        $("#client_id").css("border-color", "#ccc");
        }
        else
        {
        $("#payment_mode").css("border-color", "red");
        $("#payment_mode").focus();
        check="Fail";
        } 
        if(check!="Fail"){

        $.ajax({
            url: '<?php echo site_url("payroll1/paymentSuccess") ?>',
            type: 'post',
            data: $('#schsetting_form').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "success") {
                    window.location.reload(true);
                }
                $this.button('reset');
            }
        });
        }
    });

</script>
<?= $this->endSection() ?>    