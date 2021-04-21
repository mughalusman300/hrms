<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Users</h1>
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
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                        <thead class='thead-light'>
                                            <tr>
                                            <th scope="col">SR.</th>
                                            <th scope="col">Name </th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Date Posted</th>
                                            </tr>
                                        </thead>
                                        <thead class='thead-light'>
                                            <tr v-for="(rows,i) in users">
                                            <td >SR.</td>
                                            <td >{{rows.saimtech_uname}} </td>
                                            <td >{{rows.saimtech_email}}</td>
                                            <td v-if="rows.saimtech_comp_id ==1">T.M Cargo & Logistics</td>
                                            <td v-else>T.M Delivery Express</td>

                                            <td >{{rows.saimtech_power}}</td>
                                            <td ><center>
                                            <button type="button" class="btn btn-warning btn-xs default" @click="editUser(rows)">Edit</button>
                                            <button type="button" 
                                            class="btn btn-danger btn-xs default"  @click="deleteUser(rows)">Delete
                                            </button>
                                           </center></td>
                                            <td >{{rows.saimtech_date}}</td>
                                            </tr>
                                        </thead>    
                                        </table>
                                     </div>
                                    </div>
                                    

                            </div>
        </div>
<!------User Add Model ---->      
<div class="modal fade modal-right" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUser" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title"v-show="!editMode">Create User</h5>
                                        <h5 class="modal-title"v-show="editMode">Edit User</h5>
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
                                                    <input v-model="name" type="text" tabindex="1" name="name" value="name" class="form-control" placeholder="">
                                                <p style="color: red" v-if="name_error!=''">{{name_error}}</p>    
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label class="has-float-label"><span>Email<font style="color: red;">*</font></span></span></label>
                                                   <input v-model="email" type="email" tabindex="2" name="email"class="form-control" placeholder="">
                                                    <p style="color: red" v-if="email_error!=''">{{email_error}}</p>    
                                                </div>

                                                <div class="form-group">
                                                    <label class="has-float-label"><span>Password<font style="color: red;">*</font></span></label>
                                                   <input v-model="password" type="password" tabindex="3" name="password"class="form-control" placeholder="">
                                                   <p style="color: red" v-if="password_error!=''">{{password_error}}</p> 
                                                </div>

                                                <div class="form-group">
                                                    <label class="has-float-label"><span>Company<font style="color: red;">*</font></span></label>
                                                    <select v-model="company_id"  name="company_id"  tabindex="4" class="form-control">
                                                        <option disabled="disabled" value="">Select</option>
                                                        <option value="1">T.M Cargo & Logistics</option>
                                                        <option value="2">T.M Delivery Express</option>
                                                    </select>
                                                    <p style="color: red" v-if="company_id_error!=''">{{company_id_error}}</p> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="has-float-label"><span>Role<font style="color: red;">*</font></span></label>
                                                    <select v-model="user_power"  name="company_id"    tabindex="4" class="form-control">
                                                        <option disabled="disabled" value="">Select</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="User">User</option>
                                                    </select>
                                                    <p style="color: red" v-if="user_power_error!=''">{{user_power_error}}</p> 
                                                </div>

                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button"  tabindex="6" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                                            <button v-if=" !editMode && name!='' && email!='' && password!=''  && user_power!=''"  type="submit"  tabindex="5" class="btn btn-primary" @click.prevent="postUser()">Submit</button>
                                            <!--Update Button--->
                                            <button  v-else-if="editMode && name!='' && email!='' && password!=''  && user_power!=''"  type="submit"  tabindex="5" class="btn btn-primary" @click.prevent="updateUser()">Update User</button>
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
    users:{},
    editMode:false,
    formId:'',
    name:'',
    email:'',
    password:'',
    company_id:'',
    user_power:'',
    name_error:'',
    email_error:'',
    password_error:'',
    company_id_error:'',
    user_power_error:'',
  },
   methods:{
    getUsers()
        {
          axios.get('User/getAllUsers').then((response)=>{
          this.users =response.data
          })
        },
        createMode(){
        this.clearModel();
        this.editMode =false;
        $('#createUser').modal('show');
        },
        editUser(rows){
          this.editMode =true;
          this.clearModel();
          this.formId=rows.id;
          this.name=rows.saimtech_uname;
          this.email=rows.saimtech_email; 
          this.password= rows.saimtech_password;
          this.company_id= rows.saimtech_comp_id;
          this.user_power= rows.saimtech_power;
        $('#createUser').modal('show');
        },
        deleteUser(rows)
         { 
          Swal.fire({
          title: 'Are you sure?',
          text: rows.saimtech_uname+" will be deleted permanantly!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {  
              axios.delete('user/delete/'+rows.id).then(()=>{
                 Swal.fire(
                  'Deleted!',
                  rows.saimtech_uname+' has been deleted.',
                  'success'
                )
                this.getUsers();
              }).catch(()=>{
                
            })
            }
          })
        },
        postUser()
        {
          const form = new FormData();
          form.append("name", this.name);
          form.append("email", this.email);
          form.append("password", this.password);
          form.append("company_id", this.company_id);
          form.append("user_power", this.user_power); 

          axios.post('create',form).then((response)=>{
            this.clearModel();
            $("#createUser").modal("hide");
            this.getUsers();

          }).catch(err => {

            this.name_error = "";
            this.email_error = "";
            this.password_error = "";
            this.company_id_error = "";
            this.user_power_error = "";
            if(err.response.data.messages.name){
             this.name_error = err.response.data.messages.name;
           }
           if(err.response.data.messages.email){
           this.email_error = err.response.data.messages.email;
           }
           if(err.response.data.messages.password){
           this.password_error = err.response.data.messages.password;
           }
           if(err.response.data.messages.company_id){
           this.company_id_error = err.response.data.messages.company_id;
           }
           if(err.response.data.messages.user_power){
           this.user_power_error = err.response.data.messages.user_power;
           }
        });
        },
        updateUser()
        {
          const form = new FormData();
          form.append("name", this.name);
          form.append("email", this.email);
          form.append("password", this.password);
          form.append("company_id", this.company_id);
          form.append("user_power", this.user_power);   
          axios.post('User/update/'+ this.formId, form).then((response)=>{
          this.clearModel();
          $("#createUser").modal("hide");
             Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title: this.name + 'User has been Updated Successfully',
              showConfirmButton: false,
              timer: 1500
            })
            this.getUsers();
          }).catch(()=>{

          }) 
        },
        clearModel()
        {
            this.name =""; 
            this.email =""; 
            this.password =""; 
            this.company_id =""; 
            this.user_power =""; 
            this.name_error = "";
            this.email_error = "";
            this.password_error = "";
            this.company_id_error = "";
            this.user_power_error = "";
        }

  },
  created(){
   this.getUsers(); 
  }

})   
</script>
<?= $this->endSection() ?>    