<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Payroll</h1>
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
            <div class="row">
             <div class="card col-12">
                <div class="position-absolute card-top-buttons">
                    <button class="btn btn-header-light icon-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-refresh"></i>
                    </button>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>
                     <center><h5><b>Payroll Head</b></h5></center>
                    </p>
                        <hr>
                        <div class="separator mb-3"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead class='thead-light'>
                                <tr>
                                <th scope="col">SR.</th>
                                <th scope="col">Employee </th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Increment Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <thead  class='thead-light'>
                                
                                <tr v-for="(rows,i) in payroll">
                                <td >SR.</td>
                                <td >{{rows.fname}} {{rows.lname}} </td>
                                <td >{{rows.salary_start_date}}</td>
                                <td >{{rows.salary_end_date}}</td>
                                <td v-if='rows.salary_inc_date==null'>0000-00-00</td>

                                <td v-else>{{rows.salary_inc_date}}</td>
                                <td >{{rows.salary_status}}</td>
                                <td v-if="rows.salary_status=='Active'"><center>
                                <button type="button" class="btn btn-warning btn-xs default" @click="activeDiv()">Attribute</button>
                               </center></td>
                                </tr>
                                
                            </thead>
                               
                            </table>
                            <div class="mt-5"  v-if="noData">
                                 <center><h3>No Data Found.............</h3></center>
                            </div>
                            <div class="text-center" v-if="loading">
                               <b-spinner variant="info" class="mt-5 mb-5" style="width: 4rem; height: 4rem;" label="Large Spinner"></b-spinner>
                            </div>
                         </div>
                        </div>
                </div>
            </div> 
            <div class="separator mb-5"></div>
        
            <div v-if="divAllow" class="row">
              <div class="card col-12">
                <div class="position-absolute card-top-buttons">
                    <button class="btn btn-header-light icon-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-refresh"></i>
                    </button>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-3">
                                    <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>
                                    <center><h5><b>Allowances</b></h5></center>
                                </p>  
                                    <div class="separator mb-3"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope="col">SR.</th>
                                            <th scope="col">Alowance</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <thead  class='thead-light'>
                                            
                                            
                                        </thead>
                                           
                                        </table>
                                     </div>
                            </div>                            <div class="col-6">
                                <p class="mb-3">
                                    <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>
                                     <center><h5><b>Deductions</b></h5></center>
                                </p> 
                                    <div class="separator mb-3"></div> 
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope="col">SR.</th>
                                            <th scope="col">Deduction </th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <thead  class='thead-light'>
                                            
                                            
                                        </thead>
                                           
                                        </table>
                                     </div>
                            </div>
                            </div>
                        </div>
                    </div>
              </div> 
            </div>    
                    
        </div> 
        
    
<!------User Add Model ---->      
<div class="modal fade modal-right" id="createPayroll" tabindex="-1" role="dialog" aria-labelledby="createPayroll" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Create Payroll</h5>
                                        <h5 class="modal-title"v-show="editMode">Edit Payroll</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form id="form_id
                                            " method="post" >

                                                <div class="alert alert-info form-group" role="alert">
                                                    Note: All Fields Required.
                                                </div>
                                                <div class="form-group required">
                                                    <label class="has-float-label"><span>Start Date <font style="color: red;">*</font></span></label>
                                                    <input v-model="salary_start_date" type="date" tabindex="1" class="form-control">
                                                <p style="color: red" v-if="salary_start_date_error!=''">{{salary_start_date_error}}</p>    
                                                </div>
                                                <div class="form-group required">
                                                    <label class="has-float-label"><span>End Date <font style="color: red;">*</font></span></label>
                                                    <input v-model="salary_end_date" type="date" tabindex="2" class="form-control">
                                                <p style="color: red" v-if="salary_start_date_error!=''">{{salary_start_date_error}}</p>    
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="6" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && salary_start_date!='' && salary_end_date!=''"  tabindex="3" class="btn btn-primary" @click.prevent="postPayroll()">Submit</button>
                                            <!--Update Button--->
                                            <button  v-else-if="editMode && salary_start_date!='' && salary_end_date!=''"  tabindex="3" class="btn btn-primary" @click.prevent="updateAllowance()">Update</button>
                                            <button v-else  disabled type="button" tabindex="5" class="btn btn-primary ">Fill For Submit</button>
                                        </div>
                                         </form>
                                    </div>
                                </div>
