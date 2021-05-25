<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Designations</h1>
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
                                
                                <tr v-for="(rows,i) in designations">
                                <td >{{i+1}}</td>
                                <td >{{rows.designation_name}} </td>
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
<div class="modal fade modal-right" id="createDesignation" tabindex="-1" role="dialog" aria-labelledby="createDesignation" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Create Designation</h5>
                                        <h5 class="modal-title"v-show="editMode">Edit Designation</h5>
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
                                                    <input v-model="designation_name" type="text" tabindex="1"  value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="designation_name_error!=''">{{designation_name_error}}</p>    
                                                </div>
                                                
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="3" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && designation_name!=''"  tabindex="2" class="btn btn-primary" @click.prevent="postDesignation()">Submit</button>
                                            <!--Update Button--->
                                            <button  v-else-if="editMode && designation_name!=''"  tabindex="2" class="btn btn-primary" @click.prevent="updateDesignation()">Update</button>
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
    designations:[],
    searchWord:'',
    loading:false,
    editMode:false,
    data:false,
    noData:false,
    formId:'',
    designation_name:'',
    designation_name_error:'',
  },
   methods:{
    getDesignations()
        {
          this.loading = true;  
          axios.get('/hrms/Designation/getAllDesignations').then((response)=>{
          this.loading = false;  
          this.designations =response.data;
          })
        },
        createMode(){
        this.clearModel();
        this.clearErrors();
        this.editMode =false;
        $('#createDesignation').modal('show');
        },
        editDepartment(rows){
          // this.editMode =true;
          // this.clearModel();
          // this.clearErrors();
          // this.formId=rows.desid;
          // this.designation_name=rows.designation_name;
          //$('#createDesignation').modal('show');
        },
        postDesignation()
        {
          const form = new FormData();
          form.append("designation_name", this.designation_name);
          this.designations={};
          this.loading = 	true;
          axios.post('createDesignation',form).then((response)=>{
          this.loading = false;   
            this.clearModel();
            $("#createDesignation").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Designation has been Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getDesignations();

          }).catch(err => {
           
            this.loading = false;
            this.clearErrors();
           if(err.response.data.messages.designation_name){
             this.designation_name_error = err.response.data.messages.designation_name;
           }
           this.getDesignations();
        });
        },
        updateDesignation()
        {
          const form = new FormData();
          form.append("designation_name", this.designation_name);
          this.designations={};
          this.loading = true;  
          axios.post('updateDesignation/'+ this.formId, form).then((response)=>{
          this.loading = false;  
          this.clearModel();
          $("#createDesignation").modal("hide");
             Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title:'Designation has been Updated Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getDesignations();
          }).catch(err =>{
            this.clearErrors();
            if(err.response.data.messages.designation_name){
             this.designation_name_error = err.response.data.messages.designation_name;
           }
           this.getDesignations();
          }) 
        },
        search(){
            this.designations={};
            this.noData = false;
            this.loading = true;
            axios.get('searchDesignation?s='+this.searchWord).then((response)=>{  
             this.loading = false;    
            this.designations = response.data;
            if(response.data==''){
                this.noData = true;
            }

          }).catch(()=>{
          })

        },
        clearModel()
        {
            this.designation_name =""; 
        },
        clearErrors(){
            this.designation_name_error = "";
        }

  },
  created(){
   this.getDesignations(); 
  }

})   
</script>
<?= $this->endSection() ?>    