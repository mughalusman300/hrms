<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Departments</h1>
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
                <div class="card-body">
                    <p class="mb-0">
                        <!-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-backdrop="static" data-target="#exampleModalRight">Add New</button> -->
                        <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>

                    </p>
                        <hr>
                        <div class="input-group typeahead-container">
                            <input type="text" v-model="searchWord"  class="form-control" name="query" id="query" placeholder="Search By Name..."  autocomplete="off" v-on:keyup="search">

                            <div class="input-group-append ">
                                <button type="submit" class="btn btn-primary default" @click="search">
                                    <i class="simple-icon-magnifier"></i>
                                </button>
                            </div>
                        </div>
                        <div class="separator mb-3"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead class='thead-light'>
                                <tr>
                                <th scope="col">SR.</th>
                                <th scope="col">Name </th>
                                <!-- <th scope="col">Action</th> -->
                                <th scope="col">Date Posted</th>
                                </tr>
                            </thead>
                            <thead  class='thead-light'>
                                
                                <tr v-for="(rows,i) in departments">
                                <td >{{i+1}}</td>
                                <td >{{rows.department_name}} </td>
                               <!--  <td><center>
                                <button type="button" class="btn btn-warning btn-xs default" @click="editDepartment(rows)">Edit</button>
                               </center></td> -->
                                <td >{{rows.created_at}}</td>
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
<div class="modal fade modal-right" id="createDepartment" tabindex="-1" role="dialog" aria-labelledby="createDepartment" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Create Department</h5>
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
                                                    <input v-model="department_name" type="text" tabindex="1"  value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="department_name_error!=''">{{department_name_error}}</p>    
                                                </div>
                                                
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="3" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && department_name!=''"  tabindex="2" class="btn btn-primary" @click.prevent="postDepartment()">Submit</button>
                                            <!--Update Button--->
                                            <button  v-else-if="editMode && department_name!=''"  tabindex="2" class="btn btn-primary" @click.prevent="updateDepartment()">Update</button>
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
    departments:[],
    searchWord:'',
    loading:false,
    editMode:false,
    data:false,
    noData:false,
    formId:'',
    department_name:'',
    department_name_error:'',
  },
   methods:{
    getDepartments()
        {
          this.loading = true;  
          axios.get('dep/getAllDepartments').then((response)=>{
          this.loading = false;  
          this.departments =response.data;
          })
        },
        createMode(){
        this.clearModel();
        this.clearErrors();
        this.editMode =false;
        $('#createDepartment').modal('show');
        },
        editDepartment(rows){
          // this.editMode =true;
          // this.clearModel();
          // this.clearErrors();
          // this.formId=rows.depid;
          // this.department_name=rows.department_name;
          //$('#createDepartment').modal('show');
        },
        postDepartment()
        {
          const form = new FormData();
          form.append("department_name", this.department_name);
          this.departments={};
          this.loading = 	true;
          axios.post('createDepartment',form).then((response)=>{
          this.loading = false;   
            this.clearModel();
            $("#createDepartment").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Department has been Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getDepartments();

          }).catch(err => {
           
            this.loading = false;
            this.clearErrors();
           
           this.getDepartments();
        });
        },
        updateDepartment()
        {
          const form = new FormData();
          form.append("department_name", this.department_name);
          this.departments={};
          this.loading = true;  
          axios.post('updateDepartment/'+ this.formId, form).then((response)=>{
          this.loading = false;  
          this.clearModel();
          $("#createDepartment").modal("hide");
             Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title:'Allowance has been Updated Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getDepartments();
          }).catch(err =>{
            this.clearErrors();
            if(err.response.data.messages.department_name){
             this.department_name_error = err.response.data.messages.department_name;
           }
           this.getDepartments();
          }) 
        },
        search(){
            this.departments={};
            this.noData = false;
            this.loading = true;
            axios.get('searchDepartment?s='+this.searchWord).then((response)=>{  
             this.loading = false;    
            this.departments = response.data;
            if(response.data==''){
                this.noData = true;
            }

          }).catch(()=>{
          })

        },
        clearModel()
        {
            this.department_name =""; 
        },
        clearErrors(){
            this.department_name_error = "";
        }

  },
  created(){
   this.getDepartments(); 
  }

})   
</script>
<?= $this->endSection() ?>    