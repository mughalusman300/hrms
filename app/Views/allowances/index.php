<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Allowances</h1>
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
                                <th scope="col">Type</th>
                                <th scope="col">Action</th>
                                <th scope="col">Date Posted</th>
                                </tr>
                            </thead>
                            <thead  class='thead-light'>
                                
                                <tr v-for="(rows,i) in allowances">
                                <td >{{i+1}}</td>
                                <td >{{rows.allow_name}} </td>
                                <td >{{rows.allow_type}}</td>
                                <td><center>
                                <button type="button" class="btn btn-warning btn-xs default" @click="editUser(rows)">Edit</button>
                               </center></td>
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
<div class="modal fade modal-right" id="createAllowance" tabindex="-1" role="dialog" aria-labelledby="createAllowance" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Create Allowance</h5>
                                        <h5 class="modal-title"v-show="editMode">Edit Allowance</h5>
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
                                                    <input v-model="allow_name" type="text" tabindex="1"  value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="allow_name_error!=''">{{allow_name_error}}</p>    
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label class="has-float-label"><span>Type<font style="color: red;">*</font></span></span></label>
                                                    <select v-model="allow_type" tabindex="2" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="A">A</option>
                                                        <option value="D">D</option>
                                                    </select>
                                                    <p style="color: red" v-if="allow_type_error!=''">{{allow_type_error}}</p>    
                                                </div>
                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="6" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && allow_name!='' && allow_type!=''"  tabindex="3" class="btn btn-primary" @click.prevent="postAllowance()">Submit</button>
                                            <!--Update Button--->
                                            <button  v-else-if="editMode && allow_name!='' && allow_type!=''"  tabindex="3" class="btn btn-primary" @click.prevent="updateAllowance()">Update</button>
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
    i:0,
    allowances:[],
    searchWord:'',
    loading:false,
    editMode:false,
    data:false,
    noData:false,
    formId:'',
    allow_name:'',
    allow_type:'',
    allow_name_error:'',
    allow_type_error:'',
  },
   methods:{
    getAllowances()
        {
          this.loading = true;  
          axios.get('Allowances/getAllAllowances').then((response)=>{
          this.loading = false;  
          this.allowances =response.data;
          })
        },
        createMode(){
        this.clearModel();
        this.clearErrors();
        this.editMode =false;
        $('#createAllowance').modal('show');
        },
        editUser(rows){
          this.editMode =true;
          this.clearModel();
          this.clearErrors();
          this.formId=rows.allow_id;
          this.allow_name=rows.allow_name;
          this.allow_type=rows.allow_type; 
        $('#createAllowance').modal('show');
        },
        postAllowance()
        {
          const form = new FormData();
          form.append("allow_name", this.allow_name);
          form.append("allow_type", this.allow_type);
          this.allowances={};
          this.loading = true;
          axios.post('createAllowance',form).then((response)=>{
          this.loading = false;   
            this.clearModel();
            $("#createAllowance").modal("hide");
            Swal.fire({
              icon: 'success',
              title:'Allowance has been Created Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getAllowances();

          }).catch(err => {

            this.loading = false;
            this.clearErrors();
            if(err.response.data.messages.allow_name){
             this.allow_name_error = err.response.data.messages.allow_name;
           }
           if(err.response.data.messages.allow_type){
           this.allow_type_error = err.response.data.messages.allow_type;
           }
           this.getAllowances();
        });
        },
        updateAllowance()
        {
          const form = new FormData();
          form.append("allow_name", this.allow_name);
          form.append("allow_type", this.allow_type); 
          this.allowances={};
          this.loading = true;  
          axios.post('updateAllowance/'+ this.formId, form).then((response)=>{
          this.loading = false;  
          this.clearModel();
          $("#createAllowance").modal("hide");
             Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title:'Allowance has been Updated Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.getAllowances();
          }).catch(err =>{
            this.clearErrors();
            if(err.response.data.messages.allow_name){
             this.allow_name_error = err.response.data.messages.allow_name;
           }
           if(err.response.data.messages.allow_type){
           this.allow_type_error = err.response.data.messages.allow_type;
           } 
           this.getAllowances();
          }) 
        },
        search(){
            this.allowances={};
            this.noData = false;
            this.loading = true;
            axios.get('searchAllow?s='+this.searchWord).then((response)=>{  
             this.loading = false;    
            this.allowances = response.data;
            if(response.data==''){
                this.noData = true;
            }

          }).catch(()=>{
          })

        },
        clearModel()
        {
            this.allow_name =""; 
            this.allow_type =""; 
        },
        clearErrors(){
            this.allow_name_error = "";
            this.allow_type_error = "";
        }

  },
  created(){
   this.getAllowances(); 
  }

})   
</script>
<?= $this->endSection() ?>    