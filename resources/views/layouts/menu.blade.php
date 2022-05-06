<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <router-link to="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link to="/home">
            @can('isAdmin')
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                  <i class="fas fa-tractor nav-icon"></i>
                  <p>Configuration</p>
                </router-link>
              </li>             
            </ul>
            @endcan
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-seedling green"></i>
              <p>
                Manage Crops
              </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <router-link to="/preparingfarm" class="nav-link">
                  <i class="fas fa-seedling nav-icon green"></i>
                  <p>Preparing</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/plantingcrops" class="nav-link">
                  <i class="fas fa-seedling nav-icon green"></i>
                  <p>Planting</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/weedingcrops" class="nav-link">
                  <i class="fas fa-seedling nav-icon green"></i>
                  <p>Weeding</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/harvestingcrops" class="nav-link">
                  <i class="fas fa-seedling nav-icon green"></i>
                  <p>Harvesting</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/cropsales" class="nav-link">
                  <i class="fas fa-money-bill nav-icon green"></i>
                  <p>Crop Sales</p>
                </router-link>
              </li>                                                      
            </ul>            
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-horse-head purple"></i>
              <p>
                Manage Animals
              </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/feedinganimals" class="nav-link">
                  <i class="fas fa-horse-head nav-icon purple"></i>
                  <p>Feeds</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/treatinganimals" class="nav-link">
                  <i class="fas fa-horse-head nav-icon purple"></i>
                  <p>Treatment</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/animalproducts" class="nav-link">
                  <i class="fas fa-horse-head nav-icon purple"></i>
                  <p>Animal Products</p>
                </router-link>
              </li>                                        
            </ul>            
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dove teal"></i>
              <p>
                Manage Poultry
              </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/feedingpoultries" class="nav-link">
                  <i class="fas fa-dove nav-icon teal"></i>
                  <p>Feeds</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/treatingpoultries" class="nav-link">
                  <i class="fas fa-dove nav-icon teal"></i>
                  <p>Treatment</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/poultryproducts" class="nav-link">
                  <i class="fas fa-egg nav-icon teal"></i>
                  <p>Poultry Products</p>
                </router-link>
              </li>                                        
            </ul>            
          </li> 
          
          <li class="nav-item">
            <router-link to="/resources" class="nav-link">
              <i class="nav-icon fas fa-suitcase orange"></i>
              <p>
               Manage Resources
              </p>
            </router-link>
          </li>          

@can('isAdmin')          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard blue"></i>
              <p>
                Reports
              </p>
              <i class="right fas fa-angle-left"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/cropreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Crops Report</p>
                </router-link>
              </li>             
              <li class="nav-item">
                <router-link to="/animalreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Animals Report</p>
                </router-link>
              </li>                 
              <li class="nav-item">
                <router-link to="/poultryreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Poultry Report</p>
                </router-link>
              </li> 
              <li class="nav-item">
                <router-link to="/eggreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Egg Report</p>
                </router-link>                
              </li> 
              <li class="nav-item">
                <router-link to="/milkreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Milk Report</p>
                </router-link>                
              </li>               
              <li class="nav-item">
                <router-link to="/overallreports" class="nav-link">
                  <i class="fas fa-clipboard nav-icon blue"></i>
                  <p>Overall Report</p>
                </router-link>                
              </li>                  
            </ul>
          </li>          

          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
               Manage Users
              </p>
            </router-link>
          </li>          
@endcan
          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
               Profile
              </p>
            </router-link>
          </li>
          <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>      

        </ul>
      </nav>