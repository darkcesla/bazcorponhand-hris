@extends('layout.main')

@section('title', 'Divisi')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('lte/dist/img/user4-128x128.jpg')}}"alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Nina Mcintire</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Informasi Pribadi</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Informasi Pekerjaan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <div class="row">
                                <div class="col-md-6">
                                    <small class="card-text text-uppercase">About</small>
                                    <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-account-outline mdi-24px"></i><span class="fw-medium mx-2">Full Name:</span> <span>John Doe</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-check mdi-24px"></i><span class="fw-medium mx-2">Status:</span> <span>Active</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-star-outline mdi-24px"></i><span class="fw-medium mx-2">Role:</span> <span>Developer</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-flag-outline mdi-24px"></i><span class="fw-medium mx-2">Country:</span> <span>USA</span></li>
                                    <li class="d-flex align-items-center mb-1"><i class="mdi mdi-translate mdi-24px"></i><span class="fw-medium mx-2">Languages:</span> <span>English</span></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <small class="card-text text-uppercase">Contacts</small>
                                    <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-phone-outline mdi-24px"></i><span class="fw-medium mx-2">Contact:</span> <span>(123) 456-7890</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-message-outline mdi-24px"></i><span class="fw-medium mx-2">Skype:</span> <span>john.doe</span></li>
                                    <li class="d-flex align-items-center mb-1"><i class="mdi mdi-email-outline mdi-24px"></i><span class="fw-medium mx-2">Email:</span> <span>john.doe@example.com</span></li>
                                    </ul>
                                    <small class="card-text text-uppercase">Teams</small>
                                </div>
                    </div>
                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <div class="row">
                                <div class="col-md-6">
                                    <small class="card-text text-uppercase">Pekerjaan</small>
                                    <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-account-outline mdi-24px"></i><span class="fw-medium mx-2">Full Name:</span> <span>John Doe</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-check mdi-24px"></i><span class="fw-medium mx-2">Status:</span> <span>Active</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-star-outline mdi-24px"></i><span class="fw-medium mx-2">Role:</span> <span>Developer</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-flag-outline mdi-24px"></i><span class="fw-medium mx-2">Country:</span> <span>USA</span></li>
                                    <li class="d-flex align-items-center mb-1"><i class="mdi mdi-translate mdi-24px"></i><span class="fw-medium mx-2">Languages:</span> <span>English</span></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <small class="card-text text-uppercase">Kontrak</small>
                                    <ul class="list-unstyled my-3 py-1">
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-phone-outline mdi-24px"></i><span class="fw-medium mx-2">Contact:</span> <span>(123) 456-7890</span></li>
                                    <li class="d-flex align-items-center mb-3"><i class="mdi mdi-message-outline mdi-24px"></i><span class="fw-medium mx-2">Skype:</span> <span>john.doe</span></li>
                                    <li class="d-flex align-items-center mb-1"><i class="mdi mdi-email-outline mdi-24px"></i><span class="fw-medium mx-2">Email:</span> <span>john.doe@example.com</span></li>
                                    </ul>
                                    <small class="card-text text-uppercase">Teams</small>
                                </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
@stop