@section('head.title', 'Funções | Atualizar')
@section('page.title', "Atualização do função {$role->title}")

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="store">
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('role.title') is-invalid @enderror">Título</label>
                    <div class="col-md-10">
                        <input class="form-control @error('role.title') is-invalid @enderror" placeholder="usuário mestre" wire:model="role.title">
                        @error('role.title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-2 col-form-label @error('role.title') is-invalid @enderror">Permissões</label>
                    <div class="col-md-10 row mt-2">
                        @foreach($permissions as $index => $permission)
                        <div class="form-check col-lg-3">
                            <input class="form-check-input" type="checkbox" id="route-{{$permission->id}}" value="{{$permission->id}}" wire:model="rolePermissions" name="rolePermissions[]">
                            <label class="form-check-label"  for="route-{{$permission->id}}">
                                {{$permission->route_name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row text-center mt-4">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary w-md">Atualizar</button>
                        <a href="{{route('roles.index')}}" class="btn btn-danger w-md">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>