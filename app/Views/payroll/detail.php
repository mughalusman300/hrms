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
                                <a href="<?= base_url();?>/home">Home</a>
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
                            <table class="table table-sm table-bordered">
                            <thead class='thead-light'>
                                <tr>
                                <th scope="col">SR.</th>
                                <th scope="col">Employee </th>
                                <th scope="col">Basic Salary </th>
                                <th scope="col">House Rent </th>
                                <th scope="col">Utilities </th>
                                <th scope="col">Total Salary</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <thead  class='thead-light'>
                                
                                <tr v-for="(rows,i) in payroll">
                                <td >{{i+1}}</td>
                                <td >{{rows.fname}} {{rows.lname}} </td>
                                <td >{{rows.basic_salary}}</td>
                                <td >{{rows.house_rent}}</td>
                                <td >{{rows.utilities}}</td>
                                <td >{{rows.total_salary}}</td>
                                <td >{{rows.salary_status}}</td>
                                <td >{{rows.created_at}}</td>
                                <td v-if="rows.salary_status=='Active'"><center>
                                <button type="button" class="btn btn-warning btn-xs default" @click="getAllowances(rows.salary_id)">Allowances</button>
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
                            <div class="col-12">
                                <p class="mb-3">
                                    <button type="button" class="btn btn-outline-primary" @click="createModeAllowance">Add New</button>
                                    <center><h5><b>Allowances</b></h5></center>
                                </p>  
                                    <div class="separator mb-3"></div>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope="col">SR.</th>
                                            <th scope="col">Alowance</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <thead  class='thead-light'>
                                            <tr v-for="(rows,i) in allowances">
                                            <td >SR.</td>
                                            <td >{{rows.allow_name}} </td>
                                            <td >{{rows.allow_amount}}</td>
                                            <td><center>
                                                <button type="button" 
                                                class="btn btn-danger btn-xs default"  @click="deleteAllowance(rows)">Delete
                                                </button>
                                            </center></td>
                                            </tr>
                                            
                                        </thead>
                                           
                                        </table>
                                     </div>
                            </div>                            
                            <!-- <div class="col-6">
                                <p class="mb-3">
                                    <button type="button" class="btn btn-outline-primary" @click="createModeDeduction">Add New</button>
                                     <center><h5><b>Deductions</b></h5></center>
                                </p> 
                                    <div class="separator mb-3"></div> 
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope="col">SR.</th>
                                            <th scope="col">Deduction </th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <thead  class='thead-light'>
                                            <tr v-for="(rows,i) in deductions">
                                            <td >SR.</td>
                                            <td >{{rows.allow_name}} </td>
                                            <td >{{rows.allow_amount}}</td>
                                            <td><center>
                                                <button type="button" 
                                                class="btn btn-danger btn-xs default"  @click="deleteAllowance(rows)">Delete
                                                </button>
                                            </center></td>
                                            </tr>   
                                            
                                        </thead>
                                           
                                        </table>
                                     </div>
                            </div> -->
                            </div>
                        </div>
                    </div>
              </div> 
            </div>    
                    
        </div> 
        
    
<!------Pyroll Head Add Model ---->      
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

                <!-- <form id="form_id
                " method="post" > -->

                    <div class="alert alert-info form-group" role="alert">
                        Note: All Fields Required.
                    </div>
                    <div class="form-group required">
                        <label class="has-float-label"><span>Salary <font style="color: red;">*</font></span></label>
                        <input v-model="total_salary" type="number" min="0" tabindex="3" class="form-control">
                    <p style="color: red" v-if="total_salary_error!=''">{{total_salary_error}}</p></div>
            </div>
            <div class="modal-footer">
                <button type="button"  tabindex="6" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <button v-if=" !editMode && total_salary!=''"  tabindex="3" class="btn btn-primary" @click.prevent="postPayroll()">Submit</button>
                <!--Update Button--->
                <button  v-else-if="editMode && salary_start_date!='' && salary_end_date!=''"  tabindex="3" class="btn btn-primary" @click.prevent="updateAllowance()">Update</button>
                <button v-else  disabled type="button" tabindex="5" class="btn btn-primary ">Fill For Submit</button>
            </div>
            <!--  </form> -->
        </div>
    </div>
</div>   
<!------End Pyroll Head Add Model-->

