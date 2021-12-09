<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Animal Product Records</h3>

              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                      <div class="row">
                    <div class="col-md-7">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Cow-Milking Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cowmilkingdetailModal">
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
                                <th style="width: 140px">Date of Milking</th>
                                <th>Cow</th>
                                <th>Milker</th>
                                <th>Quantity</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cowmilkingdetails.data" :key="item.id">
                                <td>{{item.date_of_milking}}</td>
                                <td> {{item.cow_name}}</td>
                                <td>{{item.milker_name}}</td>
                                <td>{{item.milk_quantity}} litres</td>
                                <td>                                  
                                    <a href="#" @click="editcowmilkingdetailModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecowMilkingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Cow Milking Detail Modal -->
                        <div class="modal fade" id="cowMilkingDetail" tabindex="-1" role="dialog" aria-labelledby="cowMilkingDetail" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Milking Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Milking Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecowMilkingDetail() : createcowMilkingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Milking</label>
                                            <input v-model="form.date_of_milking" type="date" name="date_of_milking"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_milking') }">
                                                <div v-if="form.errors.has('date_of_milking')" v-html="form.errors.get('date_of_milking')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Cow's Name/Code</label>
                                            <input v-model="form.cow_name" type="text" name="cow_name"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('cow_name') }">
                                                <div v-if="form.errors.has('cow_name')" v-html="form.errors.get('cow_name')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Milker's Name</label>
                                            <input v-model="form.milker_name" type="text" name="milker_name"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('milker_name') }">
                                                <div v-if="form.errors.has('milker_name')" v-html="form.errors.get('milker_name')" /> 
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Quantity of Milk</label>
                                            <input v-model="form.milk_quantity" type="text" name="milk_quantity" placeholder="in litres(e.g 2)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('milk_quantity') }">
                                                <div v-if="form.errors.has('milk_quantity')" v-html="form.errors.get('milk_quantity')" /> 
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
                        <pagination :data="cowmilkingdetails" @pagination-change-page="getcowMilkingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other-Milking Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="otheranimalmilkModal">
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
                                <th style="width: 140px">Date of Milking</th>
                                <th>Animal</th>
                                <th>Milker</th>
                                <th>Quantity</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in otheranimalmilkingdetails.data" :key="item.id">
                                <td>{{item.date_of_milking}}</td>
                                <td>{{item.animal.name}}</td>
                                <td>{{item.milker_name}}</td>
                                <td>{{item.milk_quantity}} litres</td>
                                <td>                                  
                                    <a href="#" @click="editotheranimalmilkModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteotheranimalMilkingDetail(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- other animal Milk Modal -->
                        <div class="modal fade" id="otheranimalMilk" tabindex="-1" role="dialog" aria-labelledby="otheranimalMilk" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Milking Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Milking Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateotheranimalMilkingDetail() : createotheranimalMilkingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date of Milking</label>
                                            <input v-model="form.date_of_milking" type="date" name="date_of_milking"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_milking') }">
                                                <div v-if="form.errors.has('date_of_milking')" v-html="form.errors.get('date_of_milking')" /> 
                                        </div>                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in milkanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Animal Code</label>
                                            <input v-model="form.animal_code" type="text" name="animal_code"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('animal_code') }">
                                                <div v-if="form.errors.has('animal_code')" v-html="form.errors.get('animal_code')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity Milked</label>
                                            <input v-model="form.milk_quantity" type="text" name="milk_quantity"  placeholder="in litres(e.g 2)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('milk_quantity') }">
                                                <div v-if="form.errors.has('milk_quantity')" v-html="form.errors.get('milk_quantity')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Milker's Name</label>
                                            <input v-model="form.milker_name" type="text" name="milker_name"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('milker_name') }">
                                                <div v-if="form.errors.has('milker_name')" v-html="form.errors.get('milker_name')" /> 
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
                        <pagination :data="otheranimalmilkingdetails" @pagination-change-page="getotheranimalMilkingDetails"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-5">
                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Cow Milk Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="cowmilksaleModal">
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
                                <tr v-for="item in cowmilksales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.quantity_sold}} litres</td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editcowmilksaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletecowMilkSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- cow Milk Sale Modal -->
                        <div class="modal fade" id="cowMilkSale" tabindex="-1" role="dialog" aria-labelledby="cowMilkSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Cow Milk Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Cow Milk Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatecowMilkSale() : createcowMilkSale()">
                                    <div class="modal-body">                                                                               
                                        <div class="form-group">
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity Sold</label>
                                            <input v-model="form.quantity_sold" type="text" name="quantity_sold"  placeholder="in litres(e.g 2)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_sold') }">
                                                <div v-if="form.errors.has('quantity_sold')" v-html="form.errors.get('quantity_sold')" /> 
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
                        <pagination :data="cowmilksales" @pagination-change-page="getcowMilkSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Other-Milk Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="otheranimalmilksaleModal">
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
                                <tr v-for="item in otheranimalmilksales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.quantity_sold}} litres</td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editotheranimalmilksaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteotheranimalMilkSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- otheranimal Milk Sale Modal -->
                        <div class="modal fade" id="otheranimalMilkSale" tabindex="-1" role="dialog" aria-labelledby="otheranimalMilkSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Other Milk Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Other Milk Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateotheranimalMilkSale() : createotheranimalMilkSale()">
                                    <div class="modal-body">                                                                               
                                        <div class="form-group">
                                            <label>Date of Sale</label>
                                            <input v-model="form.date_of_sale" type="date" name="date_of_sale"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('date_of_sale') }">
                                                <div v-if="form.errors.has('date_of_sale')" v-html="form.errors.get('date_of_sale')" /> 
                                        </div> 
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in milkanimalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
                                        </div>                                          
                                        <div class="form-group">
                                            <label>Quantity Sold</label>
                                            <input v-model="form.quantity_sold" type="text" name="quantity_sold"  placeholder="in litres(e.g 2)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('quantity_sold') }">
                                                <div v-if="form.errors.has('quantity_sold')" v-html="form.errors.get('quantity_sold')" /> 
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
                        <pagination :data="otheranimalmilksales" @pagination-change-page="getotheranimalMilkSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card -->                                               

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title"> Animal Sales</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="animalsaleModal">
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
                                <tr v-for="item in animalsales.data" :key="item.id">
                                <td>
                                    {{item.date_of_sale}}
                                </td>
                                <td>{{item.no_sold}} </td>
                                <td><span class="badge bg-warning">{{item.amount_got}}</span></td>
                                <td>                                 
                                    <a href="#" @click="editanimalsaleModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deletanimalSale(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- animal Sale Modal -->
                        <div class="modal fade" id="animalSale" tabindex="-1" role="dialog" aria-labelledby="animalSale" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Animal Sale</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Animal Sale</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateanimalSale() : createanimalSale()">
                                    <div class="modal-body">                                       
                                        <div class="form-group">
                                            <label>Animal</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('animal_id') }" v-model="form.animal_id">
                                            <option value="">Select Animal</option>
                                            <option 
                                                v-for="item in animalslist" :key="item.id"
                                                :value="item.id"
                                                :selected="item.id == form.animal_id">{{ item.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('animal_id')" v-html="form.errors.get('animal_id')" />
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
                        <pagination :data="animalsales" @pagination-change-page="getanimalSales"></pagination>
                        </ul>
                        </div>
                        </div>
                        <!-- /.card --> 

                        <div class="card collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">Other Product Uses</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="animalproductotheruseModal">
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
                                <tr v-for="item in animalproductotheruses.data" :key="item.id">
                                <td>{{item.date_of_retrieval}}</td>
                                <td>{{item.name}}</td>
                                <td>{{item.quantity_used}}</td>
                                <td>                                    
                                    <a href="#" @click="editanimalproductotheruseModal(item)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteanimalproductOtherUse(item.id)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- animal Product Other Use Modal -->
                        <div class="modal fade" id="animalproductOtherUse" tabindex="-1" role="dialog" aria-labelledby="animalproductOtherUse" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Product Other Use</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Product Other Use</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updateanimalproductOtherUse() : createanimalproductOtherUse()">
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
                        <pagination :data="animalproductotheruses" @pagination-change-page="getanimalproductOtherUses"></pagination>
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
                        animal_code: '',
                        amount_paid: '',
                        date_of_payment: '',
                        name: '',
                        no_sold: '',
                        date_of_sale: '',
                        quantity_used: '',
                        quantity_sold: '',
                        milk_quantity: '',
                        cow_name: '',
                        date_of_milking: '',
                        milker_name: ''
                 }),
                 cowmilkingdetails: {},
                 otheranimalmilkingdetails: {},
                 cowmilksales: {},
                 otheranimalmilksales: {},
                 animalslist: {},
                 milkanimalslist: {},
                 animalsales: {},
                 animalproductotheruses: {},
               
             }   
        },
        methods: {
            cowmilkingdetailModal(){
                this.editmode = false;
                this.form.reset();
                $('#cowMilkingDetail').modal('show');                
            },
            editcowmilkingdetailModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cowMilkingDetail').modal('show');
                this.form.fill(item)
            },
            createcowMilkingDetail(){
                this.$Progress.start();                
                this.form.post('api/cowmilkingdetail').then(() => {
                    $('#cowMilkingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Milking detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshcowMilkingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecowMilkingDetail(){
                this.$Progress.start();
                this.form.put('api/cowmilkingdetail/'+this.form.id).then(() => {
                    $('#cowMilkingDetail').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Milking detail has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshcowMilkingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecowMilkingDetail(id){
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
                  this.form.delete('api/cowmilkingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Milking Detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcowMilkingDetails');
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
            otheranimalmilkModal(){
                this.editmode = false;
                this.form.reset();
                $('#otheranimalMilk').modal('show');                
            },
            editotheranimalmilkModal(item){
                this.editmode = true;
                this.form.reset();
                $('#otheranimalMilk').modal('show');
                this.form.fill(item)
            },
            createotheranimalMilkingDetail(){
                this.$Progress.start();
                this.form.post('api/otheranimalmilkingdetail').then(() => {
                    $('#otheranimalMilk').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Milking detail has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshotheranimalMilkingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateotheranimalMilkingDetail(){
                this.$Progress.start();
                this.form.put('api/otheranimalmilkingdetail/'+this.form.id).then(() => {
                    $('#otheranimalMilk').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Milking detail has been updated',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshotheranimalMilkingDetails')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteotheranimalMilkingDetail(id){
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
                  this.form.delete('api/otheranimalmilkingdetail/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Milking detail has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshotheranimalMilkingDetails');
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
            cowmilksaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#cowMilkSale').modal('show');                
            },
            editcowmilksaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#cowMilkSale').modal('show');
                this.form.fill(item)
            },
            createcowMilkSale(){
                this.$Progress.start();
                this.form.post('api/cowmilksale').then(() => {
                    $('#cowMilkSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Milk sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshcowMilkSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updatecowMilkSale(){
                this.$Progress.start();
                this.form.put('api/cowmilksale/'+this.form.id).then(() => {
                    $('#cowMilkSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Milk sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshcowMilkSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deletecowMilkSale(id){
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
                  this.form.delete('api/cowmilksale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Milk sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshcowMilkSales');
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
            otheranimalmilksaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#otheranimalMilkSale').modal('show');                
            },
            editotheranimalmilksaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#otheranimalMilkSale').modal('show');
                this.form.fill(item)
            },
            createotheranimalMilkSale(){
                this.$Progress.start();
                this.form.post('api/otheranimalmilksale').then(() => {
                    $('#otheranimalMilkSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Milk sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshotheranimalMilkSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateotheranimalMilkSale(){
                this.$Progress.start();
                this.form.put('api/otheranimalmilksale/'+this.form.id).then(() => {
                    $('#otheranimalMilkSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Milk sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshotheranimalMilkSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteotheranimalMilkSale(id){
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
                  this.form.delete('api/otheranimalmilksale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Milk sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshotheranimalMilkSales');
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
            animalsaleModal(){
                this.editmode = false;
                this.form.reset();
                $('#animalSale').modal('show');                
            },
            editanimalsaleModal(item){
                this.editmode = true;
                this.form.reset();
                $('#animalSale').modal('show');
                this.form.fill(item)
            },
            createanimalSale(){
                this.$Progress.start();
                this.form.post('api/animalsale').then(() => {
                    $('#animalSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Animal sale has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshanimalSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateanimalSale(){
                this.$Progress.start();
                this.form.put('api/animalsale/'+this.form.id).then(() => {
                    $('#animalSale').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Animal sale has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshanimalSales')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteanimalSale(id){
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
                  this.form.delete('api/animalsale/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Animal sale has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshanimalSales');
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
            animalproductotheruseModal(){
                this.editmode = false;
                this.form.reset();
                $('#animalproductOtherUse').modal('show');                
            },
            editanimalproductotheruseModal(item){
                this.editmode = true;
                this.form.reset();
                $('#animalproductOtherUse').modal('show');
                this.form.fill(item)
            },
            createanimalproductOtherUse(){
                this.$Progress.start();
                this.form.post('api/animalproductotheruse').then(() => {
                    $('#animalproductOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Successful',
                        'Other use has been created',
                        'success'
                      );
                    console.log('success')
                    Fire.$emit('RefreshanimalproductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            }, 
            updateanimalproductOtherUse(){
                this.$Progress.start();
                this.form.put('api/animalproductotheruse/'+this.form.id).then(() => {
                    $('#animalproductOtherUse').modal('hide')
                    this.$Progress.finish();
                    toast.fire(
                        'Updated',
                        'Other use has been updated',
                        'success'
                    )
                    console.log('success')
                    Fire.$emit('RefreshanimalproductOtherUses')
                }).catch(() => {
                    this.$Progress.fail();
                    console.log('error')
                })
            },
            deleteanimalproductOtherUse(id){
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
                  this.form.delete('api/animalproductotheruse/'+id).then(() => {
                  this.$Progress.finish();
                  toast.fire(
                    'Deleted!',
                    'Other use has been deleted.',
                    'success'
                  )
                  Fire.$emit('RefreshanimalproductOtherUses');
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

            listAnimals(){
                axios.get('api/animalslist').then((response) => {
                    this.animalslist = response.data.data
                });
            },
            listmilkAnimals(){
                axios.get('api/milkanimalslist').then((response) => {
                    this.milkanimalslist = response.data.data
                });
            },            
            loadcowMilkingDetails(){
                axios.get('api/cowmilkingdetail').then((response) => {
                    this.cowmilkingdetails = response.data
                });
            },                        
            loadotheranimalMilkingDetails(){
                axios.get('api/otheranimalmilkingdetail').then((response) => {
                    this.otheranimalmilkingdetails = response.data
                });
            },
            loadcowMilkSales(){
                axios.get('api/cowmilksale').then((response) => {
                    this.cowmilksales = response.data
                });
            },
            loadotheranimalMilkSales(){
                axios.get('api/otheranimalmilksale').then((response) => {
                    this.otheranimalmilksales = response.data
                });
            },            
            loadanimalSales(){
                axios.get('api/animalsale').then((response) => {
                    this.animalsales = response.data
                });
            },            
            loadanimalproductOtherUses(){
                axios.get('api/animalproductotheruse').then((response) => {
                    this.animalproductotheruses = response.data
                });
            },

            //pagination
            getcowMilkingDetails(page = 1) {
            axios.get('api/cowmilkingdetail?page=' + page)
                .then(response => {
                    this.cowmilkingdetails = response.data;
                })                
            },            
            getotheranimalMilkingDetails(page = 1) {
            axios.get('api/otheranimalmilkingdetail?page=' + page)
                .then(response => {
                    this.otheranimalmilkingdetails = response.data;
                })                
            },
            getcowMilkSales(page = 1) {
            axios.get('api/cowmilksale?page=' + page)
                .then(response => {
                    this.cowmilksales = response.data;
                })                
            },
            getotheranimalMilkSales(page = 1) {
            axios.get('api/otheranimalmilksale?page=' + page)
                .then(response => {
                    this.otheranimalmilksales = response.data;
                })                
            },            
            getanimalSales(page = 1) {
            axios.get('api/animalsale?page=' + page)
                .then(response => {
                    this.animalsales = response.data;
                })                
            },            
            getanimalproductOtherUses(page = 1) {
            axios.get('api/animalproductotheruse?page=' + page)
                .then(response => {
                    this.animalproductotheruses = response.data;
                })                
            }, 
            
        },
        mounted() {
            this.listAnimals();
            this.listmilkAnimals();
            this.loadcowMilkingDetails();
            this.loadotheranimalMilkingDetails();
            this.loadcowMilkSales();
            this.loadotheranimalMilkSales();
            this.loadanimalSales();
            this.loadanimalproductOtherUses();            

            //event listeners 
            Fire.$on('RefreshcowMilkingDetails',() => {
                this.loadcowMilkingDetails();
            });            
            Fire.$on('RefreshotheranimalMilkingDetails',() => {
                this.loadotheranimalMilkingDetails();
            });
            Fire.$on('RefreshcowMilkSales',() => {
                this.loadcowMilkSales();
            });
            Fire.$on('RefreshotheranimalMilkSales',() => {
                this.loadotheranimalMilkSales();
            });            
             Fire.$on('RefreshanimalSales',() => {
                this.loadanimalSales();
            });
            Fire.$on('RefreshanimalproductOtherUses',() => {
                this.loadanimalproductOtherUses();
            }); 
                                  
            console.log('Component mounted.')
        }
    }
</script>
