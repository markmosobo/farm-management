<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Poultry Product Records</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Grade</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Kienyeji</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Improved Kienyeji</a></li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                      Other <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" tabindex="-1" href="#tab_4" data-toggle="tab">Exotic</a>
                      <a class="dropdown-item" tabindex="-1" href="#tab_5" data-toggle="tab">Hybrid</a>
                    </div>
                  </li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Laying Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradelayingdetailModal">
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
                                <th style="width: 140px">Date of Laying</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Laid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradelayingdetails.data" :key="item.id">
                                <td>{{item.date_of_laying}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td> {{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editgradelayingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeLayingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Laying Detail Modal -->
                        <div class="modal fade" id="gradeLayingDetail" tabindex="-1" role="dialog" aria-labelledby="gradeLayingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Laying Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Laying Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeLayingDetail() : creategradeLayingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Laying</label>
                                            <input v-model="form.date_of_laying" type="date" name="date_of_laying"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_laying') }">
                                                <div v-if="form.errors.has('date_of_laying')" v-html="form.errors.get('date_of_laying')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Eggs Laid</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="gradelayingdetails" @pagination-change-page="getgradeLayingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Hatching Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradehatchModal">
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
                                <th style="width: 140px">Date of Hatching</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Hatched</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradehatchingdetails.data" :key="item.id">
                                <td>{{item.date_of_hatching}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editgradehatchModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeHatchingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Hatch Modal -->
                        <div class="modal fade" id="gradeHatch" tabindex="-1" role="dialog" aria-labelledby="gradeHatch" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Hatching Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Hatching Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeHatchingDetail() : creategradeHatchingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Hatching</label>
                                            <input v-model="form.date_of_hatching" type="date" name="date_of_hatching"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_hatching') }">
                                                <div v-if="form.errors.has('date_of_hatching')" v-html="form.errors.get('date_of_hatching')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>No of Eggs Hatched</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="gradehatchingdetails" @pagination-change-page="getgradeHatchingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Egg Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradeeggsaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradeeggsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editgradeeggsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeEggSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Egg Sale Modal -->
                        <div class="modal fade" id="gradeEggSale" tabindex="-1" role="dialog" aria-labelledby="gradeEggSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Egg Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Egg Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeEggSale() : creategradeEggSale()">
                                    <div class="modal-body">                                        
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>No. Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="gradeeggsales" @pagination-change-page="getgradeEggSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradepoultrysaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount </th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradepoultrysales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editgradepoultrysaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradePoultrySale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Poultry Sale Modal -->
                        <div class="modal fade" id="gradePoultrySale" tabindex="-1" role="dialog" aria-labelledby="gradePoultrySale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradePoultrySale() : creategradePoultrySale()">
                                    <div class="modal-body">                                       
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="gradepoultrysales" @pagination-change-page="getgradePoultrySales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="gradeotheruseModal">
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
                                <th style="width:140px">Retrieved On </th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in gradeproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.quantity_used}}</td>
                                <td>                                    
                                    <a href="#" @click="editgradeotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletegradeProductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Grade Product Other Use Modal -->
                        <div class="modal fade" id="gradeOtherUse" tabindex="-1" role="dialog" aria-labelledby="gradeOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updategradeProductOtherUse() : creategradeProductOtherUse()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Product Retrieved</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="e.g egg or hen"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Retrieval</label>
                                            <input v-model="form.date_of_retrieval" type="date" name="date_of_retrieval"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_retrieval') }">
                                                <div v-if="form.errors.has('date_of_retrieval')" v-html="form.errors.get('date_of_retrieval')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity and Reason for Consumption</label>
                                            <input v-model="form.quantity_used" type="text" name="quantity_used"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_used') }">
                                                <div v-if="form.errors.has('quantity_used')" v-html="form.errors.get('quantity_used')" /> 
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
                        <pagination :data="gradeproductotheruses" @pagination-change-page="getgradeProductOtherUses"></pagination>
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
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Laying Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejilayingdetailModal">
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
                                <th style="width: 140px">Date of Laying</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Laid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejilayingdetails.data" :key="item.id">
                                <td>{{item.date_of_laying}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editkienyejilayingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiLayingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Laying Detail Modal -->
                        <div class="modal fade" id="kienyejiLayingDetail" tabindex="-1" role="dialog" aria-labelledby="kienyejiLayingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Laying Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Laying Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiLayingDetail() : createkienyejiLayingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Laying</label>
                                            <input v-model="form.date_of_laying" type="date" name="date_of_laying"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_laying') }">
                                                <div v-if="form.errors.has('date_of_laying')" v-html="form.errors.get('date_of_laying')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Eggs Laid</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="kienyejilayingdetails" @pagination-change-page="getkienyejiLayingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Hatching Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejihatchModal">
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
                                <th style="width: 140px">Date of Hatching</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Hatched</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejihatchingdetails.data" :key="item.id">
                                <td>{{item.date_of_hatching}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editkienyejihatchModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteKienyejiHatchingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Kienyeji Hatching Modal -->
                        <div class="modal fade" id="kienyejiHatch" tabindex="-1" role="dialog" aria-labelledby="kienyejiHatch" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Hatching Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Hatching Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiHatchingDetail() : createkienyejiHatchingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Hatching</label>
                                            <input v-model="form.date_of_hatching" type="date" name="date_of_hatching"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_hatching') }">
                                                <div v-if="form.errors.has('date_of_hatching')" v-html="form.errors.get('date_of_hatching')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>No of Eggs Hatched</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="kienyejihatchingdetails" @pagination-change-page="getkienyejiHatchingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Egg Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejieggsaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejieggsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editkienyejieggsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiEggSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- kienyeji Egg Sale Modal -->
                        <div class="modal fade" id="kienyejiEggSale" tabindex="-1" role="dialog" aria-labelledby="kienyejiEggSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Egg Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Egg Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiEggSale() : createkienyejiEggSale()">
                                    <div class="modal-body">                                        
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="kienyejieggsales" @pagination-change-page="getkienyejiEggSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejipoultrysaleModal">
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
                                <th style="width:140px">Date of Sale</th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejipoultrysales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editkienyejipoultrysaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiPoultrySale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- kienyeji Poultry Sale Modal -->
                        <div class="modal fade" id="kienyejiPoultrySale" tabindex="-1" role="dialog" aria-labelledby="kienyejiPoultrySale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiPoultrySale() : createkienyejiPoultrySale()">
                                    <div class="modal-body">                                       
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="kienyejipoultrysales" @pagination-change-page="getkienyejiPoultrySales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="kienyejiotheruseModal">
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
                                <th style="width: 140px">Retrieved On</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in kienyejiproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.quantity_used}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editkienyejiotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletekienyejiProductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- kienyeji Product Other Use Modal -->
                        <div class="modal fade" id="kienyejiOtherUse" tabindex="-1" role="dialog" aria-labelledby="kienyejiOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatekienyejiProductOtherUse() : createkienyejiProductOtherUse()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Product</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Retrieval</label>
                                            <input v-model="form.date_of_retrieval" type="date" name="date_of_retrieval"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_retrieval') }">
                                                <div v-if="form.errors.has('date_of_retrieval')" v-html="form.errors.get('date_of_retrieval')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Used</label>
                                            <input v-model="form.quantity_used" type="text" name="quantity_used"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_used') }">
                                                <div v-if="form.errors.has('quantity_used')" v-html="form.errors.get('quantity_used')" /> 
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
                        <pagination :data="kienyejiproductotheruses" @pagination-change-page="getkienyejiProductOtherUses"></pagination>
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
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Laying Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="ikienyejilayingdetailModal">
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
                                <th style="width: 140px">Date of Laying</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Laid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ikienyejilayingdetails.data" :key="item.id">
                                <td>{{item.date_of_laying}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editikienyejilayingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteikienyejiLayingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- ikienyeji Laying Detail Modal -->
                        <div class="modal fade" id="ikienyejiLayingDetail" tabindex="-1" role="dialog" aria-labelledby="ikienyejiLayingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Laying Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Laying Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateikienyejiLayingDetail() : createikienyejiLayingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Laying</label>
                                            <input v-model="form.date_of_laying" type="date" name="date_of_laying"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_laying') }">
                                                <div v-if="form.errors.has('date_of_laying')" v-html="form.errors.get('date_of_laying')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in ikienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Eggs Laid</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="ikienyejilayingdetails" @pagination-change-page="getikienyejiLayingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Hatching Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="ikienyejihatchModal">
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
                                <th style="width: 140px">Date of Hatching</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Hatched</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ikienyejihatchingdetails.data" :key="item.id">
                                <td>{{item.date_of_hatching}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editikienyejihatchModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteikienyejiHatchingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- ikienyeji Hatching Modal -->
                        <div class="modal fade" id="ikienyejiHatch" tabindex="-1" role="dialog" aria-labelledby="ikienyejiHatch" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Hatching Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Hatching Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateikienyejiHatchingDetail() : createikienyejiHatchingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Hatching</label>
                                            <input v-model="form.date_of_hatching" type="date" name="date_of_hatching"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_hatching') }">
                                                <div v-if="form.errors.has('date_of_hatching')" v-html="form.errors.get('date_of_hatching')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in ikienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>No of Eggs Hatched</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="ikienyejihatchingdetails" @pagination-change-page="getikienyejiHatchingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Egg Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="ikienyejieggsaleModal">
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
                                <th style="width: 140px">Date of Sale</th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ikienyejieggsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editikienyejieggsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteikienyejiEggSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- ikienyeji Egg Sale Modal -->
                        <div class="modal fade" id="ikienyejiEggSale" tabindex="-1" role="dialog" aria-labelledby="ikienyejiEggSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Egg Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Egg Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateikienyejiEggSale() : createikienyejiEggSale()">
                                    <div class="modal-body">                                        
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in ikienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="ikienyejieggsales" @pagination-change-page="getikienyejiEggSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="ikienyejipoultrysaleModal">
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
                                <th style="width: 140px">Date of Sale</th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ikienyejipoultrysales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editikienyejipolutrysaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteikienyejiPoultrySale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- ikienyeji Poultry Sale Modal -->
                        <div class="modal fade" id="ikienyejiPoultrySale" tabindex="-1" role="dialog" aria-labelledby="ikienyejiPoultrySale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateikienyejiPoultrySale() : createikienyejiPoultrySale()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Poultry</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_id') }" v-model="form.poultry_id">
                                            <option value="">Select Poultry</option>
                                            <option 
                                                v-for="item in ikienyejipoultrieslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.poultry_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('poultry_id')" v-html="form.errors.get('poultry_id')" />
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="ikienyejipoultrysales" @pagination-change-page="getikienyejiPoultrySales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="ikienyejiotheruseModal">
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
                                <th style="width: 140px">Retrieved On</th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in ikienyejiproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td><span class="badge bg-warning">{{item.quantity_used}}</span></td>
                                <td>                                    
                                    <a href="#" @click="editikienyejiotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteikienyejiProductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- ikienyeji Product Other Use Modal -->
                        <div class="modal fade" id="ikienyejiOtherUse" tabindex="-1" role="dialog" aria-labelledby="ikienyejiOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateikienyejiProductOtherUse() : createikienyejiProductOtherUse()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Product</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="activity associated with feeding"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Retrieval</label>
                                            <input v-model="form.date_of_retrieval" type="date" name="date_of_retrieval"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_retrieval') }">
                                                <div v-if="form.errors.has('date_of_retrieval')" v-html="form.errors.get('date_of_retrieval')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Used</label>
                                            <input v-model="form.quantity_used" type="text" name="quantity_used"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_used') }">
                                                <div v-if="form.errors.has('quantity_used')" v-html="form.errors.get('quantity_used')" /> 
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
                        <pagination :data="ikienyejiproductotheruses" @pagination-change-page="getikienyejiProductOtherUses"></pagination>
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
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Laying Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticlayingdetailModal">
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
                                <th style="width: 140px">Date of Laying</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Laid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticlayingdetails.data" :key="item.id">
                                <td>{{item.date_of_laying}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td> {{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editexoticlayingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticLayingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Laying Detail Modal -->
                        <div class="modal fade" id="exoticLayingDetail" tabindex="-1" role="dialog" aria-labelledby="exoticLayingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Laying Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Laying Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticLayingDetail() : createexoticLayingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Laying</label>
                                            <input v-model="form.date_of_laying" type="date" name="date_of_laying"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_laying') }">
                                                <div v-if="form.errors.has('date_of_laying')" v-html="form.errors.get('date_of_laying')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Eggs Laid</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="exoticlayingdetails" @pagination-change-page="getexoticLayingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Hatching Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exotichatchModal">
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
                                <th style="width: 140px">Date of Hatching</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Hatched</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exotichatchingdetails.data" :key="item.id">
                                <td>{{item.date_of_hatching}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="editexotichatchModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticHatchingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Hatch Modal -->
                        <div class="modal fade" id="exoticHatch" tabindex="-1" role="dialog" aria-labelledby="exoticHatch" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Hatching Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Hatching Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticHatchingDetail() : createexoticHatchingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Hatching</label>
                                            <input v-model="form.date_of_hatching" type="date" name="date_of_hatching"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_hatching') }">
                                                <div v-if="form.errors.has('date_of_hatching')" v-html="form.errors.get('date_of_hatching')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>No of Eggs Hatched</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="exotichatchingdetails" @pagination-change-page="getexoticHatchingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Egg Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticeggsaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticeggsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editexoticeggsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticEggSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Egg Sale Modal -->
                        <div class="modal fade" id="exoticEggSale" tabindex="-1" role="dialog" aria-labelledby="exoticEggSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Egg Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Egg Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticEggSale() : createexoticEggSale()">
                                    <div class="modal-body">                                        
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>No. Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="exoticeggsales" @pagination-change-page="getexoticEggSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticpoultrysaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount </th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticpoultrysales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editexoticpoultrysaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticPoultrySale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Poultry Sale Modal -->
                        <div class="modal fade" id="exoticPoultrySale" tabindex="-1" role="dialog" aria-labelledby="exoticPoultrySale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticPoultrySale() : createexoticPoultrySale()">
                                    <div class="modal-body">                                       
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="exoticpoultrysales" @pagination-change-page="getexoticPoultrySales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="exoticotheruseModal">
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
                                <th style="width:140px">Retrieved On </th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in exoticproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.quantity_used}}</td>
                                <td>                                    
                                    <a href="#" @click="editexoticotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteexoticProductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- exotic Product Other Use Modal -->
                        <div class="modal fade" id="exoticOtherUse" tabindex="-1" role="dialog" aria-labelledby="exoticOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateexoticProductOtherUse() : createexoticProductOtherUse()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Product Retrieved</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="e.g egg or hen"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Retrieval</label>
                                            <input v-model="form.date_of_retrieval" type="date" name="date_of_retrieval"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_retrieval') }">
                                                <div v-if="form.errors.has('date_of_retrieval')" v-html="form.errors.get('date_of_retrieval')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity and Reason for Consumption</label>
                                            <input v-model="form.quantity_used" type="text" name="quantity_used"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_used') }">
                                                <div v-if="form.errors.has('quantity_used')" v-html="form.errors.get('quantity_used')" /> 
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
                        <pagination :data="exoticproductotheruses" @pagination-change-page="getexoticProductOtherUses"></pagination>
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
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Laying Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridlayingdetailModal">
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
                                <th style="width: 140px">Date of Laying</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Laid</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridlayingdetails.data" :key="item.id">
                                <td>{{item.date_of_laying}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td> {{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="edithybridlayingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridLayingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Laying Detail Modal -->
                        <div class="modal fade" id="hybridLayingDetail" tabindex="-1" role="dialog" aria-labelledby="hybridLayingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Laying Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Laying Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridLayingDetail() : createhybridLayingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Laying</label>
                                            <input v-model="form.date_of_laying" type="date" name="date_of_laying"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_laying') }">
                                                <div v-if="form.errors.has('date_of_laying')" v-html="form.errors.get('date_of_laying')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>No of Eggs Laid</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="hybridlayingdetails" @pagination-change-page="gethybridLayingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Egg-Hatching Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridhatchModal">
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
                                <th style="width: 140px">Date of Hatching</th>
                                <th>Poultry</th>
                                <th>Code</th>
                                <th>No. Hatched</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridhatchingdetails.data" :key="item.id">
                                <td>{{item.date_of_hatching}}</td>
                                <td>{{item.poultry.name}}</td>
                                <td>{{item.poultry_code}}</td>
                                <td>{{item.no_of_eggs}}</td>
                                <td>                                  
                                    <a href="#" @click="edithybridhatchModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridHatchingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Hatch Modal -->
                        <div class="modal fade" id="hybridHatch" tabindex="-1" role="dialog" aria-labelledby="hybridHatch" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Hatching Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Hatching Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridHatchingDetail() : createhybridHatchingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Hatching</label>
                                            <input v-model="form.date_of_hatching" type="date" name="date_of_hatching"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_hatching') }">
                                                <div v-if="form.errors.has('date_of_hatching')" v-html="form.errors.get('date_of_hatching')" /> 
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
                                            <label>Poultry Code</label>
                                            <input v-model="form.poultry_code" type="text" name="poultry_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('poultry_code') }">
                                                <div v-if="form.errors.has('poultry_code')" v-html="form.errors.get('poultry_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>No of Eggs Hatched</label>
                                            <input v-model="form.no_of_eggs" type="text" name="no_of_eggs"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_of_eggs') }">
                                                <div v-if="form.errors.has('no_of_eggs')" v-html="form.errors.get('no_of_eggs')" /> 
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
                        <pagination :data="hybridhatchingdetails" @pagination-change-page="gethybridHatchingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Egg Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybrideggsaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybrideggsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="edithybrideggsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridEggSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Egg Sale Modal -->
                        <div class="modal fade" id="hybridEggSale" tabindex="-1" role="dialog" aria-labelledby="hybridEggSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Egg Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Egg Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridEggSale() : createhybridEggSale()">
                                    <div class="modal-body">                                        
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>No. Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="hybrideggsales" @pagination-change-page="gethybridEggSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Poultry Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridpoultrysaleModal">
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
                                <th style="width:140px">Date of Sale </th>
                                <th>Sold</th>
                                <th >Amount </th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridpoultrysales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="edithybridpoultrysaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridPoultrySale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Poultry Sale Modal -->
                        <div class="modal fade" id="hybridPoultrySale" tabindex="-1" role="dialog" aria-labelledby="hybridPoultrySale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Poultry Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Poultry Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridPoultrySale() : createhybridPoultrySale()">
                                    <div class="modal-body">                                       
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
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Number Sold</label>
                                            <input v-model="form.no_sold" type="text" name="no_sold"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('no_sold') }">
                                                <div v-if="form.errors.has('no_sold')" v-html="form.errors.get('no_sold')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Got</label>
                                            <input v-model="form.amount_got" type="text" name="amount_got"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('amount_got') }">
                                                <div v-if="form.errors.has('amount_got')" v-html="form.errors.get('amount_got')" /> 
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
                        <pagination :data="hybridpoultrysales" @pagination-change-page="gethybridPoultrySales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="hybridotheruseModal">
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
                                <th style="width:140px">Retrieved On </th>
                                <th>Product</th>
                                <th>Reason</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in hybridproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.quantity_used}}</td>
                                <td>                                    
                                    <a href="#" @click="edithybridotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletehybridProductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- hybrid Product Other Use Modal -->
                        <div class="modal fade" id="hybridOtherUse" tabindex="-1" role="dialog" aria-labelledby="hybridOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatehybridProductOtherUse() : createhybridProductOtherUse()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Name of Product Retrieved</label>
                                            <input v-model="form.name" type="text" name="name" placeholder="e.g egg or hen"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Date of Retrieval</label>
                                            <input v-model="form.date_of_retrieval" type="date" name="date_of_retrieval"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_retrieval') }">
                                                <div v-if="form.errors.has('date_of_retrieval')" v-html="form.errors.get('date_of_retrieval')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity and Reason for Consumption</label>
                                            <input v-model="form.quantity_used" type="text" name="quantity_used"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_used') }">
                                                <div v-if="form.errors.has('quantity_used')" v-html="form.errors.get('quantity_used')" /> 
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
                        <pagination :data="hybridproductotheruses" @pagination-change-page="gethybridProductOtherUses"></pagination>
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
                        drug_type: '',
                        drug_quantity: '',
                        vaccine_type: '',
                        vaccine_quantity: '',
                        date_of_vaccinating: '',
                        date_of_treating: '',
                        no_of_poultries: '',
                        date_of_purchase: '',
                        quantity_bought: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: '',
                        poultry_code: '',
                        product_type: '',
                        date_of_laying: '',
                        date_of_hatching: '',
                        no_of_eggs: '',
                        no_sold: '',
                        date_of_sale: '',
                        quantity_used: ''
                 }),
                 gradepoultrieslist: {},
                 gradelayingdetails: {},
                 gradehatchingdetails: {},
                 gradeeggsales: {},
                 gradepoultrysales: {},
                 gradeproductotheruses: {},

                 kienyejipoultrieslist: {},
                 kienyejilayingdetails: {},
                 kienyejihatchingdetails: {},
                 kienyejieggsales: {},
                 kienyejipoultrysales: {},
                 kienyejiproductotheruses: {},
                 
                 ikienyejipoultrieslist: {},
                 ikienyejilayingdetails: {},
                 ikienyejihatchingdetails: {},
                 ikienyejieggsales: {},
                 ikienyejipoultrysales: {},
                 ikienyejiproductotheruses: {}, 
                 
                 exoticpoultrieslist: {},
                 exoticlayingdetails: {},
                 exotichatchingdetails: {},
                 exoticeggsales: {},
                 exoticpoultrysales: {},
                 exoticproductotheruses: {},
                 
                 hybridpoultrieslist: {},
                 hybridlayingdetails: {},
                 hybridhatchingdetails: {},
                 hybrideggsales: {},
                 hybridpoultrysales: {},
                 hybridproductotheruses: {},                 
             }   
        },
        methods: {
            gradelayingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeLayingDetail').modal('show');                
            },
            editgradelayingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeLayingDetail').modal('show');
                this.form.fill(item)
            },
            creategradeLayingDetail(){
                this.$Progress.start();                
                this.form.post('api/gradelayingdetail').then(() => {
                    $('#gradeLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Laying detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeLayingDetail(){
                this.$Progress.start();
                this.form.put('api/gradelayingdetail/'+this.form.id).then(() => {
                    $('#gradeLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Laying detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeLayingDetail(id){
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
                  this.form.delete('api/gradelayingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Laying detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeLayingDetails');
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
            gradehatchModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeHatch').modal('show');                
            },
            editgradehatchModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeHatch').modal('show');
                this.form.fill(item)
            },
            creategradeHatchingDetail(){
                this.$Progress.start();
                this.form.post('api/gradehatchingdetail').then(() => {
                    $('#gradeHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Hatching detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeHatchingDetail(){
                this.$Progress.start();
                this.form.put('api/gradehatchingdetail/'+this.form.id).then(() => {
                    $('#gradeHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Hatching detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeHatchingDetail(id){
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
                  this.form.delete('api/gradehatchingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Hatching detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeHatchingDetails');
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
            gradeeggsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeEggSale').modal('show');                
            },
            editgradeeggsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeEggSale').modal('show');
                this.form.fill(item)
            },
            creategradeEggSale(){
                this.$Progress.start();
                this.form.post('api/gradeeggsale').then(() => {
                    $('#gradeEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Egg sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeEggSale(){
                this.$Progress.start();
                this.form.put('api/gradeeggsale/'+this.form.id).then(() => {
                    $('#gradeEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Egg sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeEggSale(id){
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
                  this.form.delete('api/gradeeggsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Egg sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeEggSales');
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
            gradepoultrysaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradePoultrySale').modal('show');                
            },
            editgradepoultrysaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradePoultrySale').modal('show');
                this.form.fill(item)
            },
            creategradePoultrySale(){
                this.$Progress.start();
                this.form.post('api/gradepoultrysale').then(() => {
                    $('#gradePoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Poultry sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradePoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradePoultrySale(){
                this.$Progress.start();
                this.form.put('api/gradepoultrysale/'+this.form.id).then(() => {
                    $('#gradePoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Poultry sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradePoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradePoultrySale(id){
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
                  this.form.delete('api/gradepoultrysale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradePoultrySales');
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
            gradeotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#gradeOtherUse').modal('show');                
            },
            editgradeotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#gradeOtherUse').modal('show');
                this.form.fill(item)
            },
            creategradeProductOtherUse(){
                this.$Progress.start();
                this.form.post('api/gradeproductotheruse').then(() => {
                    $('#gradeOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshgradeProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updategradeProductOtherUse(){
                this.$Progress.start();
                this.form.put('api/gradeproductotheruse/'+this.form.id).then(() => {
                    $('#gradeOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshgradeProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletegradeProductOtherUse(id){
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
                  this.form.delete('api/gradeproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshgradeProductOtherUses');
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
            loadgradeLayingDetails(){
                axios.get('api/gradelayingdetail').then((response) => {
                    this.gradelayingdetails = response.data
                });
            },                        
            loadgradeHatchingDetails(){
                axios.get('api/gradehatchingdetail').then((response) => {
                    this.gradehatchingdetails = response.data
                });
            },
            loadgradeEggSales(){
                axios.get('api/gradeeggsale').then((response) => {
                    this.gradeeggsales = response.data
                });
            },
            loadgradePoultrySales(){
                axios.get('api/gradepoultrysale').then((response) => {
                    this.gradepoultrysales = response.data
                });
            },            
            loadgradeProductOtherUses(){
                axios.get('api/gradeproductotheruse').then((response) => {
                    this.gradeproductotheruses = response.data
                });
            },

            //pagination
            getgradeLayingDetails(page = 1) {
            axios.get('api/gradelayingdetail?page=' + page)
                .then(response => {
                    this.gradelayingdetails = response.data;
                })                
            },            
            getgradeHatchingDetails(page = 1) {
            axios.get('api/gradehatchingdetail?page=' + page)
                .then(response => {
                    this.gradehatchingdetails = response.data;
                })                
            },
            getgradeEggSales(page = 1) {
            axios.get('api/gradeeggsale?page=' + page)
                .then(response => {
                    this.gradeeggsales = response.data;
                })                
            },
            getgradePoultrySales(page = 1) {
            axios.get('api/gradepoultrysale?page=' + page)
                .then(response => {
                    this.gradepoultrysales = response.data;
                })                
            },            
            getgradeProductOtherUses(page = 1) {
            axios.get('api/gradeproductotheruse?page=' + page)
                .then(response => {
                    this.gradeproductotheruses = response.data;
                })                
            }, 
            
            //methods for kienyeji poultry
            kienyejilayingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiLayingDetail').modal('show');                
            },
            editkienyejilayingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiLayingDetail').modal('show');
                this.form.fill(item)
            },
            createkienyejiLayingDetail(){
                this.$Progress.start();                
                this.form.post('api/kienyejilayingdetail').then(() => {
                    $('#kienyejiLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Laying detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiLayingDetail(){
                this.$Progress.start();
                this.form.put('api/kienyejilayingdetail/'+this.form.id).then(() => {
                    $('#kienyejiLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Laying detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiLayingDetail(id){
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
                  this.form.delete('api/kienyejilayingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Laying Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiLayingDetails');
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
            kienyejihatchModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiHatch').modal('show');                
            },
            editkienyejihatchModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiHatch').modal('show');
                this.form.fill(item)
            },
            createkienyejiHatchingDetail(){
                this.$Progress.start();
                this.form.post('api/kienyejihatchingdetail').then(() => {
                    $('#kienyejiHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Hatching detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiHatchingDetail(){
                this.$Progress.start();
                this.form.put('api/kienyejihatchingdetail/'+this.form.id).then(() => {
                    $('#kienyejiHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Hatching detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiHatchingDetail(id){
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
                  this.form.delete('api/kienyejihatchingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Hatching detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiHatchingDetails');
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
            kienyejieggsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiEggSale').modal('show');                
            },
            editkienyejieggsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiEggSale').modal('show');
                this.form.fill(item)
            },
            createkienyejiEggSale(){
                this.$Progress.start();
                this.form.post('api/kienyejieggsale').then(() => {
                    $('#kienyejiEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Egg sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiEggSale(){
                this.$Progress.start();
                this.form.put('api/kienyejieggsale/'+this.form.id).then(() => {
                    $('#kienyejiEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Egg sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiEggSale(id){
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
                  this.form.delete('api/kienyejieggsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Egg sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiEggSales');
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
            kienyejipoultrysaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiPoultrySale').modal('show');                
            },
            editkienyejipoultrysaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiPoultrySale').modal('show');
                this.form.fill(item)
            },
            createkienyejiPoultrySale(){
                this.$Progress.start();
                this.form.post('api/kienyejipoultrysale').then(() => {
                    $('#kienyejiPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Poultry sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiPoultrySale(){
                this.$Progress.start();
                this.form.put('api/kienyejipoultrysale/'+this.form.id).then(() => {
                    $('#kienyejiPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Poultry sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiPoultrySale(id){
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
                  this.form.delete('api/kienyejipoultrysale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiPoultrySales');
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
            kienyejiotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#kienyejiOtherUse').modal('show');                
            },
            editkienyejiotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#kienyejiOtherUse').modal('show');
                this.form.fill(item)
            },
            createkienyejiProductOtherUse(){
                this.$Progress.start();
                this.form.post('api/kienyejiproductotheruse').then(() => {
                    $('#kienyejiOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshkienyejiProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatekienyejiProductOtherUse(){
                this.$Progress.start();
                this.form.put('api/kienyejiproductotheruse/'+this.form.id).then(() => {
                    $('#kienyejiOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshkienyejiProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletekienyejiProductOtherUse(id){
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
                  this.form.delete('api/kienyejiproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshkienyejiProductOtherUses');
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
            loadkienyejiLayingDetails(){
                axios.get('api/kienyejilayingdetail').then((response) => {
                    this.kienyejilayingdetails = response.data
                });
            },                        
            loadkienyejiHatchingDetails(){
                axios.get('api/kienyejihatchingdetail').then((response) => {
                    this.kienyejihatchingdetails = response.data
                });
            },
            loadkienyejiEggSales(){
                axios.get('api/kienyejieggsale').then((response) => {
                    this.kienyejieggsales = response.data
                });
            },
            loadkienyejiPoultrySales(){
                axios.get('api/kienyejipoultrysale').then((response) => {
                    this.kienyejipoultrysales = response.data
                });
            },            
            loadkienyejiProductOtherUses(){
                axios.get('api/kienyejiproductotheruse').then((response) => {
                    this.kienyejiproductotheruses = response.data
                });
            },

            //pagination
            getkienyejiLayingDetails(page = 1) {
            axios.get('api/kienyejilayingdetail?page=' + page)
                .then(response => {
                    this.kienyejilayingdetails = response.data;
                })                
            },            
            getkienyejiHatchingDetails(page = 1) {
            axios.get('api/kienyejihatchingdetail?page=' + page)
                .then(response => {
                    this.kienyejihatchingdetails = response.data;
                })                
            },
            getkienyejiEggSales(page = 1) {
            axios.get('api/kienyejieggsale?page=' + page)
                .then(response => {
                    this.kienyejieggsales = response.data;
                })                
            },
            getkienyejiPoultrySales(page = 1) {
            axios.get('api/kienyejipoultrysale?page=' + page)
                .then(response => {
                    this.kienyejipoultrysales = response.data;
                })                
            },            
            getkienyejiProductOtherUses(page = 1) {
            axios.get('api/kienyejiproductotheruse?page=' + page)
                .then(response => {
                    this.kienyejiproductotheruses = response.data;
                })                
            },  
            
            //methods for improved kienyeji poultry
            ikienyejilayingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#ikienyejiLayingDetail').modal('show');                
            },
            editikienyejilayingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#ikienyejiLayingDetail').modal('show');
                this.form.fill(item)
            },
            createikienyejiLayingDetail(){
                this.$Progress.start();                
                this.form.post('api/ikienyejilayingdetail').then(() => {
                    $('#ikienyejiLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Laying detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshikienyejiLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateikienyejiLayingDetail(){
                this.$Progress.start();
                this.form.put('api/ikienyejilayingdetail/'+this.form.id).then(() => {
                    $('#ikienyejiLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Laying detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshikienyejiLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteikienyejiLayingDetail(id){
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
                  this.form.delete('api/ikienyejilayingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Laying detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshikienyejiLayingDetails');
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
            ikienyejihatchModal(){
                this.editmode = false;
                this.form.reset();
                $('#ikienyejiHatch').modal('show');                
            },
            editikienyejihatchModal(item){
                this.editmode = true;
                this.form.reset();
                $('#ikienyejiHatch').modal('show');
                this.form.fill(item)
            },
            createikienyejiHatchingDetail(){
                this.$Progress.start();
                this.form.post('api/ikienyejihatchingdetail').then(() => {
                    $('#ikienyejiHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Hatching detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshikienyejiHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateikienyejiHatchingDetail(){
                this.$Progress.start();
                this.form.put('api/ikienyejihatchingdetail/'+this.form.id).then(() => {
                    $('#ikienyejiHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Hatching detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshikienyejiHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteikienyejiHatchingDetail(id){
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
                  this.form.delete('api/ikienyejihatchingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Hatching detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshikienyejiHatchingDetails');
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
            ikienyejieggsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#ikienyejiEggSale').modal('show');                
            },
            editikienyejieggsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#ikienyejiEggSale').modal('show');
                this.form.fill(item)
            },
            createikienyejiEggSale(){
                this.$Progress.start();
                this.form.post('api/ikienyejieggsale').then(() => {
                    $('#ikienyejiEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Egg sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshikienyejiEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateikienyejiEggSale(){
                this.$Progress.start();
                this.form.put('api/ikienyejieggsale/'+this.form.id).then(() => {
                    $('#ikienyejiEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Egg sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshikienyejiEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteikienyejiEggSale(id){
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
                  this.form.delete('api/ikienyejieggsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Egg sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshikienyejiEggSales');
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
            ikienyejipoultrysaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#ikienyejiPoultrySale').modal('show');                
            },
            editikienyejipoultrysaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#ikienyejiPoultrySale').modal('show');
                this.form.fill(item)
            },
            createikienyejiPoultrySale(){
                this.$Progress.start();
                this.form.post('api/ikienyejipoultrysale').then(() => {
                    $('#ikienyejiPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Poultry sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshikienyejiPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateikienyejiPoultrySale(){
                this.$Progress.start();
                this.form.put('api/ikienyejipoultrysale/'+this.form.id).then(() => {
                    $('#ikienyejiPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Poultry sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshikienyejiPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteikienyejiPoultrySale(id){
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
                  this.form.delete('api/ikienyejipoultrysale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshikienyejiPoultrySales');
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
            ikienyejiotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#ikienyejiOtherUse').modal('show');                
            },
            editikienyejiotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#ikienyejiOtherUse').modal('show');
                this.form.fill(item)
            },
            createikienyejiProductOtherUse(){
                this.$Progress.start();
                this.form.post('api/ikienyejiproductotheruse').then(() => {
                    $('#ikienyejiOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshikienyejiProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateikienyejiProductOtherUse(){
                this.$Progress.start();
                this.form.put('api/ikienyejiproductotheruse/'+this.form.id).then(() => {
                    $('#ikienyejiOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshikienyejiProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteikienyejiProductOtherUse(id){
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
                  this.form.delete('api/ikienyejiproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshikienyejiProductOtherUses');
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

            listikienyejiPoultries(){
                axios.get('api/ikienyejipoultrieslist').then((response) => {
                    this.ikienyejipoultrieslist = response.data.data
                });
            },
            loadikienyejiLayingDetails(){
                axios.get('api/ikienyejilayingdetail').then((response) => {
                    this.ikienyejilayingdetails = response.data
                });
            },                        
            loadikienyejiHatchingDetails(){
                axios.get('api/ikienyejihatchingdetail').then((response) => {
                    this.ikienyejihatchingdetails = response.data
                });
            },
            loadikienyejiEggSales(){
                axios.get('api/ikienyejieggsale').then((response) => {
                    this.ikienyejieggsales = response.data
                });
            },
            loadikienyejiPoultrySales(){
                axios.get('api/ikienyejipoultrysale').then((response) => {
                    this.ikienyejipoultrysales = response.data
                });
            },            
            loadikienyejiProductOtherUses(){
                axios.get('api/ikienyejiproductotheruse').then((response) => {
                    this.ikienyejiproductotheruses = response.data
                });
            },

            //pagination
            getikienyejiLayingDetails(page = 1) {
            axios.get('api/ikienyejilayingdetail?page=' + page)
                .then(response => {
                    this.ikienyejilayingdetails = response.data;
                })                
            },            
            getikienyejiHatchingDetails(page = 1) {
            axios.get('api/ikienyejihatchingdetail?page=' + page)
                .then(response => {
                    this.ikienyejihatchingdetails = response.data;
                })                
            },
            getikienyejiEggSales(page = 1) {
            axios.get('api/ikienyejieggsale?page=' + page)
                .then(response => {
                    this.ikienyejieggsales = response.data;
                })                
            },
            getikienyejiPoultrySales(page = 1) {
            axios.get('api/ikienyejipoultrysale?page=' + page)
                .then(response => {
                    this.ikienyejipoultrysales = response.data;
                })                
            },            
            getikienyejiProductOtherUses(page = 1) {
            axios.get('api/ikienyejiproductotheruse?page=' + page)
                .then(response => {
                    this.ikienyejiproductotheruses = response.data;
                })                
            },
            
            //methods for exotic
            exoticlayingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticLayingDetail').modal('show');                
            },
            editexoticlayingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticLayingDetail').modal('show');
                this.form.fill(item)
            },
            createexoticLayingDetail(){
                this.$Progress.start();                
                this.form.post('api/exoticlayingdetail').then(() => {
                    $('#exoticLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Laying detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticLayingDetail(){
                this.$Progress.start();
                this.form.put('api/exoticlayingdetail/'+this.form.id).then(() => {
                    $('#exoticLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Laying detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticLayingDetail(id){
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
                  this.form.delete('api/exoticlayingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Laying detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticLayingDetails');
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
            exotichatchModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticHatch').modal('show');                
            },
            editexotichatchModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticHatch').modal('show');
                this.form.fill(item)
            },
            createexoticHatchingDetail(){
                this.$Progress.start();
                this.form.post('api/exotichatchingdetail').then(() => {
                    $('#exoticHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Hatching detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticHatchingDetail(){
                this.$Progress.start();
                this.form.put('api/exotichatchingdetail/'+this.form.id).then(() => {
                    $('#exoticHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Hatching detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticHatchingDetail(id){
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
                  this.form.delete('api/exotichatchingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Hatching detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticHatchingDetails');
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
            exoticeggsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticEggSale').modal('show');                
            },
            editexoticeggsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticEggSale').modal('show');
                this.form.fill(item)
            },
            createexoticEggSale(){
                this.$Progress.start();
                this.form.post('api/exoticeggsale').then(() => {
                    $('#exoticEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Egg sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticEggSale(){
                this.$Progress.start();
                this.form.put('api/exoticeggsale/'+this.form.id).then(() => {
                    $('#exoticEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Egg sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticEggSale(id){
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
                  this.form.delete('api/exoticeggsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Egg sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticEggSales');
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
            exoticpoultrysaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticPoultrySale').modal('show');                
            },
            editexoticpoultrysaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticPoultrySale').modal('show');
                this.form.fill(item)
            },
            createexoticPoultrySale(){
                this.$Progress.start();
                this.form.post('api/exoticpoultrysale').then(() => {
                    $('#exoticPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Poultry sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticPoultrySale(){
                this.$Progress.start();
                this.form.put('api/exoticpoultrysale/'+this.form.id).then(() => {
                    $('#exoticPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Poultry sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticPoultrySale(id){
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
                  this.form.delete('api/exoticpoultrysale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticPoultrySales');
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
            exoticotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#exoticOtherUse').modal('show');                
            },
            editexoticotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#exoticOtherUse').modal('show');
                this.form.fill(item)
            },
            createexoticProductOtherUse(){
                this.$Progress.start();
                this.form.post('api/exoticproductotheruse').then(() => {
                    $('#exoticOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshexoticProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateexoticProductOtherUse(){
                this.$Progress.start();
                this.form.put('api/exoticproductotheruse/'+this.form.id).then(() => {
                    $('#exoticOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshexoticProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteexoticProductOtherUse(id){
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
                  this.form.delete('api/exoticproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshexoticProductOtherUses');
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
            loadexoticLayingDetails(){
                axios.get('api/exoticlayingdetail').then((response) => {
                    this.exoticlayingdetails = response.data
                });
            },                        
            loadexoticHatchingDetails(){
                axios.get('api/exotichatchingdetail').then((response) => {
                    this.exotichatchingdetails = response.data
                });
            },
            loadexoticEggSales(){
                axios.get('api/exoticeggsale').then((response) => {
                    this.exoticeggsales = response.data
                });
            },
            loadexoticPoultrySales(){
                axios.get('api/exoticpoultrysale').then((response) => {
                    this.exoticpoultrysales = response.data
                });
            },            
            loadexoticProductOtherUses(){
                axios.get('api/exoticproductotheruse').then((response) => {
                    this.exoticproductotheruses = response.data
                });
            },

            //pagination
            getexoticLayingDetails(page = 1) {
            axios.get('api/exoticlayingdetail?page=' + page)
                .then(response => {
                    this.exoticlayingdetails = response.data;
                })                
            },            
            getexoticHatchingDetails(page = 1) {
            axios.get('api/exotichatchingdetail?page=' + page)
                .then(response => {
                    this.exotichatchingdetails = response.data;
                })                
            },
            getexoticEggSales(page = 1) {
            axios.get('api/exoticeggsale?page=' + page)
                .then(response => {
                    this.exoticeggsales = response.data;
                })                
            },
            getexoticPoultrySales(page = 1) {
            axios.get('api/exoticpoultrysale?page=' + page)
                .then(response => {
                    this.exoticpoultrysales = response.data;
                })                
            },            
            getexoticProductOtherUses(page = 1) {
            axios.get('api/exoticproductotheruse?page=' + page)
                .then(response => {
                    this.exoticproductotheruses = response.data;
                })                
            }, 
            
            //methods for hybrid
            hybridlayingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridLayingDetail').modal('show');                
            },
            edithybridlayingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridLayingDetail').modal('show');
                this.form.fill(item)
            },
            createhybridLayingDetail(){
                this.$Progress.start();                
                this.form.post('api/hybridlayingdetail').then(() => {
                    $('#hybridLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Laying detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridLayingDetail(){
                this.$Progress.start();
                this.form.put('api/hybridlayingdetail/'+this.form.id).then(() => {
                    $('#hybridLayingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Laying detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridLayingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridLayingDetail(id){
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
                  this.form.delete('api/hybridlayingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Laying detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridLayingDetails');
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
            hybridhatchModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridHatch').modal('show');                
            },
            edithybridhatchModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridHatch').modal('show');
                this.form.fill(item)
            },
            createhybridHatchingDetail(){
                this.$Progress.start();
                this.form.post('api/hybridhatchingdetail').then(() => {
                    $('#hybridHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Hatching detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridHatchingDetail(){
                this.$Progress.start();
                this.form.put('api/hybridhatchingdetail/'+this.form.id).then(() => {
                    $('#hybridHatch').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Hatching detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridHatchingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridHatchingDetail(id){
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
                  this.form.delete('api/hybridhatchingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Hatching detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridHatchingDetails');
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
            hybrideggsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridEggSale').modal('show');                
            },
            edithybrideggsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridEggSale').modal('show');
                this.form.fill(item)
            },
            createhybridEggSale(){
                this.$Progress.start();
                this.form.post('api/hybrideggsale').then(() => {
                    $('#hybridEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Egg sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridEggSale(){
                this.$Progress.start();
                this.form.put('api/hybrideggsale/'+this.form.id).then(() => {
                    $('#hybridEggSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Egg sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridEggSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridEggSale(id){
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
                  this.form.delete('api/hybrideggsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Egg sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridEggSales');
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
            hybridpoultrysaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridPoultrySale').modal('show');                
            },
            edithybridpoultrysaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridPoultrySale').modal('show');
                this.form.fill(item)
            },
            createhybridPoultrySale(){
                this.$Progress.start();
                this.form.post('api/hybridpoultrysale').then(() => {
                    $('#hybridPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Poultry sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridPoultrySale(){
                this.$Progress.start();
                this.form.put('api/hybridpoultrysale/'+this.form.id).then(() => {
                    $('#hybridPoultrySale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Poultry sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridPoultrySales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridPoultrySale(id){
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
                  this.form.delete('api/hybridpoultrysale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Poultry sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridPoultrySales');
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
            hybridotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#hybridOtherUse').modal('show');                
            },
            edithybridotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#hybridOtherUse').modal('show');
                this.form.fill(item)
            },
            createhybridProductOtherUse(){
                this.$Progress.start();
                this.form.post('api/hybridproductotheruse').then(() => {
                    $('#hybridOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshhybridProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatehybridProductOtherUse(){
                this.$Progress.start();
                this.form.put('api/hybridproductotheruse/'+this.form.id).then(() => {
                    $('#hybridOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshhybridProductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletehybridProductOtherUse(id){
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
                  this.form.delete('api/hybridproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshhybridProductOtherUses');
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
            loadhybridLayingDetails(){
                axios.get('api/hybridlayingdetail').then((response) => {
                    this.hybridlayingdetails = response.data
                });
            },                        
            loadhybridHatchingDetails(){
                axios.get('api/hybridhatchingdetail').then((response) => {
                    this.hybridhatchingdetails = response.data
                });
            },
            loadhybridEggSales(){
                axios.get('api/hybrideggsale').then((response) => {
                    this.hybrideggsales = response.data
                });
            },
            loadhybridPoultrySales(){
                axios.get('api/hybridpoultrysale').then((response) => {
                    this.hybridpoultrysales = response.data
                });
            },            
            loadhybridProductOtherUses(){
                axios.get('api/hybridproductotheruse').then((response) => {
                    this.hybridproductotheruses = response.data
                });
            },

            //pagination
            gethybridLayingDetails(page = 1) {
            axios.get('api/hybridlayingdetail?page=' + page)
                .then(response => {
                    this.hybridlayingdetails = response.data;
                })                
            },            
            gethybridHatchingDetails(page = 1) {
            axios.get('api/hybridhatchingdetail?page=' + page)
                .then(response => {
                    this.hybridhatchingdetails = response.data;
                })                
            },
            gethybridEggSales(page = 1) {
            axios.get('api/hybrideggsale?page=' + page)
                .then(response => {
                    this.hybrideggsales = response.data;
                })                
            },
            gethybridPoultrySales(page = 1) {
            axios.get('api/hybridpoultrysale?page=' + page)
                .then(response => {
                    this.hybridpoultrysales = response.data;
                })                
            },            
            gethybridProductOtherUses(page = 1) {
            axios.get('api/hybridproductotheruse?page=' + page)
                .then(response => {
                    this.hybridproductotheruses = response.data;
                })                
            },             
        },
        mounted() {
            this.listgradePoultries();
            this.loadgradeLayingDetails();
            this.loadgradeHatchingDetails();
            this.loadgradeEggSales();
            this.loadgradePoultrySales();
            this.loadgradeProductOtherUses();

            this.listkienyejiPoultries();
            this.loadkienyejiLayingDetails();
            this.loadkienyejiHatchingDetails();
            this.loadkienyejiEggSales();
            this.loadkienyejiPoultrySales();
            this.loadkienyejiProductOtherUses();
            
            this.listikienyejiPoultries();
            this.loadikienyejiLayingDetails();
            this.loadikienyejiHatchingDetails();
            this.loadikienyejiEggSales();
            this.loadikienyejiPoultrySales();
            this.loadikienyejiProductOtherUses();
            
            this.listexoticPoultries();
            this.loadexoticLayingDetails();
            this.loadexoticHatchingDetails();
            this.loadexoticEggSales();
            this.loadexoticPoultrySales();
            this.loadexoticProductOtherUses();
            
            this.listhybridPoultries();
            this.loadhybridLayingDetails();
            this.loadhybridHatchingDetails();
            this.loadhybridEggSales();
            this.loadhybridPoultrySales();
            this.loadhybridProductOtherUses();            

            //event listeners 
            Fire.$on('RefreshgradeLayingDetails',() => {
                this.loadgradeLayingDetails();
            });            
            Fire.$on('RefreshgradeHatchingDetails',() => {
                this.loadgradeHatchingDetails();
            });
            Fire.$on('RefreshgradeEggSales',() => {
                this.loadgradeEggSales();
            });
             Fire.$on('RefreshgradePoultrySales',() => {
                this.loadgradePoultrySales();
            });
            Fire.$on('RefreshgradeProductOtherUses',() => {
                this.loadgradeProductOtherUses();
            }); 
            Fire.$on('RefreshkienyejiLayingDetails',() => {
                this.loadkienyejiLayingDetails();
            });            
            Fire.$on('RefreshkienyejiHatchingDetails',() => {
                this.loadkienyejiHatchingDetails();
            });
            Fire.$on('RefreshkienyejiEggSales',() => {
                this.loadkienyejiEggSales();
            });
             Fire.$on('RefreshkienyejiPoultrySales',() => {
                this.loadkienyejiPoultrySales();
            });
            Fire.$on('RefreshkienyejiProductOtherUses',() => {
                this.loadkienyejiProductOtherUses();
            });
            Fire.$on('RefreshikienyejiLayingDetails',() => {
                this.loadikienyejiLayingDetails();
            });            
            Fire.$on('RefreshikienyejiHatchingDetails',() => {
                this.loadikienyejiHatchingDetails();
            });
            Fire.$on('RefreshikienyejiEggSales',() => {
                this.loadikienyejiEggSales();
            });
             Fire.$on('RefreshikienyejiPoultrySales',() => {
                this.loadikienyejiPoultrySales();
            });
            Fire.$on('RefreshikienyejiProductOtherUses',() => {
                this.loadikienyejiProductOtherUses();
            }); 
            Fire.$on('RefreshexoticLayingDetails',() => {
                this.loadexoticLayingDetails();
            });            
            Fire.$on('RefreshexoticHatchingDetails',() => {
                this.loadexoticHatchingDetails();
            });
            Fire.$on('RefreshexoticEggSales',() => {
                this.loadexoticEggSales();
            });
             Fire.$on('RefreshexoticPoultrySales',() => {
                this.loadexoticPoultrySales();
            });
            Fire.$on('RefreshexoticProductOtherUses',() => {
                this.loadexoticProductOtherUses();
            }); 
            Fire.$on('RefreshhybridLayingDetails',() => {
                this.loadhybridLayingDetails();
            });            
            Fire.$on('RefreshhybridHatchingDetails',() => {
                this.loadhybridHatchingDetails();
            });
            Fire.$on('RefreshhybridEggSales',() => {
                this.loadhybridEggSales();
            });
             Fire.$on('RefreshhybridPoultrySales',() => {
                this.loadhybridPoultrySales();
            });
            Fire.$on('RefreshhybridProductOtherUses',() => {
                this.loadhybridProductOtherUses();
            });                                                          
            console.log('Component mounted.')
        }
    }
</script>
