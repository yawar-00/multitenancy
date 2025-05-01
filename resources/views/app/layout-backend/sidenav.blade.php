<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.sidebar {
  width: 250px;
  height: 100vh;
  background-color:#bfc7a4;
  color: #fff;
  transition: all 0.3s ease;
  overflow: hidden;
  /* position:fixed; */

  
}


.top{
  margin:20px 0 20px 20px;
  width:20px;
  /* height:12px; */
  position:fixed;
  top:5px
 
}
.top:hover{
  background-color: #00b894;
  
}
.top i{
  font-size:20px;
}

.nav-links {
  list-style: none;
  padding: 0;

 
}

.nav-links li {
  margin: 10px 0;
  overflow:hidden;
}

.nav-links a {
  color: white;
  display: flex;
  align-items: center;
  padding: 12px 20px;
  text-decoration: none;
  transition: background 0.3s;
  
}


.nav-links a i {
  width: 25px;
  font-size: 18px;
  text-align: center;
}

.nav-links a span {
  margin-left: 15px;
  transition: opacity 0.3s;
}

.sidebar.collapsed .nav-links a{
  height:50px;
}
.sidebar.collapsed a span {
  opacity: 0;
  visibility: hidden;
}

.nav-links a:hover {
  background-color: #00b894;
  border-radius: 4px;
}
.active {
  font-weight: bold;
  background-color: #00b894;
  color: white;
  border-radius: 5px;
  padding: 5px 10px;
}


.sidebar.collapsed {

  width:60px;
}



</style>
<div class="sidebar" id="sidebar"> 
  <div class="top">
    <i class="fa-solid fa-bars" ></i>
    </div> 
    <ul class="nav-links">
  <li>
    <a href="{{ url('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
      <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="{{ url('/dashboard/products') }}" class="{{ request()->is('dashboard/products') ? 'active' : '' }}">
      <i class="fas fa-box"></i><span>Products</span>
    </a>
  </li>
  <li>
    <a href="{{ url('/dashboard/banners') }}" class="{{ request()->is('/dashboard/banners') ? 'active' : '' }}">
    <i class="fa-regular fa-calendar-check"></i><span>Banner Control</span>
    </a>
    <li>
    <a href="{{url('admin/about-us')}}" class="{{ request()->is('admin/abuot-us') ? 'active' : '' }}">
      <i class="fas fa-cogs"></i><span>About Us Control</span>
    </a>
  </li>
 
    <form method="POST" action="{{ url('tenantlogout') }}">
      @csrf
    <a href="{{url('tenantlogout')}}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown">
      <i class="fas fa-sign-out-alt"></i><span>Logout</span>
    </a>
  </form>  
  </li>
</ul>

  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.querySelector(".top");

    toggleBtn.addEventListener("click", function () {
      sidebar.classList.toggle("collapsed");
    });
  });
</script>
