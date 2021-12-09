<template>
    <div class="container">
        <div class="row mt-3">
         <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-green card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="user.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{form.name}}</h3>

                <p class="text-muted text-center">{{form.role}}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Animals</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Crops</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Poultry</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#trial" class="btn btn-primary btn-block"><b>About Me</b></a>
              </div>
              <div class="card-body" id="trial">
                        <div class="form-group">
                           <strong><i class="fas fa-book mr-1"></i> Name</strong>
                            <input v-model="form.name" type="text" name="name"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" /> 
                        </div>                  

                        <div class="form-group">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Email</strong>
                            <input v-model="form.email" type="email" name="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" /> 
                        </div> 

                        <div class="form-group">
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Password</strong>
                            <input v-model="form.password" type="password" name="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" /> 
                        </div> 


                        <div class="form-group">
                            <strong><i class="far fa-file-alt mr-1"></i> Bio</strong>
                            <input v-model="form.bio" type="text" name="bio"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                <div v-if="form.errors.has('bio')" v-html="form.errors.get('bio')" /> 
                        </div>  
                      </div>              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    email: '',
                    role: '',
                    password: '',
                    bio: ''                   
                })
            }
        },
        mounted() {
            axios.get('api/profile').then(({data}) =>  (this.form.fill(data)));          
            console.log('Component mounted.')
        }
    }
</script>
