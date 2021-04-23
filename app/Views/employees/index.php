<?= $this->extend('layouts/app') ?>
<?= $this->section('main-content') ?>
<main id="app" class="default-transition" style="opacity: 1;">
        <div class="container-fluid disable-text-selection">
            <div class="row">
                <div class="col-12">

                    <div class="mb-3">
                        <h1>Employees</h1>
                        <div class="text-zero top-right-button-container">
                            <a href="<?= base_url();?>/addemployee" type="button" class="btn btn-primary btn-lg top-right-button mr-1">ADD NEW</a>
                            
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

                    </div>

                    <div class="separator mb-5"></div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group typeahead-container">
                        <input type="text" v-model="searchWord"  class="form-control" name="query" id="query" placeholder="Search By First Name, Last Name, Email..."  autocomplete="off" v-on:keyup="search">

                        <div class="input-group-append ">
                            <button type="submit" class="btn btn-primary default" @click="search">
                                <i class="simple-icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator mb-5"></div>
             <div class="row">
                
                        <div v-for="rows in employess" class="col-12 col-md-6 col-lg-4">
                            <div class="card d-flex flex-row mb-4">
                                <a class="d-flex" href="#">
                                    <img alt="Profile"  onerror=this.src="<?= base_url(); ?>/public/img/download.png"  v-bind:src="'<?= base_url(); ?>/' + rows.image" 
                                        class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                </a>
                                <div class=" d-flex flex-grow-1 min-width-zero">
                                    <div
                                        class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                        <div class="min-width-zero">
                                            <a href="#">
                                                <p class="list-item-heading mb-1 truncate">
                                                    {{rows.fname}} {{rows.lname}}
                                                </p>
                                            </a>
                                            <p class="mb-2 text-muted text-small">
                                             {{rows.designation_id}}   
                                            </p>
                                            <a :href="'<?= base_url();?>/update/'+rows.emp_id" target="_blank"><button type="button"
                                                class="btn btn-xs btn-outline-warning ">Edit</button>
                                            </a>
                                            <a v-bind:href="'<?= base_url();?>/detail/'+rows.emp_id" target="_blank"><button type="button"
                                                class="btn btn-xs btn-outline-primary ">View</button>
                                            </a>
                                            
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
             </div>
             <div class="text-center" v-if="loading">
               <b-spinner variant="info" class="mt-5 mb-5" style="width: 4rem; height: 4rem;" label="Large Spinner"></b-spinner>
            </div>
        </div>
</main>
<script type="text/javascript">
 var app = new Vue({
  el: '#app',
  data: {
  searchWord:'',
  loading:false,
  employess : [],
  },
  methods:{
        search(){
            this.employess = [];
            this.loading = true;
            axios.get('search?s='+this.searchWord).then((response)=>{  
             this.loading = false;    
            this.employess = response.data;

          }).catch(()=>{
          })

        },
        getAllEmployees()
        {
          this.loading = true;
          axios.get('getAllEmployees').then((response)=>{  
          this.loading = false;  
           this.employess =response.data;
          }).catch(()=>{
          })
        },
 },
 created()
      {
        this.getAllEmployees();
      },        
  });  
  </script>    
<?= $this->endSection() ?>    
