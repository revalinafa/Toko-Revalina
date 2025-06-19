<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user mr-1"></i> @yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="fas fa-home mr-1"></i> Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <i class="fas fa-user mr-1"></i> @yield('title')
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Data
                    </button>
                    <div class="btn-group dropleft">
                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-print mr-1"></i> Cetak
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-success" href="#">
                                <i class="fas fa-file-excel mr-1"></i> Excel
                            </a>
                            <a class="dropdown-item text-danger" href="#">
                                <i class="fas fa-file-pdf mr-1"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
              
              <div class="mb-3 d-flex justify-content-between">
                <div class="col-3">
                  <select wire:model.live="paginate" class="form-control" id="">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>

                <div class="col-4">
                  <input wire:model.live="search" type="text" name="search" class="form-control" placeholder="Search...">
                </div>
              </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th><i class="fas fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                      <td>
                                          @if ($item->role == 'superadmin')
                                              <span class="badge badge-primary">Super Admin</span>
                                          @elseif ($item->role == 'admin')
                                              <span class="badge badge-info">Admin</span>
                                          @endif
                                      </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $user->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
