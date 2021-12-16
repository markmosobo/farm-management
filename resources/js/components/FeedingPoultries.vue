<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Feeding Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Grade</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Kienyeji</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Improved Kienyeji</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Other <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                  <a class="dropdown-item" href="#tab_4" tabindex="-1" data-toggle="tab">Exotic</a>
                  <a class="dropdown-item" href="#tab_5" tabindex="-1" data-toggle="tab">Hybrid</a>
                    </div>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feeding Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradedetailModal">
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
                                <th style="width: 10px">Date of Feeding</th>
                                <th>Poultry Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradefeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editgradedetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletegradeFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Detail Modal -->
                        <div class="modal fade" id="gradeDetail" tabindex="-1" role="dialog" aria-labelledby="gradeDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeFeedingDetail() : creategradeFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Fed</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Feed Used</label>  
                                                    <textarea v-model="form.feed_quantity" id="feed_quantity"
                                                    name="feed_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('feed_quantity')" v-html="form.errors.get('feed_quantity')" />
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
                        <pagination :data="gradefeedingdetails" @pagination-change-page="getgradeFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradefeedcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradefeedingcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editgradefeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletegradeFeedCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Feed Cost Modal -->
                        <div class="modal fade" id="gradeFeed" tabindex="-1" role="dialog" aria-labelledby="gradeFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeFeedCost() : creategradeFeedCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
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
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradefeedingcosts" @pagination-change-page="getgradeFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradeothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradefeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editgradeothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletegradeFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Other Cost Modal -->
                        <div class="modal fade" id="gradeOtherCost" tabindex="-1" role="dialog" aria-labelledby="gradeOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeFeedingOtherCost() : creategradeFeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradefeedingcosts" @pagination-change-page="getgradeFeedingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div>                   
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feeding Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejidetailModal">
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
                                <th style="width: 10px">Date of Feeding</th>
                                <th>Poultry Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejifeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editkienyejidetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletekienyejiFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Detail Modal -->
                        <div class="modal fade" id="kienyejiDetail" tabindex="-1" role="dialog" aria-labelledby="kienyejiDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiFeedingDetail() : createkienyejiFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                      
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in kienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Fed</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Feed Used</label>  
                                                    <textarea v-model="form.feed_quantity" id="feed_quantity"
                                                    name="feed_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('feed_quantity')" v-html="form.errors.get('feed_quantity')" />
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
                        <pagination :data="kienyejifeedingdetails" @pagination-change-page="getkienyejiFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejifeedcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejifeedingcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editkienyejifeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletekienyejiFeedingCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Feed Cost Modal -->
                        <div class="modal fade" id="kienyejiFeed" tabindex="-1" role="dialog" aria-labelledby="gradeFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiFeedingCost() : createkienyejiFeedingCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry to Feed</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in kienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
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
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradefeedingcosts" @pagination-change-page="getkienyejiFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejiothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejifeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editkienyejiothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletekienyejiFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Other Cost Modal -->
                        <div class="modal fade" id="kienyejiOtherCost" tabindex="-1" role="dialog" aria-labelledby="kienyejiOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiFeedingOtherCost() : createkienyejiFeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="kienyejifeedingothercosts" @pagination-change-page="getkienyejiFeedingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div> 
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_3">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feeding Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejidetailModal">
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
                                <th style="width: 10px">Date of Feeding</th>
                                <th>Poultry Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejifeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editimprovedkienyejidetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteimprovedkienyejiFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Detail Modal -->
                        <div class="modal fade" id="improvedkienyejiDetail" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiFeedingDetail() : createimprovedkienyejiFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in improvedkienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Fed</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Feed Used</label>  
                                                    <textarea v-model="form.feed_quantity" id="feed_quantity"
                                                    name="feed_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('feed_quantity')" v-html="form.errors.get('feed_quantity')" />
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
                        <pagination :data="improvedkienyejifeedingdetails" @pagination-change-page="getimprovedkienyejiFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejifeedcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejifeedingcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editimprovedkienyejifeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteimprovedkienyejiFeedingCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Feed Cost Modal -->
                        <div class="modal fade" id="improvedkienyejiFeed" tabindex="-1" role="dialog" aria-labelledby="gradeFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiFeedingCost() : createimprovedkienyejiFeedingCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry to Feed</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in gradepoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
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
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="gradefeedingcosts" @pagination-change-page="getimprovedkienyejiFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="improvedkienyejiothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in improvedkienyejifeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editimprovedkienyejiothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteimprovedkienyejiFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- improvedkienyeji Other Cost Modal -->
                        <div class="modal fade" id="improvedkienyejiOtherCost" tabindex="-1" role="dialog" aria-labelledby="improvedkienyejiOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateimprovedkienyejiFeedingOtherCost() : createimprovedkienyejiFeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="improvedkienyejifeedingcosts" @pagination-change-page="getimprovedkienyejiFeedingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div> 
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_4">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feeding Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticdetailModal">
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
                                <th style="width: 10px">Date of Feeding</th>
                                <th>Poultry Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticfeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editexoticdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteexoticFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Detail Modal -->
                        <div class="modal fade" id="exoticDetail" tabindex="-1" role="dialog" aria-labelledby="exoticDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticFeedingDetail() : createexoticFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Fed</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Feed Used</label>  
                                                    <textarea v-model="form.feed_quantity" id="feed_quantity"
                                                    name="feed_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('feed_quantity')" v-html="form.errors.get('feed_quantity')" />
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
                        <pagination :data="exoticfeedingdetails" @pagination-change-page="getexoticFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticfeedcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticfeedingcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editexoticfeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteexoticFeedingCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Feed Cost Modal -->
                        <div class="modal fade" id="exoticFeed" tabindex="-1" role="dialog" aria-labelledby="exoticFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticFeedCost() : createexoticFeedCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in exoticpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
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
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exoticfeedingcosts" @pagination-change-page="getexoticFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticfeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editexoticothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deleteexoticFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Other Cost Modal -->
                        <div class="modal fade" id="exoticOtherCost" tabindex="-1" role="dialog" aria-labelledby="exoticOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticFeedingOtherCost() : createexoticFeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="exoticfeedingcosts" @pagination-change-page="getexoticFeedingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                    </div>
                    <!-- /.col --> 
                      </div>                   
                  </div>
                  <!-- /.tab-pane -->  
                  <div class="tab-pane" id="tab_5">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Feeding Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybriddetailModal">
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
                                <th style="width: 10px">Date of Feeding</th>
                                <th>Poultry Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridfeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.no_of_poultries}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="edithybriddetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletehybridFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Detail Modal -->
                        <div class="modal fade" id="hybridDetail" tabindex="-1" role="dialog" aria-labelledby="hybridDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridFeedingDetail() : createhybridFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Poultry Fed</label>
                                            <input v-model="form.no_of_poultries" type="text" name="no_of_poultries"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_poultries') }">
                                                <div v-if="form.errors.has('no_of_poultries')" v-html="form.errors.get('no_of_poultries')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Feed Used</label>  
                                                    <textarea v-model="form.feed_quantity" id="feed_quantity"
                                                    name="feed_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('feed_quantity')" v-html="form.errors.get('feed_quantity')" />
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
                        <pagination :data="hybridfeedingdetails" @pagination-change-page="gethybridFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridfeedcostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                             
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width:10px">Name</th>
                                <th>Quantity</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridfeedingcosts.data" :key="item.id">
                                <td>
                                    <span v-if="item.feed_type == 'CHICKMASH'" class="badge bg-danger">CHICKMASH</span>
                                    <span v-else-if="item.feed_type == 'BROILERSMASH'" class="badge bg-success">BROILERSMASH</span>
                                    <span v-else-if="item.feed_type == 'LAYERSMASH'" class="badge bg-info">LAYERSMASH</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="edithybridfeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletehybridFeedingCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Feed Cost Modal -->
                        <div class="modal fade" id="hybridFeed" tabindex="-1" role="dialog" aria-labelledby="hybridFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridFeedCost() : createhybridFeedCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <select v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="CHICKMASH">CHICKMASH</option>
                                                    <option value="BROILERSMASH">BROILERSMASH</option>
                                                    <option value="LAYERSMASH">LAYERSMASH</option>
                                                    </select>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in hybridpoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Purchase</label>
                                            <input v-model="form.date_of_purchase" type="date" name="date_of_purchase"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_purchase') }">
                                                <div v-if="form.errors.has('date_of_purchase')" v-html="form.errors.get('date_of_purchase')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Bought</label>
                                            <input v-model="form.quantity_bought" type="text" name="quantity_bought" placeholder="approx quantity (e.g 1 sack)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_bought') }">
                                                <div v-if="form.errors.has('quantity_bought')" v-html="form.errors.get('quantity_bought')" /> 
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
                        <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridfeedingcosts" @pagination-change-page="gethybridFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridothercostModal">
                                <i class="fa fa-plus-square"></i>
                                Add New
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>                  
                            </div>                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date</th>
                                <th>Activity</th>
                                <th style="width: 10px">Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridfeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="edithybridothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletehybridFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Other Cost Modal -->
                        <div class="modal fade" id="hybridOtherCost" tabindex="-1" role="dialog" aria-labelledby="hybridOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridFeedingOtherCost() : createhybridFeedingOtherCost()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Activity</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Payment</label>
                                            <input v-model="form.date_of_payment" type="date" name="date_of_payment"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_payment') }">
                                                <div v-if="form.errors.has('date_of_payment')" v-html="form.errors.get('date_of_payment')" /> 
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
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                        <pagination :data="hybridfeedingcosts" @pagination-change-page="gethybridFeedingOtherCosts"></pagination>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
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
                        poultry_id: '',
                        feed_type: '',
                        feed_quantity: '',
                        date_of_feeding: '',
                        no_of_poultries: '',
                        date_of_purchase: '',
                        quantity_bought: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: ''
                 }),
                 gradepoultrieslist: {},
                 gradefeedingcosts: {},
                 gradefeedingdetails: {},
                 gradefeedingothercosts: {},

                 kienyejipoultrieslist: {},
                 kienyejifeedingcosts: {},
                 kienyejifeedingdetails: {},
                 kienyejifeedingothercosts: {},
                 
                 improvedkienyejipoultrieslist: {},
                 improvedkienyejifeedingcosts: {},
                 improvedkienyejifeedingdetails: {},
                 improvedkienyejifeedingothercosts: {},
                 
                 exoticpoultrieslist: {},
                 exoticfeedingcosts: {},
                 exoticfeedingdetails: {},
                 exoticfeedingothercosts: {},
                 
                hybridpoultrieslist: {},
                hybridfeedingcosts: {},
                hybridfeedingdetails: {},
                hybridfeedingothercosts: {},                 
             }   
        },
        methods: {
            gradedetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeDetail').modal('show');                
            },
            editgradedetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeDetail').modal('show');
                this.form.fill(item)
            },
            creategradeFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/gradefeedingdetail').then(() => {
                    $('#gradeDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingDetails')
                }).catch(() => {
                    this.$$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/gradefeedingdetail/'+this.form.id).then(() => {
                    $('#gradeDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeFeedingDetail(id){
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
                  this.form.delete('api/gradefeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeFeedingDetails');
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
            gradefeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeFeed').modal('show');                
            },
            editgradefeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeFeed').modal('show');
                this.form.fill(item)
            },
            creategradeFeedCost(){
                this.$Progress.start();
                this.form.post('api/gradefeedingcost').then(() => {
                    $('#gradeFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeFeedCost(){
                this.$Progress.start();
                this.form.put('api/gradefeedingcost/'+this.form.id).then(() => {
                    $('#gradeFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeFeedCost(id){
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
                  this.form.delete('api/gradefeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeFeedingCosts');
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
            gradeothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeOtherCost').modal('show');                
            },
            editgradeothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeOtherCost').modal('show');
                this.form.fill(item)
            },
            creategradeFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/gradefeedingothercost').then(() => {
                    $('#gradeOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/gradefeedingothercost/'+this.form.id).then(() => {
                    $('#gradeOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeFeedingOtherCost(id){
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
                  this.form.delete('api/gradefeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeFeedingOtherCosts');
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

            listgradePoultries(){
                axios.get('api/gradepoultrieslist').then((response) => {
                    this.gradepoultrieslist = response.data.data
                });
            },
                        
            loadgradeFeedingDetails(){
                axios.get('api/gradefeedingdetail').then((response) => {
                    this.gradefeedingdetails = response.data
                });
            },
            loadgradeFeedingCosts(){
                axios.get('api/gradefeedingcost').then((response) => {
                    this.gradefeedingcosts = response.data
                });
            },
            loadgradeFeedingOtherCosts(){
                axios.get('api/gradefeedingothercost').then((response) => {
                    this.gradefeedingothercosts = response.data
                });
            },

            //pagination
            getgradeFeedingDetails(page = 1) {
            axios.get('api/gradefeedingdetail?page=' + page)
                .then(response => {
                    this.gradefeedingdetails = response.data;
                })                
            },
            getgradeFeedCosts(page = 1) {
            axios.get('api/gradefeedingcost?page=' + page)
                .then(response => {
                    this.gradefeedingcosts = response.data;
                })                
            },
            getgradeFeedingOtherCosts(page = 1) {
            axios.get('api/gradefeedingothercost?page=' + page)
                .then(response => {
                    this.gradefeedingothercosts = response.data;
                })                
            }, 
            
            //methods for kienyeji poultry
            kienyejidetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiDetail').modal('show');                
            },
            editkienyejidetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiDetail').modal('show');
                this.form.fill(item)
            },
            createkienyejiFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/kienyejifeedingdetail').then(() => {
                    $('#kienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/kienyejifeedingdetail/'+this.form.id).then(() => {
                    $('#kienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiFeedingDetail(id){
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
                  this.form.delete('api/kienyejifeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiFeedingDetails');
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
            kienyejifeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiFeed').modal('show');                
            },
            editkienyejifeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiFeed').modal('show');
                this.form.fill(item)
            },
            createkienyejiFeedingCost(){
                this.$Progress.start();
                this.form.post('api/kienyejifeedingcost').then(() => {
                    $('#kienyejiFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiFeedingCost(){
                this.$Progress.start();
                this.form.put('api/kienyejifeedingcost/'+this.form.id).then(() => {
                    $('#kienyejiFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiFeedingCost(id){
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
                  this.form.delete('api/kienyejifeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiFeedingCosts');
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
            kienyejiothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiOtherCost').modal('show');                
            },
            editkienyejiothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiOtherCost').modal('show');
                this.form.fill(item)
            },
            createkienyejiFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/kienyejifeedingothercost').then(() => {
                    $('#kienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/kienyejifeedingothercost/'+this.form.id).then(() => {
                    $('#kienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiFeedingOtherCost(id){
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
                  this.form.delete('api/kienyejifeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiFeedingOtherCosts');
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

            listkienyejiPoultries(){
                axios.get('api/kienyejipoultrieslist').then((response) => {
                    this.kienyejipoultrieslist = response.data.data
                });
            },
                        
            loadkienyejiFeedingDetails(){
                axios.get('api/kienyejifeedingdetail').then((response) => {
                    this.kienyejifeedingdetails = response.data
                });
            },
            loadkienyejiFeedingCosts(){
                axios.get('api/kienyejifeedingcost').then((response) => {
                    this.kienyejifeedingcosts = response.data
                });
            },
            loadkienyejiFeedingOtherCosts(){
                axios.get('api/kienyejifeedingothercost').then((response) => {
                    this.kienyejifeedingothercosts = response.data
                });
            },

            //pagination
            getkienyejiFeedingDetails(page = 1) {
            axios.get('api/kienyejifeedingdetail?page=' + page)
                .then(response => {
                    this.kienyejifeedingdetails = response.data;
                })                
            },
            getkienyejiFeedCosts(page = 1) {
            axios.get('api/kienyejifeedingcost?page=' + page)
                .then(response => {
                    this.kienyejifeedingcosts = response.data;
                })                
            },
            getkienyejiFeedingOtherCosts(page = 1) {
            axios.get('api/kienyejifeedingothercost?page=' + page)
                .then(response => {
                    this.kienyejifeedingothercosts = response.data;
                })                
            }, 
            
            //methods for improved kienyeji poultry
            improvedkienyejidetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiDetail').modal('show');                
            },
            editimprovedkienyejidetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiDetail').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/improvedkienyejifeedingdetail').then(() => {
                    $('#improvedkienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/improvedkienyejifeedingdetail/'+this.form.id).then(() => {
                    $('#improvedkienyejiDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiFeedingDetail(id){
                this.form.delete('api/improvedkienyejifeedingdetail/'+id).then(() => {
                    console.log('deleted')
                    Fire.$emit('RefreshimprovedkienyejiFeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            improvedkienyejifeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiFeed').modal('show');                
            },
            editimprovedkienyejifeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiFeed').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiFeedingCost(){
                this.$Progress.start();
                this.form.post('api/improvedkienyejifeedingcost').then(() => {
                    $('#improvedkienyejiFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiFeedingCost(){
                this.$Progress.start();
                this.form.put('api/improvedkienyejifeedingcost/'+this.form.id).then(() => {
                    $('#improvedkienyejiFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiFeedingCost(id){
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
                  this.form.delete('api/improvedkienyejifeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiFeedingCosts');
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
            improvedkienyejiothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#improvedkienyejiOtherCost').modal('show');                
            },
            editimprovedkienyejiothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#improvedkienyejiOtherCost').modal('show');
                this.form.fill(item)
            },
            createimprovedkienyejiFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/improvedkienyejifeedingothercost').then(() => {
                    $('#improvedkienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateimprovedkienyejiFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/improvedkienyejifeedingothercost/'+this.form.id).then(() => {
                    $('#improvedkienyejiOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshimprovedkienyejiFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteimprovedkienyejiFeedingOtherCost(id){
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
                  this.form.delete('api/improvedkienyejifeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshimprovedkienyejiFeedingOtherCosts');
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

            listimprovedkienyejiPoultries(){
                axios.get('api/ikienyejipoultrieslist').then((response) => {
                    this.improvedkienyejipoultrieslist = response.data.data
                });
            },
                        
            loadimprovedkienyejiFeedingDetails(){
                axios.get('api/improvedkienyejifeedingdetail').then((response) => {
                    this.improvedkienyejifeedingdetails = response.data
                });
            },
            loadimprovedkienyejiFeedingCosts(){
                axios.get('api/improvedkienyejifeedingcost').then((response) => {
                    this.improvedkienyejifeedingcosts = response.data
                });
            },
            loadimprovedkienyejiFeedingOtherCosts(){
                axios.get('api/improvedkienyejifeedingothercost').then((response) => {
                    this.improvedkienyejifeedingothercosts = response.data
                });
            },

            //pagination
            getimprovedkienyejiFeedingDetails(page = 1) {
            axios.get('api/improvedkienyejifeedingdetail?page=' + page)
                .then(response => {
                    this.improvedkienyejifeedingdetails = response.data;
                })                
            },
            getimprovedkienyejiFeedCosts(page = 1) {
            axios.get('api/improvedkienyejifeedingcost?page=' + page)
                .then(response => {
                    this.improvedkienyejifeedingcosts = response.data;
                })                
            },
            getimprovedkienyejiFeedingOtherCosts(page = 1) {
            axios.get('api/improvedkienyejifeedingothercost?page=' + page)
                .then(response => {
                    this.improvedkienyejifeedingothercosts = response.data;
                })                
            },
            
            //methods for exotic
            exoticdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticDetail').modal('show');                
            },
            editexoticdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticDetail').modal('show');
                this.form.fill(item)
            },
            createexoticFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/exoticfeedingdetail').then(() => {
                    $('#exoticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/exoticfeedingdetail/'+this.form.id).then(() => {
                    $('#exoticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticFeedingDetail(id){
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
                  this.form.delete('api/exoticfeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticFeedingDetails');
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
            exoticfeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticFeed').modal('show');                
            },
            editexoticfeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticFeed').modal('show');
                this.form.fill(item)
            },
            createexoticFeedCost(){
                this.$Progress.start();
                this.form.post('api/exoticfeedingcost').then(() => {
                    $('#exoticFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticFeedCost(){
                this.$Progress.start();
                this.form.put('api/exoticfeedingcost/'+this.form.id).then(() => {
                    $('#exoticFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticFeedingCost(id){
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
                  this.form.delete('api/exoticfeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticFeedingCosts');
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
            exoticothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticOtherCost').modal('show');                
            },
            editexoticothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticOtherCost').modal('show');
                this.form.fill(item)
            },
            createexoticFeedingOtherCost(){
                this.$$Progress.start();
                this.form.post('api/exoticfeedingothercost').then(() => {
                    $('#exoticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/exoticfeedingothercost/'+this.form.id).then(() => {
                    $('#exoticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticFeedingOtherCost(id){
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
                  this.form.delete('api/exoticfeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticFeedingOtherCosts');
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

            listexoticPoultries(){
                axios.get('api/exoticpoultrieslist').then((response) => {
                    this.exoticpoultrieslist = response.data.data
                });
            },
                        
            loadexoticFeedingDetails(){
                axios.get('api/exoticfeedingdetail').then((response) => {
                    this.exoticfeedingdetails = response.data
                });
            },
            loadexoticFeedingCosts(){
                axios.get('api/exoticfeedingcost').then((response) => {
                    this.exoticfeedingcosts = response.data
                });
            },
            loadexoticFeedingOtherCosts(){
                axios.get('api/exoticfeedingothercost').then((response) => {
                    this.exoticfeedingothercosts = response.data
                });
            },

            //pagination
            getexoticFeedingDetails(page = 1) {
            axios.get('api/exoticfeedingdetail?page=' + page)
                .then(response => {
                    this.exoticfeedingdetails = response.data;
                })                
            },
            getexoticFeedCosts(page = 1) {
            axios.get('api/exoticfeedingcost?page=' + page)
                .then(response => {
                    this.exoticfeedingcosts = response.data;
                })                
            },
            getexoticFeedingOtherCosts(page = 1) {
            axios.get('api/exoticfeedingothercost?page=' + page)
                .then(response => {
                    this.exoticfeedingothercosts = response.data;
                })                
            },
            
            //methods for hybrid
            hybriddetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridDetail').modal('show');                
            },
            edithybriddetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridDetail').modal('show');
                this.form.fill(item)
            },
            createhybridFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/hybridfeedingdetail').then(() => {
                    $('#hybridDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/hybridfeedingdetail/'+this.form.id).then(() => {
                    $('#hybridDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridFeedingDetail(id){
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
                  this.form.delete('api/hybridfeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridFeedingDetails');
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
            hybridfeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridFeed').modal('show');                
            },
            edithybridfeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridFeed').modal('show');
                this.form.fill(item)
            },
            createhybridFeedCost(){
                this.$Progress.start();
                this.form.post('api/hybridfeedingcost').then(() => {
                    $('#hybridFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridFeedCost(){
                this.$Progress.start();
                this.form.put('api/hybridfeedingcost/'+this.form.id).then(() => {
                    $('#hybridFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridFeedingCost(id){
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
                  this.form.delete('api/hybridfeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridFeedingCosts');
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
            hybridothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridOtherCost').modal('show');                
            },
            edithybridothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridOtherCost').modal('show');
                this.form.fill(item)
            },
            createhybridFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/hybridfeedingothercost').then(() => {
                    $('#hybridOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/hybridfeedingothercost/'+this.form.id).then(() => {
                    $('#hybridOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridFeedingOtherCosts')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridFeedingOtherCost(id){
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
                  this.form.delete('api/hybridfeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridFeedingOtherCosts');
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

            listhybridPoultries(){
                axios.get('api/hybridpoultrieslist').then((response) => {
                    this.hybridpoultrieslist = response.data.data
                });
            },
                        
            loadhybridFeedingDetails(){
                axios.get('api/hybridfeedingdetail').then((response) => {
                    this.hybridfeedingdetails = response.data
                });
            },
            loadhybridFeedingCosts(){
                axios.get('api/hybridfeedingcost').then((response) => {
                    this.hybridfeedingcosts = response.data
                });
            },
            loadhybridFeedingOtherCosts(){
                axios.get('api/hybridfeedingothercost').then((response) => {
                    this.hybridfeedingothercosts = response.data
                });
            },

            //pagination
            gethybridFeedingDetails(page = 1) {
            axios.get('api/hybridfeedingdetail?page=' + page)
                .then(response => {
                    this.hybridfeedingdetails = response.data;
                })                
            },
            gethybridFeedCosts(page = 1) {
            axios.get('api/hybridfeedingcost?page=' + page)
                .then(response => {
                    this.hybridfeedingcosts = response.data;
                })                
            },
            gethybridFeedingOtherCosts(page = 1) {
            axios.get('api/hybridfeedingothercost?page=' + page)
                .then(response => {
                    this.hybridfeedingothercosts = response.data;
                })                
            },             
        },
        mounted() {
            this.listgradePoultries();
            this.loadgradeFeedingDetails();
            this.loadgradeFeedingCosts();
            this.loadgradeFeedingOtherCosts();

            this.listkienyejiPoultries();
            this.loadkienyejiFeedingDetails();
            this.loadkienyejiFeedingCosts();
            this.loadkienyejiFeedingOtherCosts();
            
            this.listimprovedkienyejiPoultries();
            this.loadimprovedkienyejiFeedingDetails();
            this.loadimprovedkienyejiFeedingCosts();
            this.loadimprovedkienyejiFeedingOtherCosts();
            
            this.listexoticPoultries();
            this.loadexoticFeedingDetails();
            this.loadexoticFeedingCosts();
            this.loadexoticFeedingOtherCosts();
            
            this.listhybridPoultries();
            this.loadhybridFeedingDetails();
            this.loadhybridFeedingCosts();
            this.loadhybridFeedingOtherCosts();            

            //event listeners 
            Fire.$on('RefreshgradeFeedingDetails',() => {
                this.loadgradeFeedingDetails();
            });
            Fire.$on('RefreshgradeFeedingCosts',() => {
                this.loadgradeFeedingCosts();
            });
            Fire.$on('RefreshgradeFeedingOtherCosts',() => {
                this.loadgradeFeedingOtherCosts();
            });  
            Fire.$on('RefreshkienyejiFeedingDetails',() => {
                this.loadkienyejiFeedingDetails();
            });
            Fire.$on('RefreshkienyejiFeedingCosts',() => {
                this.loadkienyejiFeedingCosts();
            });
            Fire.$on('RefreshkienyejiFeedingOtherCosts',() => {
                this.loadkienyejiFeedingOtherCosts();
            });
            Fire.$on('RefreshimprovedkienyejiFeedingDetails',() => {
                this.loadimprovedkienyejiFeedingDetails();
            });
            Fire.$on('RefreshimprovedkienyejiFeedingCosts',() => {
                this.loadimprovedkienyejiFeedingCosts();
            });
            Fire.$on('RefreshimprovedkienyejiFeedingOtherCosts',() => {
                this.loadimprovedkienyejiFeedingOtherCosts();
            });
            Fire.$on('RefreshexoticFeedingDetails',() => {
                this.loadexoticFeedingDetails();
            });
            Fire.$on('RefreshexoticFeedingCosts',() => {
                this.loadexoticFeedingCosts();
            });
            Fire.$on('RefreshexoticFeedingOtherCosts',() => {
                this.loadexoticFeedingOtherCosts();
            });            
            Fire.$on('RefreshhybridFeedingDetails',() => {
                this.loadhybridFeedingDetails();
            });
            Fire.$on('RefreshhybridFeedingCosts',() => {
                this.loadhybridFeedingCosts();
            });
            Fire.$on('RefreshhybridFeedingOtherCosts',() => {
                this.loadhybridFeedingOtherCosts();
            });            
            console.log('Component mounted.')
        }
    }
</script>
