@section('head.title', 'Funcionários | Cadastrar')
@section('page.title', 'Cadastrar um Funcionário')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('employee.name') is-invalid @enderror">Nome</label>
                    <div class="col-md-10">
                        <input class="form-control @error('employee.name') is-invalid @enderror" placeholder="antonio" wire:model="employee.name">
                        @error('employee.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label">Gênero</label>
                    <div class="col-md-10">
                        <select class="form-select @error('employee.gender') is-invalid @enderror" wire:model="employee.gender">
                            <option>Selecione</option>
                            @foreach($genders as $value => $name)
                            <option value="{{$value}}">{{$name}}</option>
                            @endforeach
                        </select>
                        @error('employee.gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('employee.general_record') is-invalid @enderror">RG</label>
                    <div class="col-md-10">
                        <input class="form-control @error('employee.general_record') is-invalid @enderror" placeholder="7289382761" wire:model="employee.general_record">
                        @error('employee.general_record')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('employee.registration_physical_person') is-invalid @enderror">CPF</label>
                    <div class="col-md-10">
                        <input class="form-control @error('employee.registration_physical_person') is-invalid @enderror" placeholder="950.425.060-20" wire:model="employee.registration_physical_person">
                        @error('employee.registration_physical_person')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Cadastrar</button>
                        <a href="{{route('employees.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>