@section('head.title', 'Dashboard')
@section('page.title', 'Dashboard')

<div class="row justify-content-center">
<div class="col-xl-12">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-week label-icon"></i>Solicitações abertas (Semana): <strong>{{$weekRequests}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-primary alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Solicitações para serem avaliadas: <strong>{{$requestsToAvaliate}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Solicitações avaliadas: <strong>{{$requestsToAvaliated}}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-primary alert-label-icon label-arrow" role="alert">
                            <i class="fas fa-calendar-alt label-icon"></i>Funcionários cadastrados (Semana): <strong>{{$employeesCreated}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>