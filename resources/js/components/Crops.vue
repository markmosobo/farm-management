<template>
    <div class="container">
        <div class="row mt-3">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Crops</h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Subsistence</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Cash Crop</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Subsistence/CashCrop</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Details</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-primary" @click="subcropModal">
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
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed Used</th>
                                <th>Fertilizer Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Beans</td>
                                <td>0.25</td>
                                <td>2 bags  </td>
                                <td><span class="badge bg-danger">CAN</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->

                        <!-- Subsistence Crop Modal -->
                        <div class="modal fade" id="subCrop" tabindex="-1" role="dialog" aria-labelledby="subCrop" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" v-show="!editmode">Create New Planting Detail</h5>
                                    <h5 class="modal-title" v-show="editmode">Edit Planting Detail</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form @submit.prevent="editmode ? updatesubPlantingDetail() : createsubPlantingDetail()">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Crop</label>
                                            <select class="form-control" :class="{ 'is-invalid': form.errors.has('crop_id') }" v-model="form.crop_id">
                                            <option value="">Select Crop</option>
                                            <option 
                                                v-for="crop in subcropslist" :key="crop.id"
                                                :value="crop.id"
                                                :selected="crop.id == form.crop_id">{{ crop.name }}</option>
                                            </select>
                                            <div v-if="form.errors.has('crop_id')" v-html="form.errors.get('crop_id')" />
                                        </div> 
                                        <div class="form-group">
                                            <label>Date of Planting</label>
                                            <input v-model="form.planting_date" type="date" name="planting_date"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('planting_date') }">
                                                <div v-if="form.errors.has('planting_date')" v-html="form.errors.get('planting_date')" /> 
                                        </div>
                                        <div class="form-group">
                                            <label>Fertilizer Applied</label>  
                                                    <select v-model="form.fertilizer_type" id="fertilizer_type"
                                                    name="fertilizer_type" class="form-control" :class="{ 'is-invalid': form.errors.has('fertilizer_type') }">
                                                    <option value="">Select Fertilizer Type</option>
                                                    <option value="CAN">CAN</option>
                                                    <option value="DAP">DAP</option>
                                                    <option value="NPK">NPK</option>
                                                    </select>
                                                    <div v-if="form.errors.has('fertilizer_type')" v-html="form.errors.get('fertilizer_type')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Quantity of Fertilizer Applied</label>  
                                                    <textarea v-model="form.fertilizer_quantity" id="fertilizer_quantity"
                                                    name="fertilizer_quantity" placeholder="Brief description of the quantity(e.g 2 bags)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('fertilizer_quantity')" v-html="form.errors.get('fertilizer_quantity')" />
                                        </div>                                                                                
                                        <div class="form-group">
                                            <label>Quantity of Seed Used</label>  
                                                    <textarea v-model="form.seed_quantity" id="seed_quantity"
                                                    name="seed_quantity" placeholder="Brief description of the quantity(e.g 2 packets)" class="form-control">
                                                    </textarea>
                                                    <div v-if="form.errors.has('seed_quantity')" v-html="form.errors.get('seed_quantity')" />
                                        </div>  
                                        <div class="form-group">
                                            <label>Acreage Planted</label>
                                            <input v-model="form.acreage" type="text" name="acreage" placeholder="In acres(approx)"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('acreage') }">
                                                <div v-if="form.errors.has('acreage')" v-html="form.errors.get('acreage')" /> 
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
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Labour Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>Crop Planted</th>
                                <th>Number of Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Maize</td>
                                <td>4</td>
                                <td><span class="badge bg-danger">600</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Planting Fertilizer Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Type</th>                                
                                <th>Date Purchased</th>
                                <th>Quantity</th>
                                <th style="width: 40px">Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><span class="badge bg-danger">CAN</span></td>                               
                                <td>10.10.2021</td>
                                <td>10 bags </td>
                                <td><span class="badge bg-danger">55000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                       
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other Planting Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date Paid</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Ploughing</td>
                                <td><span class="badge bg-danger">2000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
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
                            <h3 class="card-title">Crop Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed Used</th>
                                <th>Fertilizer Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Coffee</td>
                                <td>0.25</td>
                                <td>2 bags  </td>
                                <td><span class="badge bg-danger">CAN</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Labour Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>Crop Planted</th>
                                <th>Number of Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Pyrethrum</td>
                                <td>4</td>
                                <td><span class="badge bg-danger">600</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Planting Fertilizer Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Type</th>                                
                                <th>Date Purchased</th>
                                <th>Quantity</th>
                                <th style="width: 40px">Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><span class="badge bg-danger">CAN</span></td>                               
                                <td>10.10.2021</td>
                                <td>10 bags </td>
                                <td><span class="badge bg-danger">55000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                       
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other Planting Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date Paid</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Ploughing</td>
                                <td><span class="badge bg-danger">2000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
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
                            <h3 class="card-title">Crop Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date of Planting</th>
                                <th>Crop Planted</th>
                                <th>Acreage Planted</th>
                                <th>Quantity of Seed Used</th>
                                <th>Fertilizer Used</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Beans</td>
                                <td>0.25</td>
                                <td>2 bags  </td>
                                <td><span class="badge bg-danger">CAN</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->

                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Planting Labour Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-sm">
                            <thead>
                                <tr>
                                <th>Date of Work</th>
                                <th>Crop Planted</th>
                                <th>Number of Person(s)</th>
                                <th>Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Maize</td>
                                <td>4</td>
                                <td><span class="badge bg-danger">600</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-5">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Planting Fertilizer Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th>Type</th>                                
                                <th>Date Purchased</th>
                                <th>Quantity</th>
                                <th style="width: 40px">Amount</th>
                                <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td><span class="badge bg-danger">CAN</span></td>                               
                                <td>10.10.2021</td>
                                <td>10 bags </td>
                                <td><span class="badge bg-danger">55000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                        </div>
                        <!-- /.card -->                       
                       
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other Planting Costs</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th style="width: 10px">Date Paid</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th style="width: 40px">Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>10.10.2021</td>
                                <td>Ploughing</td>
                                <td><span class="badge bg-danger">2000</span></td>
                                <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
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
            return {
               editmode: false,
               form: new Form({
                    crop_id: '',
                    planting_date: '',
                    acreage: '',
                    fertilizer_quantity: '',
                    seed_quantity: '',
                    fertilizer_type: ''
               }),
               subcropslist: {} 
            }
        },
        methods: {
            subcropModal(){
                this.editmode = false;
                this.form.reset();
                $('#subCrop').modal('show');                

            },
            listsubCrops(){
                axios.get('api/subcroplist').then((response) => {
                    this.subcropslist = response.data.data
                });
            }
        },
        mounted() {
            this.listsubCrops();
            console.log('Component mounted.')
        }
    }
</script>
