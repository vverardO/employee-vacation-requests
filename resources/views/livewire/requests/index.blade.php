@section('head.title', 'Solicitações | Listagem')
@section('page.title', 'Solicitações')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="search-box ms-2">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" wire:model.debounce.500ms="search" placeholder="Buscar por número, tipo, título, data de inicio ou fim e nome do funcionário">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-inline float-md-end mb-3">
                        <a href="{{route('requests.create')}}" class="btn btn-success waves-effect waves-light">
                            <i class="mdi mdi-plus me-2"></i> Nova Solicitação
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-centered table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Número</th>
                            <th>Título</th>
                            <th>Funcionário</th>
                            <th>Inicio</th>
                            <th>Fim</th>
                            <th>Tipo</th>
                            <th>Status</th>
                            <th style="width: 100px">Aprovar ou Rejeitar</th>
                            <th style="width: 100px">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                        <tr>
                            <td>{{$request->number}}</td>
                            <td>{{$request->title}}</td>
                            <td>{{$request->employee->name}}</td>
                            <td>{{$request->start_formatted}}</td>
                            <td>{{$request->end_formatted}}</td>
                            <td>{{$request->requestType->title}}</td>
                            <td><span class="badge badge-pill badge-soft-{{$request->status->getColor($request->status->value)}} font-size-12">{{$request->status->getName($request->status->value)}}</span></td>
                            <td>
                            @if($request->is_opened)
                                <li class="list-inline-item">
                                    <a type="button" rel="tooltip" wire:click="approve({{$request->id}})" class="text-success" title="Aprovar"><i class="bx bx-check-circle font-size-18"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a type="button" rel="tooltip" wire:click="reject({{$request->id}})" class="text-danger" title="Rejeitar"><i class="bx bx-x-circle font-size-18"></i></a>
                                </li>
                            @else
                                <li class="list-inline-item">
                                    -
                                </li>
                            @endif
                            </td>
                            <td>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <a href="{{route('requests.edit', ['id' => $request->id])}}" class="px-2 text-primary"><i class="bx bx-pencil font-size-18"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#" wire:click="destroy('Request', {{$request->id}})" class="px-2 text-danger"><i class="bx bx-trash-alt font-size-18"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" align="center">Nenhuma informação a ser apresentada</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>