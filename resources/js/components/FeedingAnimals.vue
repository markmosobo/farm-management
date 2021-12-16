<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Feeding Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Domestic</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Pet</a></li>
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
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticdetailModal">
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
                                <th>Animal Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in domesticfeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'DAIRYMEAL'" class="badge bg-danger">DAIRYMEAL</span>
                                    <span v-else-if="item.feed_type == 'NAPIER'" class="badge bg-success">NAPIER</span>
                                    <span v-else class="badge bg-primary">{{item.feed_type | capitalize}}</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editdomesticdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletedomesticFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Domestic Detail Modal -->
                        <div class="modal fade" id="domesticDetail" tabindex="-1" role="dialog" aria-labelledby="domesticDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticFeedingDetail() : createdomesticFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in domesticanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animals Fed</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <input type="text" list="feeds" v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }" />
                                                    <datalist id="feeds">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="DAIRYMEAL">Dairymeal</option>
                                                    <option value="NAPIER">Napier</option>
                                                    </datalist>
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
                        <pagination :data="domesticfeedingdetails" @pagination-change-page="getdomesticFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Animal Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticfeedcostModal">
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
                                <tr v-for="item in domesticfeedingcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.feed_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editdomesticfeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletedomesticFeedCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Domestic Feed Cost Modal -->
                        <div class="modal fade" id="domesticFeed" tabindex="-1" role="dialog" aria-labelledby="domesticFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Animal Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Animal Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticFeedCost() : createdomesticFeedCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <input type="text" list="dfeeds" v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }" />
                                                    <datalist id="dfeeds">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="DAIRYMEAL">Dairymeal</option>
                                                    <option value="NAPIER">Napier</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in domesticanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
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
                        <pagination :data="domesticfeedingcosts" @pagination-change-page="getdomesticFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="domesticothercostModal">
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
                                <tr v-for="item in domesticfeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editdomesticothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletedomesticFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- domestic Other Cost Modal -->
                        <div class="modal fade" id="domesticOtherCost" tabindex="-1" role="dialog" aria-labelledby="domesticOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatedomesticFeedingOtherCost() : createdomesticFeedingOtherCost()">
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
                        <pagination :data="domesticfeedingcosts" @pagination-change-page="getdomesticFeedingOtherCosts"></pagination>
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
                            <button type="button" class="btn btn-sm btn-primary" @click="petdetailModal">
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
                                <th>Animal Fed</th>
                                <th>No. Fed</th>
                                <th>Type of Feed Given</th>
                                <th>Quantity Consumed</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in petfeedingdetails.data" :key="item.id">
                                <td>{{item.date_of_feeding}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.no_of_animals}}</td>
                                <td>
                                    <span v-if="item.feed_type == 'BONES'" class="badge bg-danger">BONES</span>
                                    <span v-else-if="item.feed_type == 'MILK'" class="badge bg-success">MILK</span>
                                    <span v-else class="badge bg-primary">{{item.feed_type | capitalize}}</span>
                                </td>
                                <td>{{item.feed_quantity}}  </td>
                                <td>                                  
                                    <a href="#" @click="editpetdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetFeedingDetail(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Detail Modal -->
                        <div class="modal fade" id="petDetail" tabindex="-1" role="dialog" aria-labelledby="petDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetFeedingDetail() : createpetFeedingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Feeding</label>
                                            <input v-model="form.date_of_feeding" type="date" name="date_of_feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_feeding') }">
                                                <div v-if="form.errors.has('date_of_feeding')" v-html="form.errors.get('date_of_feeding')" /> 
                                        </div>                                      
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in petanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Animals Fed</label>
                                            <input v-model="form.no_of_animals" type="text" name="no_of_animals"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_animals') }">
                                                <div v-if="form.errors.has('no_of_animals')" v-html="form.errors.get('no_of_animals')" /> 
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Feed Used</label>  
                                                    <input type="text" list="petfeeds" v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }" />
                                                    <datalist id="petfeeds">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="BONES">Bones</option>
                                                    <option value="MILK">Milk</option>
                                                    </datalist>
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
                        <pagination :data="petfeedingdetails" @pagination-change-page="getpetFeedingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Animal Feed Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="petfeedcostModal">
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
                                <tr v-for="item in petfeedingcosts.data" :key="item.id">
                                <td>
                                    <span class="badge bg">{{item.feed_type | capitalize}}</span>
                                </td>
                                <td>{{item.quantity_bought}} </td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editpetfeedcostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetFeedCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Feed Cost Modal -->
                        <div class="modal fade" id="petFeed" tabindex="-1" role="dialog" aria-labelledby="petFeed" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Animal Feed Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Animal Feed Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetFeedingCost() : createpetFeedingCost()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Type of Feed</label>  
                                                    <input type="text" list="petfeeds" v-model="form.feed_type" id="feed_type"
                                                    name="feed_type" class="form-control" :class="{ 'is-invalid': form.errors.has('feed_type') }">
                                                    <datalist id="petfeeds">
                                                    <option value="">Select Feed Type</option>
                                                    <option value="BONES">BONES</option>
                                                    <option value="MILK">MILK</option>
                                                    </datalist>
                                                    <div v-if="form.errors.has('feed_type')" v-html="form.errors.get('feed_type')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Animal to Feed</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in petanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
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
                        <pagination :data="petfeedingcosts" @pagination-change-page="getpetFeedCosts"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       


                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Feeding Costs</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="petothercostModal">
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
                                <tr v-for="item in petfeedingothercosts.data" :key="item.id">
                                <td>{{item.date_of_payment}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.amount_paid}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editpetothercostModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                      <span v-show="$gate.isAdmin()">/</span>
                                    <a href="#" @click="deletepetFeedingOtherCost(item.id)" v-show="$gate.isAdmin()">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- pet Other Cost Modal -->
                        <div class="modal fade" id="petOtherCost" tabindex="-1" role="dialog" aria-labelledby="petOtherCost" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Feeding Other Cost</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Feeding Other Cost</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatepetFeedingOtherCost() : createpetFeedingOtherCost()">
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
                        <pagination :data="petfeedingothercosts" @pagination-change-page="getpetFeedingOtherCosts"></pagination>
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
                        animal_id: '',
                        feed_type: '',
                        feed_quantity: '',
                        date_of_feeding: '',
                        no_of_animals: '',
                        date_of_purchase: '',
                        quantity_bought: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: ''
                 }),
                 domesticanimalslist: {},
                 domesticfeedingcosts: {},
                 domesticfeedingdetails: {},
                 domesticfeedingothercosts: {},

                 petanimalslist: {},
                 petfeedingcosts: {},
                 petfeedingdetails: {},
                 petfeedingothercosts: {},
                                
             }   
        },
        methods: {
            domesticdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticDetail').modal('show');                
            },
            editdomesticdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticDetail').modal('show');
                this.form.fill(item)
            },
            createdomesticFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/domesticfeedingdetail').then(() => {
                    $('#domesticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatedomesticFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/domesticfeedingdetail/'+this.form.id).then(() => {
                    $('#domesticDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletedomesticFeedingDetail(id){
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
                  this.form.delete('api/domesticfeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticFeedingDetails');
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
            domesticfeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticFeed').modal('show');                
            },
            editdomesticfeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticFeed').modal('show');
                this.form.fill(item)
            },
            createdomesticFeedCost(){
                this.$Progress.start();
                this.form.post('api/domesticfeedingcost').then(() => {
                    $('#domesticFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatedomesticFeedCost(){
                this.$Progress.start();
                this.form.put('api/domesticfeedingcost/'+this.form.id).then(() => {
                    $('#domesticFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletedomesticFeedCost(id){
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
                  this.form.delete('api/domesticfeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticFeedingCosts');
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
            domesticothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#domesticOtherCost').modal('show');                
            },
            editdomesticothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#domesticOtherCost').modal('show');
                this.form.fill(item)
            },
            createdomesticFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/domesticfeedingothercost').then(() => {
                    $('#domesticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatedomesticFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/domesticfeedingothercost/'+this.form.id).then(() => {
                    $('#domesticOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshdomesticFeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletedomesticFeedingOtherCost(id){
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
                  this.form.delete('api/domesticfeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshdomesticFeedingOtherCosts');
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

            listdomesticAnimals(){
                axios.get('api/domesticanimalslist').then((response) => {
                    this.domesticanimalslist = response.data.data
                });
            },
                        
            loaddomesticFeedingDetails(){
                axios.get('api/domesticfeedingdetail').then((response) => {
                    this.domesticfeedingdetails = response.data
                });
            },
            loaddomesticFeedingCosts(){
                axios.get('api/domesticfeedingcost').then((response) => {
                    this.domesticfeedingcosts = response.data
                });
            },
            loaddomesticFeedingOtherCosts(){
                axios.get('api/domesticfeedingothercost').then((response) => {
                    this.domesticfeedingothercosts = response.data
                });
            },

            //pagination
            getdomesticFeedingDetails(page = 1) {
            axios.get('api/domesticfeedingdetail?page=' + page)
                .then(response => {
                    this.domesticfeedingdetails = response.data;
                })                
            },
            getdomesticFeedCosts(page = 1) {
            axios.get('api/domesticfeedingcost?page=' + page)
                .then(response => {
                    this.domesticfeedingcosts = response.data;
                })                
            },
            getdomesticFeedingOtherCosts(page = 1) {
            axios.get('api/domesticfeedingothercost?page=' + page)
                .then(response => {
                    this.domesticfeedingothercosts = response.data;
                })                
            }, 
            
            //methods for pet animals
            petdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#petDetail').modal('show');                
            },
            editpetdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petDetail').modal('show');
                this.form.fill(item)
            },
            createpetFeedingDetail(){
                this.$Progress.start();
                this.form.post('api/petfeedingdetail').then(() => {
                    $('#petDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feeding detail has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetFeedingDetail(){
                this.$Progress.start();
                this.form.put('api/petfeedingdetail/'+this.form.id).then(() => {
                    $('#petDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feeding detail has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingDetails')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetFeedingDetail(id){
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
                  this.form.delete('api/petfeedingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feeding detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetFeedingDetails');
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
            petfeedcostModal(){
                this.editmode = false;
                this.form.reset();
                $('#petFeed').modal('show');                
            },
            editpetfeedcostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petFeed').modal('show');
                this.form.fill(item)
            },
            createpetFeedingCost(){
                this.$Progress.start();
                this.form.post('api/petfeedingcost').then(() => {
                    $('#petFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Feed cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetFeedingCost(){
                this.$Progress.start();
                this.form.put('api/petfeedingcost/'+this.form.id).then(() => {
                    $('#petFeed').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Feed cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetFeedingCost(id){
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
                  this.form.delete('api/petfeedingcost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Feed cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetFeedingCosts');
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
            petothercostModal(){
                this.editmode = false;
                this.form.reset();
                $('#petOtherCost').modal('show');                
            },
            editpetothercostModal(item){
                this.editmode = true;
                this.form.reset();
                $('#petOtherCost').modal('show');
                this.form.fill(item)
            },
            createpetFeedingOtherCost(){
                this.$Progress.start();
                this.form.post('api/petfeedingothercost').then(() => {
                    $('#petOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other cost has been created',
                        'success'
                      );                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            }, 
            updatepetFeedingOtherCost(){
                this.$Progress.start();
                this.form.put('api/petfeedingothercost/'+this.form.id).then(() => {
                    $('#petOtherCost').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other cost has been updated',
                        'success'
                    )                    
                    console.log('success')
                    Fire.$emit('RefreshpetFeedingOtherCosts')
                }).catch(() => {
                    console.log('error')
                })
            },
            deletepetFeedingOtherCost(id){
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
                  this.form.delete('api/petfeedingothercost/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other cost has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshpetFeedingOtherCosts');
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

            listpetAnimals(){
                axios.get('api/petanimalslist').then((response) => {
                    this.petanimalslist = response.data.data
                });
            },
                        
            loadpetFeedingDetails(){
                axios.get('api/petfeedingdetail').then((response) => {
                    this.petfeedingdetails = response.data
                });
            },
            loadpetFeedingCosts(){
                axios.get('api/petfeedingcost').then((response) => {
                    this.petfeedingcosts = response.data
                });
            },
            loadpetFeedingOtherCosts(){
                axios.get('api/petfeedingothercost').then((response) => {
                    this.petfeedingothercosts = response.data
                });
            },

            //pagination
            getpetFeedingDetails(page = 1) {
            axios.get('api/petfeedingdetail?page=' + page)
                .then(response => {
                    this.petfeedingdetails = response.data;
                })                
            },
            getpetFeedCosts(page = 1) {
            axios.get('api/petfeedingcost?page=' + page)
                .then(response => {
                    this.petfeedingcosts = response.data;
                })                
            },
            getpetFeedingOtherCosts(page = 1) {
            axios.get('api/petfeedingothercost?page=' + page)
                .then(response => {
                    this.petfeedingothercosts = response.data;
                })                
            }, 
                        
        },
        mounted() {
            this.listdomesticAnimals();
            this.loaddomesticFeedingDetails();
            this.loaddomesticFeedingCosts();
            this.loaddomesticFeedingOtherCosts();

            this.listpetAnimals();
            this.loadpetFeedingDetails();
            this.loadpetFeedingCosts();
            this.loadpetFeedingOtherCosts();
                        

            //event listeners 
            Fire.$on('RefreshdomesticFeedingDetails',() => {
                this.loaddomesticFeedingDetails();
            });
            Fire.$on('RefreshdomesticFeedingCosts',() => {
                this.loaddomesticFeedingCosts();
            });
            Fire.$on('RefreshdomesticFeedingOtherCosts',() => {
                this.loaddomesticFeedingOtherCosts();
            });  
            Fire.$on('RefreshpetFeedingDetails',() => {
                this.loadpetFeedingDetails();
            });
            Fire.$on('RefreshpetFeedingCosts',() => {
                this.loadpetFeedingCosts();
            });
            Fire.$on('RefreshpetFeedingOtherCosts',() => {
                this.loadpetFeedingOtherCosts();
            });
                                  
            console.log('Component mounted.')
        }
    }
</script>
