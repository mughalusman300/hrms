<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Leave Types</h1>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="card col-12">
                <div class="position-absolute card-top-buttons">
                    <button class="btn btn-header-light icon-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="simple-icon-refresh"></i>
                    </button>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>

                    </p>
                        <hr>
                        <div class="separator mb-3"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead class='thead-light'>
                                <tr>
                                <th scope="col">SR.</th>
                                <th scope="col">Name </th>
                                <!-- <th scope="col">Action</th> -->
                                <th scope="col">Days</th>
                                </tr>
                            </thead>
                            <thead  class='thead-light'>
                                
                                <tr v-for="(rows,i) in leaveTypes">
                                <td >{{i+1}}</td>
                                <td >{{rows.type}} </td>
                               <!--  <td><center>
                                <button type="button" class="btn btn-warning btn-xs default" @click="editDepartment(rows)">Edit</button>
                               </center></td> -->
                                <td >{{rows.days}}</td>
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
<!------User Add Model ---->      
<div class="modal fade modal-right" id="createleaveTypes" tabindex="-1" role="dialog" aria-labelledby="createleaveTypes" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Creat Leave Type</h5>
                                        <h5 class="modal-title"v-show="editMode">Edit Department</h5>
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
                                                    <label class="has-float-label"><span>Name <font style="color: red;">*</font></span></label>
                                                    <input v-model="type" type="text" tabindex="1"  value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="type_error!=''">{{type_error}}</p>    
                                                </div>
                                                <div class="form-group required">
                                                    <label class="has-float-label"><span>Days <font style="color: red;">*</font></span></label>
                                                    <input v-model="days" type="number" tabindex="2"  value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="days_error!=''">{{days_error}}</p>    
                                                </div>
                                                
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="4" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && type!='' && days!=''"  tabindex="3" class="btn btn-primary" @click.prevent="postLeaveType()">Submit</button>
                                            <!--Update Button--->
                                            <!-- <button  v-else-if="editMode && department_name!=''"  tabindex="2" class="btn btn-primary" @click.prevent="updateDepartment()">Update</button> -->
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
  	i: 0,
    leaveTypes:[],
    searchWord:'',
    loading:false,
    editMode:false,
    data:false,
    noData:false,
    formId:'',
    type:'',
    type_error:'',
    days:'',
    days_error:'',
  },
   methods:{
    getLeaveTypes()
        {
          this.loading = true;  
          axios.get('/hrms/LeaveTypes/getAllLeaveTypes').then((response)=>{
          this.loading = false;  
          this.leaveTypes =response.data;
          })
        },
        createMode(){
        this.clearModel();
        this.clearErrors();
        this.editMode =false;
        $('#createleaveTypes').modal('show');
        },
        editDepartment(rows){
          // this.editMode =true;
          // this.clearModel();
          // this.clearErrors();
          // this.formId=rows.depid;
          // this.department_name=rows.department_name;
          //$('#createDepartment').modal('show');
        },
        postLeaveType()
        {
          const form = new FormData();
          form.append("type", this.type);
          form.append("days", this.days);
          this.leaveTypes={};
          this.loading = 	true;
          axios.post('/hrms/LeaveTypes/createLeaveTypes',form).then((response)=>{
          this.loading = false;   
            this.clearModel();
           // $("#createleaveTypes").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Leave Type has been Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getLeaveTypes();

          }).catch(err => {
           
            this.loading = false;
            this.clearErrors();
            console.log(err.response.data.messages);
            if(err.response.data.messages.type)
            { this.type_error = err.response.data.messages.type; } 
            if(err.response.data.messages.days)
            { this.days_error = err.response.data.messages.days; } 
           this.getLeaveTypes();
        });
        },
        clearModel()
        {
            this.type =""; 
            this.days =""; 
        },
        clearErrors(){
            this.type_error = "";
            this.days_error = "";
        }

  },
  created(){
   this.getLeaveTypes(); 
  }

})   
</script>
<?= $this->endSection() ?>    