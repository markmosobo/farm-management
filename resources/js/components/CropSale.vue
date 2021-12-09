<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Crop Sale Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                      Sales <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(-5px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a class="dropdown-item" tabindex="-1" href="#tab_1" data-toggle="tab">Cash Crop</a>
                      <div class="dropdown-divider"></div>                      
                      <a class="dropdown-item" tabindex="-1" href="#tab_2" data-toggle="tab">Subsistence/Cash Crop</a>
                    </div>
                  </li>                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                      Harvests <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(-5px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a class="dropdown-item" tabindex="-1" href="#tab_3" data-toggle="tab">Cash Crop</a>
                      <div class="dropdown-divider"></div>                      
                      <a class="dropdown-item" tabindex="-1" href="#tab_4" data-toggle="tab">Subsistence/Cash Crop</a>
                    </div>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crop Sale Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cropsaleModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 140px">Date of Sale</th>
                                <th>Crop Sold</th>
                                <th>Quantity Sold</th>
                                <th>Buyer's Name/Location</th>
                                <th>Amount Due</th>
                                <th>Status</th>
                                <th style="width: 80px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cropsales.data" :key="item.id">
                                <td>{{item.date_of_selling}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.quantity_sold}}  </td>
                                <td>{{item.name_of_buyer}}</td>
                                <td>
                                    <span class="badge bg-warning">{{item.amount_due}}</span>
                                </td>
                                <td>
                                    <span v-if="item.status == '1' " class="badge badge-success">Paid</span>
                                    <span v-else class="badge badge-primary">Pending</span>                    
                                </td>                                
                                <td>                                  
                                    <a href="#" @click="editcropsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    <a href="#" @click = "changeStatus(item.id)">
                                        <i class="fa fa-upload green"></i>
                                    </a>                                     
                                    <a href="#" @click="deletecropSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- crop Sale Modal -->
                        <div class="modal fade" id="cropSale" tabindex="-1" role="dialog" aria-labelledby="cropSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New crop Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit crop Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecropSale() : createcropSale()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="item in cropslist.data" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.crop_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Selling</label>
                                            <input v-model="form.date_of_selling" type="date" name="date_of_selling"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_selling') }">
                                                <div v-if="form.errors.has('date_of_selling')" v-html="form.errors.get('date_of_selling')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Name/Location of Buyer</label>  
                                                    <textarea v-model="form.name_of_buyer" id="name_of_buyer"
                                                    name="name_of_buyer" placeholder="Brief description of who or where crop was sold to (optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('name_of_buyer')" v-html="form.errors.get('name_of_buyer')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Crop Sold</label>  
                                                    <textarea v-model="form.quantity_sold" id="quantity_sold"
                                                    name="quantity_sold" placeholder="Brief description of the quantity(e.g a 1 bag of charcoal)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('quantity_sold')" v-html="form.errors.get('quantity_sold')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Due</label>
                                            <input v-model="form.amount_due" type="text" name="amount_due"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_due') }">
                                                <div v-if="form.errors.has('amount_due')" v-html="form.errors.get('amount_due')" /> 
                                        </div>                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="cropsales" @pagination-change-page="getcropSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
 
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                  <!-- /.tab-pane --> 
                  <div class="tab-pane" id="tab_2">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crop Sale Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcashcropsaleModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 140px">Date of Sale</th>
                                <th>Crop Sold</th>
                                <th>Quantity Sold</th>
                                <th>Buyer's Name/Location</th>
                                <th>Amount Due</th>
                                <th>Status</th>
                                <th style="width: 80px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashcropsales.data" :key="item.id">
                                <td>{{item.date_of_selling}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.quantity_sold}}  </td>
                                <td>{{item.name_of_buyer}}</td>
                                <td>
                                    <span class="badge bg-warning">{{item.amount_due}}</span>
                                </td>
                                <td>
                                    <span v-if="item.status == '1' " class="badge badge-success">Paid</span>
                                    <span v-else class="badge badge-primary">Pending</span>                    
                                </td>                                
                                <td>                                  
                                    <a href="#" @click="editsubcashcropsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    <a href="#" @click = "changeStatus(item.id)">
                                        <i class="fa fa-upload green"></i>
                                    </a>                                    
                                    
                                    <a href="#" @click="deletesubcashcropSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- subcashcrop Sale Modal -->
                        <div class="modal fade" id="subcashcropSale" tabindex="-1" role="dialog" aria-labelledby="subcashcropSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Crop Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Crop Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubcashcropSale() : createsubcashcropSale()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select subcashcrop</option>
                                            <option 
                                                v-for="item in subcashcropslist.data" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.crop_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Selling</label>
                                            <input v-model="form.date_of_selling" type="date" name="date_of_selling"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_selling') }">
                                                <div v-if="form.errors.has('date_of_selling')" v-html="form.errors.get('date_of_selling')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Name/Location of Buyer</label>  
                                                    <textarea v-model="form.name_of_buyer" id="name_of_buyer"
                                                    name="name_of_buyer" placeholder="Brief description of who or where crop was sold to (optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('name_of_buyer')" v-html="form.errors.get('name_of_buyer')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Crop Sold</label>  
                                                    <textarea v-model="form.quantity_sold" id="quantity_sold"
                                                    name="quantity_sold" placeholder="Brief description of the quantity(e.g a 1 bag of charcoal)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('quantity_sold')" v-html="form.errors.get('quantity_sold')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Due</label>
                                            <input v-model="form.amount_due" type="text" name="amount_due"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_due') }">
                                                <div v-if="form.errors.has('amount_due')" v-html="form.errors.get('amount_due')" /> 
                                        </div>                                                          
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                        <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>  

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="subcashcropsales" @pagination-change-page="getsubcashcropSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
 
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                  <!-- /.tab-pane -->                                      
                  <div class="tab-pane" id="tab_3">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crop Harvest Details</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 140px">Date of Harvest</th>
                                <th>Crop Harvested</th>
                                <th>Quantity Harvested</th>
                                <th>Acreage Harvested</th>
                                <th>Tool(s) or Equipment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cropharvests.data" :key="item.id">
                                <td>{{item.date_of_harvesting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.harvest_quantity}}  </td>
                                <td>{{item.acreage_harvested}}</td>
                                <td>
                                    <span class="badge bg-info">{{item.tools_used | capitalize}}</span>
                                </td>
                                </tr>                              
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
 

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="cropharvests" @pagination-change-page="getcropharvests"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="tab_4">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Crop Harvest Details</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 140px">Date of Harvest</th>
                                <th>Crop Harvested</th>
                                <th>Quantity Harvested</th>
                                <th>Acreage Harvested</th>
                                <th>Tool(s) or Equipment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in subcashcropharvests.data" :key="item.id">
                                <td>{{item.date_of_harvesting}}</td>
                                <td>{{item.crop.name}}</td>
                                <td>{{item.harvest_quantity}}  </td>
                                <td>{{item.acreage_harvested}}</td>
                                <td>
                                    <span class="badge bg-info">{{item.tools_used | capitalize}}</span>
                                </td>
                                </tr>                                
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
 

                        <div class="card-footer">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="subcashcropharvests" @pagination-change-page="getcropharvests"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        
                    </div>
                    <!-- /.col -->
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</template>

