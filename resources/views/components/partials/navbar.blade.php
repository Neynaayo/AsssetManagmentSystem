<nav class="navbar navbar-expand-lg bg-gradient shadow sticky-top">
  <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse   
navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link active nav-hover" href="{{ url('/dashboard') }}">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link active nav-hover" href="{{ url('Asset') }}">View Asset</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link active nav-hover" href="{{ url('Asset/import') }}">Import Excel</a>
              </li>
          </ul>

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="nav-link active nav-hover logout-button">
                          Logout
                      </button>
                  </form>
              </li>
          </ul>
      </div>
  </div>
</nav>

<style>
/* Gradient background for navbar */
.bg-gradient {
  background: linear-gradient(90deg, #007bff, #00d4ff);
  color: #fff;
}

.navbar .nav-link {
  color: #fff;
  font-weight: 500;
  transition: color 0.3s, transform 0.3s, box-shadow 0.3s;
  text-decoration: none;
  margin-right: 15px;
}

.navbar .nav-link.nav-hover:hover {
  color: #000; /* Changed hover color to black */
  text-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.logout-button {
  color: #000;
  background-color: #fff; 
  border-radius: 5px;
  padding: 5px 10px;
  cursor: pointer;
  border: none;
  font-weight: 500;
  transition: background-color 0.3s;
}

.logout-button:hover {
  background-color: #0056b3; /* Darker blue on hover */
  color: #000;
}

.navbar-brand {
  font-size: 1.5rem;
  font-weight: bold;
  color: #fff;
  transition: color 0.3s;
}

.navbar-brand:hover {
  color: #000;
}

.navbar-toggler-icon {
  filter: invert(1);
}

.sticky-top {
  z-index: 1030;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
