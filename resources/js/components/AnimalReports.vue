<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Quarterly Animal Report</h5>

                <div class="card-tools">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">General</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Domestic <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                    <ul v-for="item in domesticanimalslist" :key="item.id">
                     <a class="dropdown-item" href="#tab_2" @click="loaddomesticDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                    </ul>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Pet <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                    <ul v-for="item in petanimalslist" :key="item.id">
                     <a class="dropdown-item" href="#tab_3" @click="loadpetDetails(item.id)" tabindex="-1" data-toggle="tab">{{item.name}}</a>
                    </ul>
                    </div>
                  </li>
                </ul>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">                  

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue}}</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{totalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{totalrevenue - totalcosts}}</h5>
                        <span class="description-text">TOTAL PROFIT</span>                                              
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_2">                  

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{domestictotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{domesticfeedingcosts}}</h5>
                        <span class="description-text">FEEDING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{domestictreatingcosts}}</h5>
                        <span class="description-text">TREATING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane --> 

                  <div class="tab-pane" id="tab_3">                                         
               

                  <div class="card-footer">
                    <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">Ksh.{{pettotalcosts}}</h5>
                        <span class="description-text">TOTAL COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">Ksh.{{petfeedingcosts}}</h5>
                        <span class="description-text">FEEDING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                        <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">Ksh.{{pettreatingcosts}}</h5>
                        <span class="description-text">TREATING COST</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                        <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    </div>
                  </div>
                    <!-- /.row -->                    
                  </div>
                  <!-- /.tab-pane -->  
                                                     
                </div>
                <!-- /.tab-content -->                                     
              </div>
              <!-- ./card-body -->

              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
           return {
             id: '',
             name: '',
             totalrevenue: {},
             totalcosts: {},
             domesticanimalslist: {},
             domesticfeedingcosts: {},
             domestictreatingcosts: {},
             domestictotalcosts: {},
             petanimalslist: {},
             petfeedingcosts: {},
             pettreatingcosts: {},
             pettotalcosts: {}
          }   
        },
        methods: {
            listdomesticAnimals(){
                axios.get('api/domesticanimalslist').then((response) => {
                    this.domesticanimalslist = response.data.data
                });
            },
            listpetAnimals(){
                axios.get('api/petanimalslist').then((response) => {
                    this.petanimalslist = response.data.data
                });
            },            
            loaddomesticDetails(id){
              axios.get('api/domestictotalcosts/'+ id).then(({data}) => {
                this.domestictotalcosts = data
              });
              axios.get('api/domesticfeedingcosts/'+ id).then(({data}) => {
                this.domesticfeedingcosts = data
              });              
              axios.get('api/domestictreatingcosts/' + id).then(({data}) => {
                this.domestictreatingcosts = data
              });
            },
            loadpetDetails(id){
              axios.get('api/pettotalcosts/'+ id).then(({data}) => {
                this.pettotalcosts = data
              });
              axios.get('api/petfeedingcosts/'+ id).then(({data}) => {
                this.petfeedingcosts = data
              });              
              axios.get('api/pettreatingcosts/'+ id).then(({data}) => {
                this.pettreatingcosts = data
              });
            },
            loadgeneralDetails(){
              axios.get('api/animalcosts').then(({data}) => {
                this.totalcosts = data
              });
              axios.get('api/animalsales').then(({data}) => {
                this.totalrevenue = data
              });              
            }              
        },
        created() {
         this.listdomesticAnimals();
         this.listpetAnimals(); 
         this.loadgeneralDetails(); 
        }
    }
</script>