<script>
   export default {      
        data() {
            return{
                editmode: false,
                form: new Form({
                        id: '',
                        crop_id: '',
                        date_of_harvesting: '',
                        harvest_quantity: '',
                        acreage_harvested: '',
                        tools_used: '',
                        source_of_harvest: '',
                        amount_paid: '',
                        date_of_selling: '',
                        sale_quantity: '',
                        name_of_buyer: '',
                        amount_due: '',
                        quantity_sold: '',
                        status: ''
                }),
                cropslist: {},
                subcashcropslist: {},
                cropharvests: {},
                subcashcropharvests: {},
                cropsales: {},
                subcashcropsales: {}
            }
        },
        methods: {
            cropharvestModal(){
                this.editmode = false;
                this.form.reset();
                $('#cropharvest').modal('show');                

            },
            editcropharvestModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cropharvest').modal('show');
                this.form.fill(item)
            },            
            createcropharvest(){
                this.$Progress.start();
                this.form.post('api/cropharvest').then(() => {
                    $('#cropharvest').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'harvest has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('Refreshcropharvests')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecropharvest(){
                this.$Progress.start();
                this.form.put('api/cropharvest/'+this.form.id).then(() => {
                    $('#cropharvest').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'harvest has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('Refreshcropharvests')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecropharvest(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/cropharvest/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'harvest has been deleted.',
                    'success'
                  )
                  Fire.$emit('Refreshcropharvests');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },            
            listcrops(){
                axios.get('api/cashcroplist').then((response) => {
                    this.cropslist = response.data
                });
            },
            loadcropharvests(){
                axios.get('api/cropharvest').then((response) => {
                    this.cropharvests = response.data
                });
                axios.get('api/subcashcropharvest').then((response) => {
                    this.subcashcropharvests = response.data
                });                
            },
            getcropharvests(page = 1){
                axios.get('api/cropharvest?page=' + page).then(response => {
                    this.cropharvests = response.data;
                });
            },

            //sales methods
            cropsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#cropSale').modal('show');                

            },
            editcropsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cropSale').modal('show');
                this.form.fill(item)
            },            
            createcropSale(){
                this.$Progress.start();
                this.form.post('api/cropsale').then(() => {
                    $('#cropSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshcropSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecropSale(){
                this.$Progress.start();
                this.form.put('api/cropsale/'+this.form.id).then(() => {
                    $('#cropSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshcropSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecropSale(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/cropsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcropSales');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            }, 
            subcashcropsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#subcashcropSale').modal('show');                

            },
            editsubcashcropsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#subcashcropSale').modal('show');
                this.form.fill(item)
            },            
            createsubcashcropSale(){
                this.$Progress.start();
                this.form.post('api/subcashcropsale').then(() => {
                    $('#subcashcropSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshsubcashcropSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatesubcashcropSale(){
                this.$Progress.start();
                this.form.put('api/subcashcropsale/'+this.form.id).then(() => {
                    $('#subcashcropSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshsubcashcropSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletesubcashcropSale(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                  if (result.isConfirmed) { 
                  //send request to the server
                  this.form.delete('api/subcashcropsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshsubcashcropSales');
                  }).catch(() => {
                  this.$Progress.fail();  
                    Swal.fire(
                    'Failed!',
                    'There was something wrong.',
                    'warning'
                  )
                  }); 
                  }else if(result.isDenied) {
                    console.log('cancelled')
                  }
                                   
                })
            },
            listsubcashCrops(){
                axios.get('api/subcashcroplist').then((response) => {
                    this.subcashcropslist = response.data
                });
            },                                   
            loadcropSales(){
                axios.get('api/cropsale').then((response) => {
                    this.cropsales = response.data
                });                
            },
            getcropSales(page = 1){
                axios.get('api/cropsale?page=' + page).then(response => {
                    this.cropsales = response.data;
                });
            },
            loadsubcashcropSales(){
                axios.get('api/subcashcropsale').then((response) => {
                    this.subcashcropsales = response.data
                });                
            },
            getsubcashcropSales(page = 1){
                axios.get('api/subcashcropsale?page=' + page).then(response => {
                    this.subcashcropsales = response.data;
                });
            },
            changeStatus(id){
                this.$Progress.start();
                Swal.fire({
                  title: 'Do you want to confirm the payment?',
                  showDenyButton: true,
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  denyButtonText: `Don't confirm`,
                }).then((result) => {
                    this.$Progress.finish();
                    if (result.isConfirmed) {
                    axios.post('api/changestatus/'+id).then((response)=>{
                    console.log(response);  
                    Swal.fire('Confirmed!', '', 'success')
                    Fire.$emit('Refresh');
                    }).catch(() => {
                    this.$Progress.fail();
                    console.log('err');  
                    })
                    }else if(result.isDenied){
                    Swal.fire('The payment was not confirmed','','warning')
                    }
                })
            },                       
        },
        mounted() {
            this.listcrops();
            this.listsubcashCrops();
            this.loadcropharvests();
            this.loadcropSales();
            this.loadsubcashcropSales();

            Fire.$on('Refreshcropharvests',() => {
                this.loadcropharvests();
            });
            Fire.$on('RefreshcropSales',() => {
                this.loadcropSales();
            });
            Fire.$on('RefreshsubcashcropSales',() => {
                this.loadsubcashcropSales();
            });                        
            console.log('Component mounted.')
        }
    }
</script>
