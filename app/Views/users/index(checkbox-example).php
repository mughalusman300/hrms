<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Users</h1>
                    <div class="top-right-button-container">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                EXPORT
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" @click="exportExcel" id="dataTablesExcel" href="#">Excel</a>
                                <a class="dropdown-item" @click="exportCsv" id="dataTablesCsv" href="#">Csv</a>
                                <a class="dropdown-item" @click="exportPdf" id="dataTablesPdf" href="#">Pdf</a>
                            </div>
                        </div>
                    </div>
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
            <div class="card col-12">
              <div class="position-absolute card-top-buttons">
                  <button @click="getUsers" class="btn btn-header-light icon-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="simple-icon-refresh"></i>
                  </button>
              </div>
              <div class="card-body">
              
              <p class="mb-0">
                  <button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button>

              </p>
            <!-- <div class="input-group typeahead-container">
              <input type="text" v-model="searchWord"  class="form-control" name="query" id="query" placeholder="Search By Name,Email..."  autocomplete="off" v-on:keyup="search">

              <div class="input-group-append ">
                  <button type="submit" class="btn btn-primary default" @click="search">
                      <i class="simple-icon-magnifier"></i>
                  </button>
              </div>
            </div> -->
            <b-row>
            <b-col lg="4" class="my-1 offset-lg-8">
              <b-form-group
                label="Filter"
                label-for="filter-input"
                label-cols-sm="3"
                label-align-sm="right"
                label-size="sm"
                class="mb-0 typeahead-container"
              >
                <b-input-group size="sm">
                  <b-form-input
                    id="filter-input"
                    v-model="filter"
                    type="search"
                    placeholder="Search Name, Email, Role"
                  ></b-form-input>

                  <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
          </b-row>
          <div class="separator mb-3"></div>
         <b-row>
              <b-col lg="10" class="my-1">
              <p class="mt-3">Current Page: {{ currentPage }}</p>
              </b-col>
              <b-col lg="2" class="my-1">
              <b-form-group
                label-for="per-page-select"
                class="mb-2"
              >
                <b-form-select
                  id="per-page-select"
                  v-model="perPage"
                  :options="pageOptions"
                ></b-form-select>
              </b-form-group>
            </b-col>
         </b-row>   
         <div class="text-uppercase text-bold">id selected: {{selected}}</div>
         <input type="checkbox" v-model="selectAll" @click="selectToggle">
            <div class="table-responsive">
                <b-table
                  :filter="filter"
                  show-empty
                 
                  id="my-table"
                  :items="users"
                  :fields="fields"
                  :per-page="perPage"
                  :current-page="currentPage"
                  :striped="striped"
                  :sort-by.sync="sortBy"
                  :sort-desc.sync="sortDesc"
                  sort-icon-left
                  :bordered="bordered"
                  :borderless="borderless"
                  :outlined="outlined"
                  :hover="hover"
                  :dark="dark"
                  :fixed="fixed"
                  :foot-clone="footClone"
                  :no-border-collapse="noCollapse"
                  :head-variant="headVariant"
                  :table-variant="tableVariant"
                >
                  <template #cell(selection)="data">
                    <input type="checkbox" :value="data.item.id+' '+data.item.saimtech_power" v-model="selected"  checked="checked" >  
                  </template>
                  <template #cell(Sr.)="data">
                    {{ data.index + 1 }}
                  </template>
                  <template #cell(Company)="data">
                    <p v-if="data.item.saimtech_comp_id ==1">T.M Cargo & Logistics</p>
                    <p v-else>T.M Delivery Express</p>
                  </template> 
                  <template #cell(Date_Posted)="data">
                   {{moment(data.item.saimtech_date).format('MMM Do YYYY')}}
                  </template> 
                  <template id="ignoreAction" #cell(Action)="data">
                    <button type="button" 
                    class="btn btn-danger btn-xs default"  @click="deleteUser(data.item)">Delete
                    </button>
                    <button type="button" class="btn btn-warning btn-xs default" @click="editUser(data.item)">Edit</button>
                  </template>
                </b-table>
                <div class="text-center" v-if="loading">
                 <b-spinner variant="info" class="mt-5 mb-5" style="width: 4rem; height: 4rem;" label="Large Spinner"></b-spinner>
                </div>
                <div class="d-flex mt-3 justify-content-center mb-auto">
                  <b-pagination
                  v-model="currentPage"
                  :total-rows="rows"
                  :per-page="perPage"
                  aria-controls="my-table"
                ></b-pagination>
                </div>
                <div>
                  Total Records: {{totalResults}}
                </div>
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
                <button  v-else-if="editMode && name!='' && email!='' && password!=''  && user_power!=''"  type="submit"  tabindex="5" class="btn btn-primary" @click.prevent="updateUser()">Update</button>
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
    selected: [],
    selectAll: false,
    searchWord:'',
    loading:false,
    sortBy: '',
    sortDesc: false,
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
    filter: null,
    totalResults:'',
    perPage:10,
    pageOptions: [

    5, 10, 25,50,
    { value: this.totalResults, text: "All" }
    ],
    currentPage: 1,
    fields: [
    'selection',
    'Sr.',
    { key: 'saimtech_uname',label:'Name'  },
    { key:'saimtech_email',label:'Email' },
    'Company',
    { key:'saimtech_power',label:'Role' },
    'Date_Posted',
    'Action',
     ],
        striped: false,
        bordered: true,
        borderless: false,
        outlined: false,
        small: false,
        hover: true,
        dark: false,
        fixed: false,
        footClone: false,
        headVariant:'light',
        tableVariant: '',
        noCollapse: false
  },
   methods:{
    selectToggle() {
      this.selected = [];
      if (!this.selectAll) {
        for (let i in this.users) {
          this.selected.push(this.users[i].id+' '+this.users[i].saimtech_power);
        }
      }
      else{
          this.selected=[];
      }
    },
    getUsers(){
          this.users={};
          this.loading = true;
          axios.get('User/getAllUsers').then((response)=>{
          this.users =response.data;
          this.loading = false;
          var jsonObject = response.data;
          this.totalResults  = Object.keys(jsonObject).length;
          })
        },
        createMode(){
        this.clearModel();
        this.editMode =false;
        $('#createUser').modal('show');
        },
    // search(){
    //         //this.noData = false;
    //         this.loading = true;
    //         this.users={};
    //         axios.get('searchUser?s='+this.searchWord).then((response)=>{  
    //         this.loading = false;    
    //         this.users = response.data;
    //         var jsonObject = response.data;
    //         this.totalResults  = Object.keys(jsonObject).length;
    //       }).catch(()=>{
    //       })
    //     },    
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
    deleteUser(rows){ 
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
      form.append("id", this.formId);
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
    },
    exportExcel()
    {
      $('#my-table').tableExport({type:'excel',
                                  ignoreColumn: [6],
                                 });
    },
    exportCsv()
    {

      $('#my-table').tableExport({type:'csv',
                                  ignoreColumn: [6],
                                 });
    },
    exportPdf()
    {
      function DoCellData(cell, row, col, data) {}
      function DoBeforeAutotable(table, headers, rows, AutotableSettings) {}
      $('#my-table').tableExport({type:'pdf',
                                  ignoreColumn: [6],
                           jspdf: {
                                margins: {left:20, right:20, top:20, bottom:20},
                                autotable: {styles: {overflow: 'linebreak'},
                                            tableWidth: 'auto',
                                            tableExport: {onBeforeAutotable: DoBeforeAutotable,
                                                          onCellData: DoCellData}}}
                       });
    }

  },
  created(){
   this.getUsers(); 
  },
  computed: {
      rows() {
        return this.users.length
      }
    }

})   
</script>
<?= $this->endSection() ?>    