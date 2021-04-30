<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Documents</h1>

                    <div class="top-right-button-container">
                        <div class="btn-group">
                            <button class="btn btn-outline-primary btn-lg dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                EXPORT
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" id="dataTablesCopy" href="#">Copy</a>
                                <a class="dropdown-item" id="dataTablesExcel" href="#">Excel</a>
                                <a class="dropdown-item" id="dataTablesCsv" href="#">Csv</a>
                                <a class="dropdown-item" id="dataTablesPdf" href="#">Pdf</a>
                            </div>
                        </div>
                    </div>

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
                    <div class="mb-2">
                        <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions"
                            role="button" aria-expanded="true" aria-controls="displayOptions">
                            Display Options
                            <i class="simple-icon-arrow-down align-middle"></i>
                        </a>
                        <div class="collapse dont-collapse-sm" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="search-sm d-inline-block float-md-left mr-1 mb-1 align-top">
                                    <input class="form-control" placeholder="Search Table" id="searchDatatable">
                                </div>
                            </div>
                            <div class="float-md-right dropdown-as-select" id="pageCountDatatable">
                                <span class="text-muted text-small">Displaying 1-10 of 40 items </span>
                                <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    10
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">5</a>
                                    <a class="dropdown-item active" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2"><button type="button" class="btn btn-outline-primary" @click="createMode">Add New</button></div>
                    <div class="separator"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-4 data-table-rows data-tables-hide-filter">
                    <table id="datatableRows" class="data-table responsive nowrap"
                        data-order="[[ 1, &quot;desc&quot; ]]">
                    <!--     <table id="myTable"> -->
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Employee</th>
                                <th>Action</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(rows, i) in documents">
                                <td>
                                  {{i+1}}
                                </td>
                                <td>
                                    <p class="list-item-heading">{{rows.doc_name}}</p>
                                </td>

                                <td>
                                    <p class="text-muted">{{rows.doc_type}}</p>
                                </td>

                                <td>
                                    <p class="text-muted">{{rows.doc_description}}</p>
                                </td>
                                <td>
                                    <p class="text-muted">{{rows.emp_id}}</p>
                                </td>  
                                <td>
                                  <a v-bind:href="'<?= base_url();?>/public/img/'+rows.doc_path"><button type="button" class="btn btn-info btn-xs" @click="editUser(rows)"><span><i class="glyph-icon simple-icon-cloud-download"></i></span></button>
                                  </a>
                                  <button type="button" class="btn btn-danger btn-xs" @click="deleteDocument(rows)"><span><i class="fa fa-trash" aria-hidden="true"></i></span></button>
                                </td>    
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!------User Add Model ---->      
<div class="modal fade modal-right" id="createDocument" tabindex="-1" role="dialog" aria-labelledby="createDocument" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Create User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- <form> -->

                    <div class="alert alert-info form-group" role="alert">
                        Note: All Fields Required.
                    </div>
                    <div class="form-group required">
                        <label class="has-float-label"><span>Name <font style="color: red;">*</font></span></label>
                        <input v-model="doc_name" type="text" tabindex="1" class="form-control" placeholder="">
                    <p style="color: red" v-if="doc_name_error!=''">{{doc_name_error}}</p>    
                    </div>
                    <div class="form-group">
                        <label class="has-float-label"><span>Description<font style="color: red;">*</font></span></span></label>
                       <input v-model="doc_description" type="text" tabindex="2" class="form-control" placeholder="">
                        <p style="color: red" v-if="doc_description_error!=''">{{doc_description_error}}</p>    
                    </div>
                    <div class="form-group">
                        <label class="has-float-label"><span>Employee<font style="color: red;">*</font></span></label>
                        <select v-model="emp_id" tabindex="4" class="form-control">
                            <option disabled="disabled" value="">Select</option>
                            <option value="4">Talha</option>
                            <option value="5">Usman Azeem</option>
                        </select>
                        <p style="color: red" v-if="emp_id!=''">{{emp_id_error}}</p> 
                    </div>
                    <label>File<font style="color: red;">*</font></label></br>
                    <input v-model="doc_file" type="file" name="onefile" id="onefile">
                    <p style="color: red" v-if="doc_file_error!=''">{{doc_file_error}}</p> 


               
            </div>
            <div class="modal-footer">
                <button type="button"  tabindex="6" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <button v-if=" doc_name!='' && doc_description!='' && doc_file!=''  && emp_id!=''"  type="submit"  tabindex="5" class="btn btn-primary" @click.prevent="postDocument()">Submit</button>

                <button v-else  disabled type="button" tabindex="5" class="btn btn-primary ">Fill For Submit</button>
            </div>
             <!-- </form> -->
        </div>
    </div>
</div>         
    </main>
<script type="text/javascript">
 var app = new Vue({
  el: '#app',
  data: {
    documents:[],
    i:0,
    doc_name:'',
    doc_description:'',
    doc_file:'',
    emp_id:'',
    doc_name_error:'',
    doc_description_error:'',
    doc_file_error:'',
    emp_id_error:'',
  },
   methods:{
   
        getDocuments()
        {
          axios.get('Document/getAllDocuments').then((response)=>{
          this.documents =response.data;
          //console.log(response.data);
          })
        },
        createMode(){
        //this.clearModel();
        $('#createDocument').modal('show');
        },
        postDocument(){
          var oneFile         = $('input[name=onefile]');
          if(oneFile!=''){
          var onefileUpload   = oneFile[0].files[0];   
          }
          else{
            var onefileUpload = '';
          }
          const form = new FormData();
          
          form.append("doc_name", this.doc_name);
          form.append("doc_description", this.doc_description);
          form.append("emp_id", this.emp_id);
          form.append("doc_file", this.doc_file);
          form.append("onefile", onefileUpload);
           axios.post('Document/create',form).then((response)=>{
           $("#createDocument").modal("hide");
           Swal.fire({
              // position: 'top-end',
              icon: 'success',
              title: this.doc_name+' File has been Saved Successfully',
              showConfirmButton: false,
              timer: 2000
            })
            this.clearForm();
            this.clearErrors();
            $('#onefile').val('');
          }).catch(err => {
            this.clearErrors();
            if(err.response.data.messages.doc_name)
            { this.doc_name_error = err.response.data.messages.doc_name; }
          if(err.response.data.messages.doc_description)
            { this.doc_description_error = err.response.data.messages.doc_description; }
          if(err.response.data.messages.emp_id)
            { this.emp_id_error = err.response.data.messages.emp_id; }
          if(err.response.data.messages.onefile)
            { this.doc_file_error = err.response.data.messages.onefile; }
        });
        },
        deleteDocument(rows){
         // alert(rows.doc_id);
           Swal.fire({
          title: 'Are you sure?',
          text: rows.doc_name+" will be deleted permanantly!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {  
              axios.delete('deletedocument/'+rows.doc_id).then(()=>{
                 Swal.fire(
                  'Deleted!',
                  rows.doc_name+' has been deleted.',
                  'success'
                )
                 this.getDocuments();
              }).catch(()=>{
                
            })
            }
          })
        },
        clearErrors()
        {
          this.doc_name_error='';
          this.doc_description_error='';
          this.emp_id_error='';
          this.doc_file_error='';
        },
        clearModel()
        {
          this.doc_name='';
          this.doc_description='';
          this.emp_id='';
          this.doc_file='';
        },
  },
  created(){
   this.getDocuments();
  }

})   
</script>    
<?= $this->endSection() ?>    