</div>        
</main>
<script type="text/javascript">
 var app = new Vue({
  el: '#app',
  data: {
    payroll:[],
    empID :<?php echo $emp_id;?> ,
    searchWord:'',
    loading:false,
    editMode:false,
    divAllow: false,
    data:false,
    noData:false,
    formId:'',
    salary_start_date:'',
    salary_end_date:'',
    salary_start_date_error:'',
    salary_end_date_error:'',
  },
   methods:{
    getPayroll()
        {
          var empID =  <?php echo $emp_id;?>  
          this.loading = true;  
          axios.get('/hrms/getPayrollByEmpID/'+empID).then((response)=>{
          this.loading = false;  
          this.payroll =response.data;
          })
        },
        activeDiv(){
           this.divAllow= true; 
        },
        createMode(){
        this.clearModel();
        this.clearErrors();
        this.editMode =false;
        $('#createPayroll').modal('show');
        },
        editUser(rows){
          this.editMode =true;
          this.clearModel();
          this.clearErrors();
          this.formId=rows.allow_id;
          this.salary_start_date=rows.salary_start_date;
          this.salary_end_date=rows.salary_end_date; 
        $('#createPayroll').modal('show');
        },
        postPayroll()
        {

          const form = new FormData();
          form.append("salary_start_date", this.salary_start_date);
          form.append("salary_end_date", this.salary_end_date);
          this.payroll={};
          this.loading = true;
          axios.post('/hrms/createPayroll/'+this.empID,form).then((response)=>{
          this.loading = false;   
            this.clearModel();
            $("#createPayroll").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Payroll Head has been Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getPayroll();

          }).catch(err => {

            this.loading = false;
            this.clearErrors();
            if(err.response.data.messages.salary_start_date){
             this.salary_start_date_error = err.response.data.messages.salary_start_date;
           }
           if(err.response.data.messages.salary_end_date){
           this.salary_end_date_error = err.response.data.messages.salary_end_date;
           }
           this.getPayroll();
        });
        },
        updateAllowance()
        {
          const form = new FormData();
          form.append("salary_start_date", this.salary_start_date);
          form.append("salary_end_date", this.salary_end_date); 
          this.payroll={};
          this.loading = true;  
          axios.post('updateAllowance/'+ this.formId, form).then((response)=>{
          this.loading = false;  
          this.clearModel();
          $("#createPayroll").modal("hide");
             Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title:'Allowance has been Updated Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getPayroll();
          }).catch(err =>{
            this.clearErrors();
            if(err.response.data.messages.salary_start_date){
             this.salary_start_date_error = err.response.data.messages.salary_start_date;
           }
           if(err.response.data.messages.salary_end_date){
           this.salary_end_date_error = err.response.data.messages.salary_end_date;
           } 
           this.getPayroll();
          }) 
        },
        search(){
            this.payroll={};
            this.noData = false;
            this.loading = true;
            axios.get('searchAllow?s='+this.searchWord).then((response)=>{  
             this.loading = false;    
            this.payroll = response.data;
            if(response.data==''){
                this.noData = true;
            }

          }).catch(()=>{
          })

        },
        clearModel()
        {
            this.salary_start_date =""; 
            this.salary_end_date =""; 
        },
        clearErrors(){
            this.salary_start_date_error = "";
            this.salary_end_date_error = "";
        }

  },
  created(){
   this.getPayroll(); 
  }

})   
</script>
<?= $this->endSection() ?>    