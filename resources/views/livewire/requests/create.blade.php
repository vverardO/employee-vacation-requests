@section('head.title', 'Solicitações | Cadastrar')
@section('page.title', 'Cadastrar uma solicitação')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('request.title') is-invalid @enderror">Título</label>
                    <div class="col-md-10">
                        <input class="form-control @error('request.title') is-invalid @enderror" placeholder="Férias previstas" wire:model="request.title">
                        @error('request.title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Gênero</label>
                    <div class="col-md-10">
                        <select class="form-select @error('request.request_type_id') is-invalid @enderror" wire:model="request.request_type_id">
                            <option>Selecione</option>
                            @foreach($requestTypes as $requestType)
                            <option value="{{$requestType->id}}">{{$requestType->title}}</option>
                            @endforeach
                        </select>
                        @error('request.request_type_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Funcionário</label>
                    <div class="col-md-10">
                        <select class="form-select @error('request.employee_id') is-invalid @enderror" wire:model="request.employee_id">
                            <option>Selecione</option>
                            @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                            @endforeach
                        </select>
                        @error('request.employee_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                <label class="col-md-2 col-form-label @error('request.start') is-invalid @enderror">Início</label>
                    <div class="col-md-10">
                        <input class="form-control @error('request.start') is-invalid @enderror" type="date" wire:model="request.start">
                        @error('request.start')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('request.end') is-invalid @enderror">Fim</label>
                    <div class="col-md-10">
                        <input class="form-control @error('request.end') is-invalid @enderror" type="date" wire:model="request.end">
                        @error('request.end')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                        <a href="{{route('requests.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>