<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Resource Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Purchases</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Sales</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="true">
                      Statement <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(-5px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a class="dropdown-item" tabindex="-1" href="#">Short Statement</a>
                      <div class="dropdown-divider"></div>                      
                      <a class="dropdown-item" tabindex="-1" href="#">Full Statement</a>
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
                            <h3 class="card-title">Resource Purchase Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="resourcepurchaseModal">
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
                                <th style="width: 140px">Date of Purchase</th>
                                <th>Resource Purchased</th>
                                <th>Resource Quantity</th>
                                <th>Seller's Name/Location</th>
                                <th>Amount Paid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in resourcepurchases.data" :key="item.id">
                                <td>{{item.date_of_purchasing}}</td>
                                <td>{{item.resource.name}}</td>
                                <td>{{item.purchase_quantity}}  </td>
                                <td>{{item.source_of_purchase}}</td>
                                <td>
                                    <span class="badge bg-warning">{{item.amount_paid}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editresourcepurchaseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteResourcePurchase(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Resource Purchase Modal -->
                        <div class="modal fade" id="resourcePurchase" tabindex="-1" role="dialog" aria-labelledby="resourcePurchase" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Resource Purchase</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Resource Purchase</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateResourcePurchase() : createResourcePurchase()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Resource</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('resource_id') }" v-model="form.resource_id">
                                            <option value="">Select Resource</option>
                                            <option 
                                                v-for="item in resourceslist.data" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.resource_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('resource_id')" v-html="form.errors.get('resource_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Purchasing</label>
                                            <input v-model="form.date_of_purchasing" type="date" name="date_of_purchasing"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchasing') }">
                                                <div v-if="form.errors.has('date_of_purchasing')" v-html="form.errors.get('date_of_purchasing')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Name/Location of Seller</label>  
                                                    <textarea v-model="form.source_of_purchase" id="source_of_purchase"
                                                    name="source_of_purchase" placeholder="Brief description of who or where resource was bought from (optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('source_of_purchase')" v-html="form.errors.get('source_of_purchase')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Resource Purchased</label>  
                                                    <textarea v-model="form.purchase_quantity" id="purchase_quantity"
                                                    name="purchase_quantity" placeholder="Brief description of the quantity(e.g a 1 bag of charcoal)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('purchase_quantity')" v-html="form.errors.get('purchase_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
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
                        <pagination :data="resourcepurchases" @pagination-change-page="getResourcePurchases"></pagination>
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
                            <h3 class="card-title">Resource Sales Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="resourcesaleModal">
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
                                <th>Resource Sold</th>
                                <th>Quantity Sold</th>
                                <th>Buyer's Name/Location</th>
                                <th>Amount Got</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in resourcesales.data" :key="item.id">
                                <td>{{item.date_of_selling}}</td>
                                <td>{{item.resource.name}}</td>
                                <td>{{item.sale_quantity}}  </td>
                                <td>{{item.source_of_sale}}</td>
                                <td>
                                    <span class="badge bg-warning">{{item.amount_paid}}</span>
                                </td>
                                <td>                                  
                                    <a href="#" @click="editresourcesaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteResourceSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Resource Sale Modal -->
                        <div class="modal fade" id="resourceSale" tabindex="-1" role="dialog" aria-labelledby="resourceSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Resource Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Resource Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateResourceSale() : createResourceSale()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Resource</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('resource_id') }" v-model="form.resource_id">
                                            <option value="">Select Resource</option>
                                            <option 
                                                v-for="item in resourceslist.data" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.resource_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('resource_id')" v-html="form.errors.get('resource_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Selling</label>
                                            <input v-model="form.date_of_selling" type="date" name="date_of_selling"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_selling') }">
                                                <div v-if="form.errors.has('date_of_selling')" v-html="form.errors.get('date_of_selling')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Name/Location of Buyer</label>  
                                                    <textarea v-model="form.source_of_sale" id="source_of_sale"
                                                    name="source_of_sale" placeholder="Brief description of who or where resource was bought from (optional)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('source_of_sale')" v-html="form.errors.get('source_of_sale')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Resource Sold</label>  
                                                    <textarea v-model="form.sale_quantity" id="sale_quantity"
                                                    name="sale_quantity" placeholder="Brief description of the quantity(e.g a 1 bag of charcoal)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('sale_quantity')" v-html="form.errors.get('sale_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_paid" type="text" name="amount_paid"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_paid') }">
                                                <div v-if="form.errors.has('amount_paid')" v-html="form.errors.get('amount_paid')" /> 
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
                        <pagination :data="resourcesales" @pagination-change-page="getResourceSales"></pagination>
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
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
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
                        resource_id: '',
                        date_of_purchasing: '',
                        purchase_quantity: '',
                        source_of_purchase: '',
                        amount_paid: '',
                        date_of_selling: '',
                        sale_quantity: '',
                        source_of_sale: '',
                }),
                resourceslist: {},
                resourcepurchases: {},
                resourcesales: {}
            }
        },
        methods: {
            resourcepurchaseModal(){
                this.editmode = false;
                this.form.reset();
                $('#resourcePurchase').modal('show');                

            },
            editresourcepurchaseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#resourcePurchase').modal('show');
                this.form.fill(item)
            },            
            createResourcePurchase(){
                this.$Progress.start();
                this.form.post('api/resourcepurchase').then(() => {
                    $('#resourcePurchase').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Purchase has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshresourcePurchases')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateResourcePurchase(){
                this.$Progress.start();
                this.form.put('api/resourcepurchase/'+this.form.id).then(() => {
                    $('#resourcePurchase').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Purchase has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshresourcePurchases')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteResourcePurchase(id){
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
                  this.form.delete('api/resourcepurchase/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Purchase has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshresourcePurchases');
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
            listResources(){
                axios.get('api/resource').then((response) => {
                    this.resourceslist = response.data
                });
            },
            loadResourcePurchases(){
                axios.get('api/resourcepurchase').then((response) => {
                    this.resourcepurchases = response.data
                });
            },
            getResourcePurchases(page = 1){
                axios.get('api/resourcepurchase?page=' + page).then(response => {
                    this.resourcepurchases = response.data;
                });
            },

            //sales methods
            resourcesaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#resourceSale').modal('show');                

            },
            editresourcesaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#resourceSale').modal('show');
                this.form.fill(item)
            },            
            createResourceSale(){
                this.$Progress.start();
                this.form.post('api/resourcesale').then(() => {
                    $('#resourceSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshresourceSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateResourceSale(){
                this.$Progress.start();
                this.form.put('api/resourcesale/'+this.form.id).then(() => {
                    $('#resourceSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshresourceSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteResourceSale(id){
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
                  this.form.delete('api/resourcesale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshresourceSales');
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
            loadResourceSales(){
                axios.get('api/resourcesale').then((response) => {
                    this.resourcesales = response.data
                });
            },
            getResourceSales(page = 1){
                axios.get('api/resourcesale?page=' + page).then(response => {
                    this.resourcesales = response.data;
                });
            }           
        },
        mounted() {
            this.listResources();
            this.loadResourcePurchases();
            this.loadResourceSales();

            Fire.$on('RefreshresourcePurchases',() => {
                this.loadResourcePurchases();
            });
            Fire.$on('RefreshresourceSales',() => {
                this.loadResourceSales();
            });            
            console.log('Component mounted.')
        }
    }
</script>