<!------Allowances Add Model ---->      
<div class="modal fade modal-right" id="createAllowances" tabindex="-1" role="dialog" aria-labelledby="createAllowances" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" v-show="!deductionMode">Create Allowances</h5>
                                        <h5 class="modal-title" v-show="deductionMode">Create Deductions</h5>
                                        
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                           <!--  <form id="form_id
                                            " method="post" > -->

                                                <div class="alert alert-info form-group" role="alert">
                                                    Note: All Fields Required.
                                                </div>
                                                <div v-if="!deductionMode" class="form-group required">
                                                    <label class="has-float-label"><span>Allowance <font style="color: red;">*</font></span></label>
                                                    <select v-model="allow_id" tabindex="1" class="form-control">
                                                        <option value="">Choose</option>
                                                        <option v-for="option in allAllowances" v-bind:value="option.allow_id">
                                                        {{ option.allow_name }}
                                                      </option>
                                                    </select>
                                                    <p style="color: red" v-if="allow_id_error!=''">{{allow_id_error}}</p>  
                                                </div>
                                                <div v-if="deductionMode" class="form-group required">
                                                    <label class="has-float-label"><span>Deduction <font style="color: red;">*</font></span></label>
                                                    <select v-model="allow_id" tabindex="1" class="form-control">
                                                        <option value="">Choose</option>
                                                        <option v-for="option in allDeductions" v-bind:value="option.allow_id">
                                                        {{ option.allow_name }}
                                                      </option>
                                                    </select>
                                                    <p style="color: red" v-if="allow_id_error!=''">{{allow_id_error}}</p>  
                                                </div>
                                                <div class="form-group required">
                                                    <label class="has-float-label"><span>Amount <font style="color: red;">*</font></span></label>
                                                    <input v-model="allow_amount" type="number" tabindex="2"class="form-control" placeholder=""> 
                                                    <p style="color: red" v-if="allow_amount_error!=''">{{allow_amount_error}}</p>  
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="4" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if="allow_id!='' && allow_amount!=''"  tabindex="3" class="btn btn-primary" @click.prevent="postAllowance()">Submit</button>
                                            <!--Update Button--->
                                            <button v-else  disabled type="button"  class="btn btn-primary ">Fill For Submit</button>
                                        </div>
                                        <!--  </form> -->
                                    </div>
                                </div>
</div>   
<!------Allowances Add Model-->    
</main>
<script type="text/javascript">
 var app = new Vue({
  el: '#app',
  data: {
    i : 0,
    payroll:[],
    deductions:[],
    empID :<?php echo $emp_id;?> ,
    searchWord:'',
    loading:false,
    editMode:false,
    divAllow: false,
    data:false,
    noData:false,
    formId:'',
    total_salary:'',
    total_salary_error:'',
    allowances:[],
    allAllowances:[],
    allDeductions:[],
    deductionMode:false,
    selected:[],
    allow_id:'',
    salary_id:'',
    allow_amount:'',
    allow_id_error:'',
    allow_amount_error:'',
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
        $('#createPayroll').modal('show');
        },
        postPayroll()
        {

          const form = new FormData();
          form.append("total_salary", this.total_salary);
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
            this.divAllow= false;

          }).catch(err => {

            this.loading = false;
            this.clearErrors();
           if(err.response.data.messages.total_salary){
           this.total_salary_error = err.response.data.messages.total_salary;
           }
           this.getPayroll();
        });
        },
        updateAllowance()
        {
          const form = new FormData();
          form.append("total_salary", this.total_salary); 
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

           if(err.response.data.messages.total_salary){
           this.total_salary_error = err.response.data.messages.total_salary;
           }
           this.getPayroll();
          }) 
        },
        clearModel()
        {
            this.total_salary =""; 
        },
        clearErrors(){
            this.total_salary = "";
            this.total_salary_error = "";
        },
        ////////////////////Alowances And Deductions Methods////////////////
        getAllowances(salary_id){
          this.divAllow= true;
          axios.get('/hrms/salaryallowances/'+salary_id).then((response)=>{
          this.salary_id = salary_id;   
          this.allowances =response.data;
          });
          axios.get('/hrms/salarydeductions/'+salary_id).then((response)=>{  
          this.deductions =response.data;
          });
          axios.get('/hrms/Payroll/getAllAllowances').then((response)=>{  
          this.allAllowances =response.data;
          }); 
          axios.get('/hrms/Payroll/getAllDeductions').then((response)=>{  
          this.allDeductions =response.data;
          }); 
        },
        createModeAllowance(){
           this.clearAllowanceModal();
           this.clearAllowanceError();
           this.deductionMode =false;
           $('#createAllowances').modal('show');   
        },
        createModeDeduction(rows){
          this.deductionMode =true;
          this.clearAllowanceModal();
          this.clearAllowanceError();
          $('#createAllowances').modal('show');   
           
        },
        postAllowance()
        {

          const form = new FormData();
          form.append("salary_id", this.salary_id);
          form.append("allow_id", this.allow_id);
          form.append("allow_amount", this.allow_amount);
          axios.post('/hrms/createsalaryallowance',form).then((response)=>{  
            this.clearAllowanceModal();
            $("#createAllowances").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getAllowances(this.salary_id);

          }).catch(err => {

            this.clearAllowanceError();
            if(err.response.data.messages.allow_id){
             this.allow_id_error = err.response.data.messages.allow_id;
           }
           if(err.response.data.messages.allow_amount){
           this.allow_amount_error = err.response.data.messages.allow_amount;
           }
           this.getAllowances(this.salary_id);
        });
        },
        deleteAllowance(rows)
        {    
          Swal.fire({
          title: 'Are you sure?',
          text: rows.allow_name+" will be deleted permanantly!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {  
              axios.delete('/hrms/deletesalaryallowance/'+rows.detail_id).then(()=>{
                 Swal.fire(
                  'Deleted!',
                  rows.allow_name+' has been deleted.',
                  'success'
                )
                this.getAllowances(rows.salary_id);
              }).catch(()=>{
                
            })
            }
          })
        },
        clearAllowanceModal()
        {
            this.allow_id = "";
            this.allow_amount = "";
        },
        clearAllowanceError()
        {
            this.allow_id_error ="";
            this.allow_amount_error ="";
        },

  },
  created(){
   this.getPayroll(); 
  }

})   
</script>
<?= $this->endSection() ?>    